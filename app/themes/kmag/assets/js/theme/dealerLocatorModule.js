import { Loader } from '@googlemaps/js-api-loader';
import haversine from 'haversine';
import scrollIntoView from 'scroll-into-view-if-needed';

const ACTIVE_CLASS = 'uk-active';
const ANIMATION_CLASS = 'uk-animation-fade';
const HIDDEN_CLASS = 'uk-hidden';

const GOOGLE_MAPS_API_KEY = window?.dealer_locator?.maps_api_key ?? null;
const THEME_PATH_URL = window?.dealer_locator?.theme_path_url ?? null;

const urlParams = new URLSearchParams(location.search);
const queryParams = {};
for (const [key, value] of urlParams) {
  queryParams[key] = value;
}

const MOSAIC_HEAD_QUARTERS = { lat: 27.8605, lng: -82.3903 };
const MOSAIC_HQ_ADDRESS = "101 East Kennedy Blvd, Tampa, FL 33602";
const DEFAULT_MAP_ARGS = {
  center: MOSAIC_HEAD_QUARTERS,
  zoom: 10,
};

const defaultMarkerIcon = `${THEME_PATH_URL}assets/images/dealer-locator-map-marker.png`;
const markerLabelDefaults = {
  color: 'var(--color-white)',
  fontSize: '14px',
  fontWeight: 'bold',
  fontFmaily: 'var(--inter-font)',
};
export class DealerLocator {
  constructor(moduleEl) {
    // DOM elements
    this.moduleEl = moduleEl;

    this.locateButtonEl = moduleEl.querySelector('[data-button="locate"]');
    this.submitButtonEl = moduleEl.querySelector('[data-button="submit"]');
    this.clearButtonEl = moduleEl.querySelector('[data-button="clear"]');

    this.locationInputEl = moduleEl.querySelector('[name="location"]');
    this.distanceDropdownEl = moduleEl.querySelector(
      '[data-filter="distance"]'
    );
    this.productDropdownEl = moduleEl.querySelector('[data-filter="products"]');

    this.allDealerEls = moduleEl.querySelectorAll('.dealer-locator__dealer');
    this.visibleDealersListEl = moduleEl.querySelector(
      '.dealer-locator__dealers--visible'
    );
    this.dealerResultsCountEl = moduleEl.querySelector(
      '.dealer-locator__results-count'
    );
    this.noResultsEl = moduleEl.querySelector('.filter__no-results');

    // Data values
    this.loaded = false;
    this.filteredDealers = [];
    this.location = null;
    this.selectedDistance = null;
    this.selectedProducts = [];
    this.queryParams = queryParams;

    // Maps
    this.iconDefaults = {};
    this.map = null;
    this.maps = {
      MapLoader: null,
      Geocoder: null,
      InfoWindow: null,
      LatLngBounds: null,
      Point: null,
      Size: null,
    };

    this.initLocationField();
    this.initDistanceCombobox();
    this.initProductsCombobox();

    this.filterInit();
  }

  // Location input
  initLocationField() {
    if (this.locationInputEl.value.length > 0) {
      this.location = this.locationInputEl.value;

      if (this.location.length > 0) {
        this.submitButtonEl.removeAttribute('disabled');
      } else {
        this.submitButtonEl.disabled = true;
      }
    }

    this.locationInputEl.addEventListener('input', (e) => {
      this.location = e.target.value;
      if (this.location.length > 0) {
        this.submitButtonEl.removeAttribute('disabled');
      } else {
        this.submitButtonEl.disabled = true;
      }
    });
  }

  // Single select distance
  initDistanceCombobox() {
    if (this.distanceDropdownEl !== null) {
      this.distanceDropdownEl.addEventListener(
        'values-changed',
        (e) => {
          this.selectedDistance = e.detail.values()[0];
        },
        false
      );
    }
  }

  // Multi select products
  initProductsCombobox() {
    if (this.productDropdownEl !== null) {
      const applyButtonEl = this.productDropdownEl.querySelector(
        '.item--action button'
      );

      if (this.selectedProducts.length === 0) {
        this.clearButtonEl.classList.add(HIDDEN_CLASS);
        this.clearButtonEl.classList.remove(ANIMATION_CLASS);
      }

      applyButtonEl.addEventListener('click', () => {
        applyButtonEl.disabled = true;

        if (this.selectedProducts.length > 0) {
          this.clearButtonEl.classList.remove(HIDDEN_CLASS);
          this.clearButtonEl.classList.add(ANIMATION_CLASS);
        } else {
          this.clearButtonEl.classList.add(HIDDEN_CLASS);
          this.clearButtonEl.classList.remove(ANIMATION_CLASS);
        }
      });

      this.productDropdownEl.addEventListener(
        'values-changed',
        (e) => {
          this.selectedProducts = e.detail.values() ?? [];
          applyButtonEl.removeAttribute('disabled');

          if (this.selectedProducts.length > 0) {
            this.clearButtonEl.classList.remove(HIDDEN_CLASS);
            this.clearButtonEl.classList.add(ANIMATION_CLASS);
          }
        },
        false
      );

      const clearDropdownEvent = new Event('clear-drodpown-values');
      this.clearButtonEl.addEventListener('click', () => {
        applyButtonEl.disabled = true;
        this.clearButtonEl.classList.remove(ANIMATION_CLASS);
        this.clearButtonEl.classList.add(HIDDEN_CLASS);
        this.productDropdownEl.dispatchEvent(clearDropdownEvent);
      });
    }
  }

  initFormFields() {
    // Submit behavior
    const ENTER_KEY = 13;
    this.submitButtonEl.removeAttribute('disabled');

    const formEl = this.moduleEl.querySelector('form');
    const submitButtonEl = this.submitButtonEl;
    this.locationInputEl.addEventListener('keyup', (e) => {
      const code = e.keyCode || e.which;
      if( code === ENTER_KEY ) {
        e.preventDefault();
        formEl.requestSubmit(submitButtonEl);
      }

    });
    formEl.addEventListener('submit', (e) => {
      // TODO allow enter submitting
      e.preventDefault();
      if (this.location && e.submitter === this.submitButtonEl || e.submitter === formEl) {
        this.maps.Geocoder.geocode(
          { address: this.location },
          (results, status) => {
            if (status === 'OK') {
              this.map.setZoom(10);
              this.searchDealers();
            }
          }
        );
      }
    });

    // TODO add manual geolocate
    // this.locateButtonEl.addEventListener('click', () => {
    //   console.log('do locate');
    // });
  }

  async filterInit() {
    let geocodingLoaded = false;
    let coreLoaded = false;
    let mapsLoaded = false;

    const MapLoader = new Loader({
      apiKey: GOOGLE_MAPS_API_KEY,
      version: 'weekly',
    });
    this.maps.MapLoader = MapLoader;

    // Load google geocoding library
    try {
      const { Geocoder } = await MapLoader.importLibrary('geocoding');
      this.maps.Geocoder = new Geocoder();
      geocodingLoaded = true;
    } catch (e) {
      console.log('Geocoder error', e);
    }

    // Load google core library
    try {
      const { LatLngBounds, Point, Size } = await MapLoader.importLibrary(
        'core'
      );
      this.maps.LatLngBounds = LatLngBounds;
      this.maps.Point = Point;
      this.maps.Size = Size;

      coreLoaded = true;
    } catch (e) {
      console.log('Core error', e);
    }

    if (coreLoaded) {
      const { Point, Size } = this.maps;

      this.iconDefaults = {
        anchor: new Point(0, 39),
        labelOrigin: new Point(13, 16),
        origin: new Point(0, 0),
        scaledSize: new Size(26, 39),
      };
    }

    // Load google maps library and setup map
    try {
      const { InfoWindow, Map } = await MapLoader.importLibrary('maps');
      this.maps.InfoWindow = InfoWindow;

      const mosaicHeadquartersCoords = { lat: 27.8605, lng: -82.3903 };

      const mapEl = document.querySelector('[data-google-map]');
      this.map = new Map(mapEl, DEFAULT_MAP_ARGS);
      
      this.location = MOSAIC_HQ_ADDRESS;
      
      this.map.addListener('click', () => {
        this.setAllDealersInactive();
      });

      mapsLoaded = true;
    } catch (e) {
      console.log('Maps error', e);
    }

    if (!mapsLoaded || !geocodingLoaded) {
      console.log('error loading maps');
      return;
    }

    try {
      const mapData = await this.getInitMapData();
      
      if (mapData) {
        if (!this.location) {
          this.location = await this.reverseGeoCode(mapData.center);
          this.locationInputEl.value = this.location;
        }

        this.locateButtonEl.remove();
        this.searchDealers(mapData.center);
      } else {
        // Could not get position from query params or navigator geolocate - possibly blocked by user/OS
        this.locateButtonEl.remove();
      }
    } catch (e) {
      console.log('Error getting map data', e);
    }

    this.loaded = true;

    // Setup module events and data
    this.initFormFields();
    this.searchDealers();
  }

  // Determine location
  getInitMapData() {
    return new Promise((resolve, reject) => {
      const { address, latitude, longitude, location } = this.queryParams;

      if (address) {
        this.location = address;
        this.locationInputEl.value = address;
        this.geoCodeLocation(address).then((geoData) => {
          resolve(this.formatMapData(geoData.latitude, geoData.longitude));
        });
      } else if (location) {
        this.location = location;
        this.locationInputEl.value = location;
        this.geoCodeLocation(location).then((geoData) => {
          resolve(this.formatMapData(geoData.latitude, geoData.longitude));
        });
      }
      else if (latitude && longitude) {
        resolve(
          this.formatMapData(parseFloat(latitude), parseFloat(longitude))
        );
      } else if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
          (position) => {
            resolve(
              this.formatMapData(
                position.coords.latitude,
                position.coords.longitude
              )
            );
          },
          (error) => {
            resolve(null);
          }
        );
      } else {
        resolve(null);
      }
    });
  }

  getDealerDataFromEl(dealerEl) {
    return {
      el: dealerEl.cloneNode(true),
      marker: null,
      infoWindow: null,
      id: dealerEl.dataset.dealerId,
      label: '-',
      name: dealerEl.dataset.dealerName,
      address: dealerEl.dataset.dealerAddress,
      city: dealerEl.dataset.dealerCity,
      state: dealerEl.dataset.dealerState,
      zip: dealerEl.dataset.dealerZip,
      phone: dealerEl.dataset.dealerPhone,
      location: {
        latitude: parseFloat(dealerEl.dataset.dealerLatitude),
        longitude: parseFloat(dealerEl.dataset.dealerLongitude),
      },
      products: dealerEl.dataset.dealerProducts.split(','),
    };
  }

  async searchDealers() {
    if (!this.location) {
      return;
    }

    let locationData = null;

    try {
      locationData = await this.geoCodeLocation(this.location);
      this.clearMapMarkers();
      console.log(locationData);
      this.map.setCenter({
        lat: locationData.latitude,
        lng: locationData.longitude,
      });
    } catch (e) {
      console.log('error', e);
    }

    if (!locationData) {
      this.noResultsEl.classList.remove(HIDDEN_CLASS);
      this.noResultsEl.classList.add(ANIMATION_CLASS);
      return;
    }
    
    // Setup then filter dealers
    this.filteredDealers = Array.from(this.allDealerEls)
      .map((dealerEl) => {
        const dealer = this.getDealerDataFromEl(dealerEl);
        const distance = haversine(dealer.location, locationData, {
          unit: 'mile',
        });
        dealer.distance = Math.round(distance);
        return dealer;
      })
      .filter((dealer) => {
        let isMatched = false;

        if (this.selectedProducts.length > 0) {
          const hasSelectedProducts = this.selectedProducts.some((product) =>
            dealer.products.includes(product)
          );
          
          if (hasSelectedProducts) {
            isMatched =
              dealer.distance <= parseInt(this.selectedDistance) &&
              hasSelectedProducts;
          }
        } else {
          isMatched = dealer.distance <= parseInt(this.selectedDistance);
        }

        return isMatched;
      })
      .sort((a, b) => {
        return a.distance > b.distance ? 1 : -1;
      });

    this.visibleDealersListEl.innerHTML = '';
    
    // Update deale html info then copy filtered dealers into visible html list
    this.filteredDealers.forEach((dealer, index) => {
      dealer.el.querySelector('.dealer__index').innerHTML = index + 1;
      dealer.el.querySelector(
        '.dealer__distance'
      ).innerHTML = `${dealer.distance} Mi`;
      this.visibleDealersListEl.insertAdjacentElement('beforeend', dealer.el);
      dealer.el.classList.add(ANIMATION_CLASS);
      dealer.el.classList.remove(ACTIVE_CLASS);
      dealer.el.addEventListener('click', this.dealerClickListener(dealer));
    });

    if (this.filteredDealers.length > 0) {
      this.noResultsEl.classList.add(HIDDEN_CLASS);
      this.noResultsEl.classList.remove(ANIMATION_CLASS);
    } else {
      this.noResultsEl.classList.remove(HIDDEN_CLASS);
      this.noResultsEl.classList.add(ANIMATION_CLASS);
    }

    this.dealerResultsCountEl.innerHTML =
      this.filteredDealers.length === 1
        ? '1 Result'
        : `${this.filteredDealers.length} Results`;

    // Handle markers on map
    this.drawMarkers();
  }

  clearMapMarkers() {
    this.filteredDealers.forEach((dealer) => {
      if (dealer.marker) {
        dealer.marker.setMap(null);
      }
    });
  }

  async drawMarkers() {
    const { Marker } = await this.maps.MapLoader.importLibrary('marker');
    const bounds = new this.maps.LatLngBounds();
    console.log(bounds);
    const theme = this.moduleEl.dataset.theme;
    let markerIcon = defaultMarkerIcon;
    if (theme === 'orange') {
      markerIcon = `${THEME_PATH_URL}assets/images/dealer-locator-map-marker-orange.png`;
    }


    this.filteredDealers.forEach((dealer, index) => {
      const latLng = {
        lat: parseFloat(dealer.location.latitude),
        lng: parseFloat(dealer.location.longitude),
      };
      dealer.label = (index + 1).toString();
      dealer.marker = new Marker({
        label: { ...markerLabelDefaults, text: dealer.label },
        icon: { ...this.iconDefaults, url: markerIcon },
        position: latLng,
        optimized: false,
        map: this.map,
      });

      dealer.infoWindow = new this.maps.InfoWindow({
        content: this.getInfoWindowContentHtml(dealer),
      });

      dealer.marker.addListener('click', () => {
        this.setDealerActive(dealer);
        dealer.el.classList.add(ACTIVE_CLASS);
      });

      dealer.marker.setMap(this.map);
      bounds.extend(latLng);
    });
    
    if (this.filteredDealers.length < 1) {
      const { zoom } = DEFAULT_MAP_ARGS;
      // set to default zoom
      this.map.setZoom(zoom)
      // set to bounds of zipcode even if results aren't found
      console.log(bounds);
      this.map.setCenter(bounds);
    } else if (this.filteredDealers.length === 1) {
      this.map.setZoom(10);
    } else {
      this.map.fitBounds(bounds);
    }
  }

  dealerClickListener(dealer) {
    return (event) => {
      this.filteredDealers.forEach((filteredDealer) => {
        filteredDealer.el.classList.remove(ACTIVE_CLASS);
      });
      this.setDealerActive(dealer);
    };
  }

  setDealerActive(dealer) {
    this.setAllDealersInactive();
    const theme = this.moduleEl.dataset.theme;
    let markerIcon = defaultMarkerIcon;
    if (theme === 'orange') {
      markerIcon = `${THEME_PATH_URL}assets/images/dealer-locator-map-marker-orange.png`;
    }

    dealer.marker.setLabel({
      ...markerLabelDefaults,
      text: dealer.label,
    });
    dealer.marker.setIcon({
      ...this.iconDefaults,
      url: markerIcon,
    });

    dealer.infoWindow.open(this.map, dealer.marker);
    dealer.el.classList.add(ACTIVE_CLASS);
    scrollIntoView(dealer.el, {
      behavior: 'smooth',
      block: 'start',
      scrollMode: 'if-needed',
    });
  }

  setAllDealersInactive() {
    const theme = this.moduleEl.dataset.theme;
    let markerIcon = defaultMarkerIcon;
    if (theme === 'orange') {
      markerIcon = `${THEME_PATH_URL}assets/images/dealer-locator-map-marker-orange.png`;
    }


    this.filteredDealers.forEach((dealer) => {
      dealer.marker.setLabel({
        ...markerLabelDefaults,
        text: dealer.label,
      });
      dealer.marker.setIcon({
        ...this.iconDefaults,
        url: markerIcon,
      });

      dealer.el.classList.remove(ACTIVE_CLASS);
      dealer.infoWindow.close();
    });
  }

  geoCodeLocation(address) {
    return new Promise((resolve, reject) => {
      this.maps.Geocoder.geocode({ address }, (response, status) => {
        if (status === 'OK') {
          const location = response[0].geometry.location;
          resolve({
            latitude: location.lat(),
            longitude: location.lng(),
          });
        } else {
          reject();
        }
      });
    });
  }

  reverseGeoCode(center) {
    return new Promise((resolve, reject) => {
      this.maps.Geocoder.geocode({ location: center }, (response, status) => {
        if (status === 'OK') {
          const zip_component = response[0].address_components.find(
            (component) => component.types.includes('postal_code')
          );
          if (zip_component) {
            resolve(zip_component.short_name);
            return;
          }
        }
        reject();
      });
    });
  }

  formatMapData(lat, lng, zoom = 10) {
    return {
      center: { lat, lng },
      zoom,
    };
  }

  getInfoWindowContentHtml(dealer) {
    const directionsUrl = `http://maps.google.com/?q=${dealer.name}, ${dealer.address}, ${dealer.zip}`;

    return `
      <div class="dealer-locator__info-window">
        <div class="dealer-locator__dealer dealer">
          <div class="dealer__content">
            <div class="dealer__contact">
              <div class="dealer__title">
                <p class="dealer__name">${dealer.name}</p>
                <p class="dealer__distance">${dealer.distance} Mi</p>
              </div>
              <div class="dealer__address uk-margin-bottom">
                <p>${dealer.address}</p>
                <p>${dealer.city}, ${dealer.state} ${dealer.zip}</p>
                <p class="dealer__directions">
                  <a href="${directionsUrl}" target="_blank">Get Directions</a>
                </p>
              </div>
              <p class="dealer__phone">${dealer.phone}</p>
            </div>
          </div>
        </div>
      </div>`;
  }
}

export default () => {
  const moduleEls = document.querySelectorAll('.dealer-locator');

  if (moduleEls.length === 0) {
    return;
  }

  if (!GOOGLE_MAPS_API_KEY) {
    console.log('Missing Google Maps API key.');
    return;
  }

  Array.from(moduleEls).forEach((moduleEl) => {
    new DealerLocator(moduleEl);
  });
};
