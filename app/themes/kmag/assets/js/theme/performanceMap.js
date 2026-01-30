import mapboxgl from "mapbox-gl";
import { getCookie, checkRegionCropParams } from "./manageCookies";
/* eslint-env jquery */
const $ = jQuery;
const THEME_PATH_URL = window?.performance_map?.theme_path_url ?? null;
const MAPBOX_API_KEY = window?.performance_map?.maps_api_key ?? null;
const GOOGLE_STORAGE_URL = window?.performance_map?.google_storage_url ?? null;
const FIELD_STUDY_URL = window?.performance_map?.field_study_url ?? null;

const CROPS = {
  CORN: {
    NAME: "corn",
    FORMATTED_NAME: "Corn",
    URL: `${THEME_PATH_URL}assets/images/icon/corn.svg`,
    FILL_COLOR: "rgba(186, 161, 31, 1)",
    STROKE_COLOR: "rgba(186, 161, 31, .25)",
  },
  SPRING_WHEAT: {
    NAME: "spring wheat",
    FORMATTED_NAME: "Spring Wheat",
    URL: `${THEME_PATH_URL}assets/images/icon/spring-wheat.svg`,
    FILL_COLOR: "rgba(165, 69, 34, 1)",
    STROKE_COLOR: "rgba(165, 69, 34, .25)",
  },
  WINTER_WHEAT: {
    NAME: "winter wheat",
    FORMATTED_NAME: "Winter Wheat",
    URL: `${THEME_PATH_URL}assets/images/icon/winter-wheat.svg`,
    FILL_COLOR: "rgba(54, 126, 127, 1)",
    STROKE_COLOR: "rgba(54, 126, 127, .25)",
  },
  SOYBEAN: {
    NAME: "soybean",
    FORMATTED_NAME: "Soybean",
    URL: `${THEME_PATH_URL}assets/images/icon/soybean.svg`,
    FILL_COLOR: "rgba(115, 115, 115, 1)",
    STROKE_COLOR: "rgba(115, 115, 115, .25)",
  },
  CANOLA: {
    NAME: "canola",
    FORMATTED_NAME: "Canola",
    URL: `${THEME_PATH_URL}assets/images/icon/canola.svg`,
    FILL_COLOR: "rgba(171, 181, 42, 1)",
    STROKE_COLOR: "rgba(171, 181, 42, .25)",
  },
};

const PRODUCTS = {
  BIOPATH: {
    NAME: "biopath",
    HTML_NAME: "BioPath<span class='super'>®</span>",
    FORMATTED_NAME: "BioPath®",
  },
  POWERCOAT: {
    NAME: "powercoat",
    HTML_NAME: "PowerCoat<span class='super'>™</span>",
    FORMATTED_NAME: "PowerCoat®",
  },
};

const DEFAULT = {
  CROP: CROPS.CORN,
  PRODUCT: PRODUCTS.BIOPATH,
};

const convertToPointToLatLng = (pointString) => {
  const matches = pointString.match(/POINT\((-?\d+\.\d+) (-?\d+\.\d+)\)/);
  if (matches && matches.length === 3) {
    const longitude = parseFloat(matches[1]);
    const latitude = parseFloat(matches[2]);
    return [longitude, latitude];
  } else {
    return null;
  }
};

const getFeaturesFromRawData = (data) => {
  if (data?.type === "FeatureCollection") {
    // got a geojson response - return its features (descructure Yield)
    return data.features.map((feature) => {
      return {
        ...feature,
        properties: { ...feature.properties, ...feature.properties.Yield },
      };
    });
  }

  if (Array.isArray(data)) {
    // we have an array of objects - convert to features
    return data.map((item) => {
      return {
        type: "Feature",
        properties: { ...item, ...item.Yield },
        geometry: {
          type: "Point",
          coordinates: convertToPointToLatLng(item.coordinates),
        },
      };
    });
  }

  return data;
};

const convertDataToGeoJSON = (payload) => {
  // if we receive an array of properties, convert it to geojson
  return {
    type: "FeatureCollection",
    features: payload,
  };
};

const recreateMapSource = (mapbox, data) => {
  try {
    mapbox.removeLayer("marker_circle");
    mapbox.removeSource("markersData_layer");
  } catch (e) {
    console.log(e);
  }

  mapbox.addSource("markersData_layer", {
    type: "geojson",
    data: convertDataToGeoJSON(data),
    cluster: true,
    clusterMaxZoom: 13,
    clusterRadius: 56,
  });
  mapbox.addLayer({
    id: "marker_circle",
    type: "symbol",
    source: "markersData_layer",
    filter: ["!=", "cluster", true],
  });
};

const filterUnavailableItems = (markersData) => {
  for (const crop of Object.keys(CROPS)) {
    if (
      !markersData.some(
        (marker) => marker.properties.crop.toLowerCase() === CROPS[crop].NAME
      )
    ) {
      //remove crop if we have no data
      const element = document
        .querySelector(`input[value="${CROPS[crop].FORMATTED_NAME}"]`)
        ?.closest("li");
      if (element) {
        element.hidden = true;
      }
    }
  }
  for (const product of Object.keys(PRODUCTS)) {
    if (
      !markersData.some(
        (marker) =>
          marker.properties.product.toLowerCase() === PRODUCTS[product].NAME
      )
    ) {
      // remove product if we have no data
      const element = document
        .querySelector(`input[value="${PRODUCTS[product].NAME}"]`)
        ?.closest("li");
      if (element) {
        element.hidden = true;
      }
    }
  }
};

const fetchDataFromGoogleAPI = async () => {
  try {
    const response = await fetch(GOOGLE_STORAGE_URL);

    if (!response.ok) {
      throw new Error("Failed to fetch data from Google API");
    }

    const data = await response.json();
    return data;
  } catch (error) {
    console.error("Error fetching data from Google API:", error);
    return null;
  }
};

const formatProductName = (name) => {
  switch (name.toLowerCase()) {
    case PRODUCTS.BIOPATH.NAME:
      return PRODUCTS.BIOPATH.FORMATTED_NAME;
    case PRODUCTS.POWERCOAT.NAME:
      return PRODUCTS.POWERCOAT.FORMATTED_NAME;
    default:
      return name.charAt(0).toUpperCase() + name.slice(1);
  }
};

const getformattedHTMLName = (name) => {
  switch (name.toLowerCase()) {
    case PRODUCTS.BIOPATH.NAME:
      return PRODUCTS.BIOPATH.HTML_NAME;
    case PRODUCTS.POWERCOAT.NAME:
      return PRODUCTS.POWERCOAT.HTML_NAME;
    default:
      return name.charAt(0).toUpperCase() + name.slice(1);
  }
};

const initPerformanceMap = async () => {
  if (!document.getElementById("performance-mapbox")) {
    return;
  }

  const filterDropdowns = [
    "listbox-crop",
    "listbox-method",
    "listbox-irrigation",
    "listbox-tillage",
    "listbox-product",
  ];

  const crop = getCookie("crop_cookie");

  let centerCoords = [-95.0, 15.0];
  let defaultZoom = 3;
  let selectedCrop = CROPS.CORN;

  mapboxgl.accessToken = MAPBOX_API_KEY;

  const mapbox = new mapboxgl.Map({
    container: "performance-mapbox",
    style: "mapbox://styles/cwynnintent/cmjbohqyr000101qqbfqz7x5c",
    center: centerCoords,
    logoPosition: "top-right",
    zoom: defaultZoom,
    attributionControl: true,
    maxBounds: [
      [-130.0, 15.0],
      [-60.0, 60.0],
    ],
  });

  const rawData = await fetchDataFromGoogleAPI();

  const markersData = getFeaturesFromRawData(rawData);
  filterUnavailableItems(markersData);

  if (!markersData) {
    return;
  }

  document.getElementById("totalTreatmentYLD").innerHTML =
    markersData?.length ?? 0;

  mapbox.on("load", () => {
    recreateMapSource(mapbox, getFilteredData());

    const markers = {};
    let markersOnScreen = {};

    const createClusterMarker = (props) => {
      const total = props.point_count;
      const fontSize =
        total >= 1000 ? 22 : total >= 100 ? 20 : total >= 10 ? 18 : 16;
      const r = total >= 1000 ? 60 : total >= 100 ? 42 : total >= 10 ? 34 : 28;
      const r0 = Math.round(r * 0.6);
      const w = r * 2;

      let html = `<div>
          <svg width="${w}" height="${w}" viewbox="0 0 ${w} ${w}" text-anchor="middle" style="font: ${fontSize}px sans-serif; display: block">`;

      html += `<circle cx="${r}" cy="${r}" r="${r0}" fill="${selectedCrop.FILL_COLOR}" stroke="${selectedCrop.STROKE_COLOR}" stroke-width="16px" />
          <text dominant-baseline="central" transform="translate(${r}, ${r})" style="color:white">
              ${total}
          </text>
          </svg>
          </div>`;

      const el = document.createElement("div");
      el.innerHTML = html;
      return el.firstChild;
    };

    const updateMarkers = (cache = true) => {
      if (!cache) {
        Object.keys(markers).forEach((key) => delete markers[key]);
      }
      const newMarkers = {};
      const features = mapbox.querySourceFeatures("markersData_layer");

      // for every cluster on the screen, create an HTML marker for it (if we didn't yet),
      // and add it to the map if it's not there already
      for (const feature of features) {
        if (!feature.properties.cluster) {
          // individual markers
          const id = feature.properties.field_id;
          let marker = markers[id];
          if (!marker) {
            marker = markers[id] = new mapboxgl.Marker({
              element: createCustomMarker(feature.properties),
            }).setLngLat(feature.geometry.coordinates);

            marker
              .getElement()
              .addEventListener("click", () =>
                mapbox.flyTo({ center: marker.getLngLat() })
              );

            const YLDDiff =
              feature.properties["Treated with product"] -
              feature.properties["Grower Standard Practice"];
              
            const popupContent = `<div class="popup-container">
              <div class="popup-title-row">
              <div><svg class="icon icon-logo-map-${feature.properties.product}" width="100px" height="60px">
                  <use xlink:href="#icon-logo-map-${feature.properties.product}"></use>
              </svg></div>
              <img src="${getCropIcon(feature.properties.crop)}"/>
              </div>
              <div class="popup-yield">${
                YLDDiff > 0 ? "+" : ""
              } ${YLDDiff.toFixed(2)}<small>bu/ac</small></div>
              <div class="popup-data-row">
              <div>Irrigation: <span>${
                feature.properties.irrigation ?? "N/A"
              }</span></div>
              <div>Method: <span>${
                feature.properties.method ?? "N/A"
              }</span></div>
              <div>Tillage: <span>${
                feature.properties.tillage ?? "N/A"
              }</span></div>
              </div>
              <a href="${FIELD_STUDY_URL}?crop=${
              feature.properties.crop
            }&product=${feature.properties.product}&id=${
              feature.properties.field_id
            }" class="btn btn--secondary popup-button">Field Study Details</a>
            </div>`;

            const popup = new mapboxgl.Popup({
              offset: 25,
              maxWidth: "auto",
              anchor: "bottom",
            }).setHTML(popupContent);

            marker.setPopup(popup).addTo(mapbox);
          }
          newMarkers[id] = marker;
          if (!markersOnScreen[id]) {
            marker.addTo(mapbox);
          }
        } else {
          const coords = feature.geometry.coordinates;
          const id = feature.properties.cluster_id;

          let marker = markers[id];
          if (!marker) {
            const el = createClusterMarker(feature.properties);
            marker = markers[id] = new mapboxgl.Marker({
              element: el,
            }).setLngLat(coords);

            marker.getElement().addEventListener("click", () => {
              mapbox.flyTo({
                center: marker.getLngLat(),
                zoom: mapbox.getZoom() + 2,
              });
            });
          }
          newMarkers[id] = marker;

          if (!markersOnScreen[id]) {
            marker.addTo(mapbox);
          }
        }
      }

      // for every marker we've added previously, remove those that are no longer visible
      for (const id in markersOnScreen) {
        if (!newMarkers[id]) {
          markersOnScreen[id].remove();
        }
      }
      markersOnScreen = newMarkers;
    };

    filterDropdowns.forEach((dropdownId) => {
      const dropdownElement = document.getElementById(dropdownId);

      // get initially filtered data by crop and product selection
      const filterKey = dropdownId.replace("listbox-", "");
      const initialData = getFilteredData(true);
      const availableFilters = [
        ...new Set(
          initialData.map((d) => d?.properties?.[filterKey]?.toLowerCase?.())
        ),
      ];

      if (!dropdownElement) {
        console.error("Dropdown element not found:", dropdownId);
        return;
      }

      const checkboxes = dropdownElement.querySelectorAll("input.uk-checkbox");

      checkboxes.forEach((checkbox) => {
        if (!["crop", "product"].includes(filterKey)) {
          // disable filter option
          const checkboxContainer = checkbox.closest("label.item");
          const isAvailable = availableFilters.includes(checkbox.value);
          checkboxContainer.ariaDisabled = !isAvailable;
          checkbox.disabled = !isAvailable;
          checkbox.ariaDisabled = !isAvailable;
        }

        checkbox.addEventListener("change", () => {
          const filters = {};
          const id = dropdownId;
          const checkedBox = document.querySelector(
            `#${id} input.uk-checkbox:checked`
          );
          if (["listbox-product", "listbox-crop"].includes(id)) {
            // disable deselecting filter for crops and products
            document
              .querySelectorAll(`#${id} input.uk-checkbox`)
              .forEach((c) => (c.disabled = false));
            checkedBox.disabled = true;
          }
          filters[id] = checkedBox ? checkedBox.value : "";

          const labelDiv = document.querySelector(
            `#combo-${id.replace("listbox-", "")} .cn-dropdown__label`
          );
          if (labelDiv && id === "listbox-product") {
            labelDiv.textContent = checkedBox
              ? formatProductName(checkedBox.value)
              : "Select";
          } else if (labelDiv) {
            labelDiv.textContent = checkedBox
              ? checkedBox.value.charAt(0).toUpperCase() +
                checkedBox.value.slice(1)
              : "Select";
          }
          recreateMapSource(mapbox, getFilteredData());
          updateMarkers(false);
        });
      });
    });

    mapbox.on("render", () => {
      if (!mapbox.isSourceLoaded("markersData_layer")) return;
      updateMarkers();

      const filteredData = getFilteredData();
      updateAveragesInView(filteredData);

      filterDropdowns.forEach((dropdownId) => {
        const dropdownElement = document.getElementById(dropdownId);

        // get initially filtered data by crop and product selection
        const filterKey = dropdownId.replace("listbox-", "");
        const initialData = getFilteredData(true);
        const availableFilters = [
          ...new Set(
            initialData.map((d) => d?.properties?.[filterKey]?.toLowerCase?.())
          ),
        ];
        const checkboxes =
          dropdownElement.querySelectorAll("input.uk-checkbox");

        checkboxes.forEach((checkbox) => {
          if (!["crop", "product"].includes(filterKey)) {
            // disable filter option
            const checkboxContainer = checkbox.closest("label.item");
            const isAvailable = availableFilters.includes(checkbox.value);
            checkboxContainer.ariaDisabled = !isAvailable;
            checkbox.disabled = !isAvailable;
            checkbox.ariaDisabled = !isAvailable;
          }
        });
      });
    });
    updateMarkers();
    clearAllFilters(); // for sanity
  });

  const updateAveragesInView = (filteredData) => {
    const bounds = mapbox.getBounds();
    const inViewData = filteredData.filter((item) => {
      if (!item.geometry.coordinates) {
        return false;
      }
      return bounds.contains(item.geometry.coordinates);
    });

    let YLDDiffSum = 0;
    let YLDDiffCount = 0;

    inViewData.forEach((item) => {
      if (
        item.properties["Treated with product"] &&
        item.properties["Grower Standard Practice"]
      ) {
        const YLDDiff =
          item.properties["Treated with product"] -
          item.properties["Grower Standard Practice"];

        if (!isNaN(YLDDiff)) {
          YLDDiffSum += YLDDiff;
          YLDDiffCount++;
        }
      }
    });

    const avgYLDDiff =
      YLDDiffCount >= 10
        ? (YLDDiffSum / YLDDiffCount > 0 ? "+" : "") +
          (YLDDiffSum / YLDDiffCount).toFixed(2)
        : "N/A";

    document.getElementById("countTreatmentYLD").innerText = YLDDiffCount;

    document.getElementById("avgYLDDiff").innerHTML =
      avgYLDDiff + (avgYLDDiff !== "N/A" ? " <small>bu/ac</small>" : "");
  };

  const getCurrentFilters = (initial = false) => {
    const currentFilters = {};
    filterDropdowns.forEach((filterId) => {
      const actualId = filterId.replace("listbox-", "");
      const listbox = document.getElementById(`listbox-${actualId}`);
      const checkedCheckbox = listbox
        ? listbox.querySelector("input.uk-checkbox:checked")
        : null;
      currentFilters[filterId] = checkedCheckbox
        ? checkedCheckbox.value.toLowerCase()
        : "";
    });
    if (initial) {
      //only return initial filters (crop & product)
      return {
        "listbox-crop": currentFilters["listbox-crop"],
        "listbox-product": currentFilters["listbox-product"],
      };
    }
    return currentFilters;
  };

  const getFilteredData = (initial = false) => {
    const currentFilters = getCurrentFilters(initial);

    switch (currentFilters["listbox-crop"]) {
      case "corn":
        selectedCrop = CROPS.CORN;
        break;
      case "spring wheat":
        selectedCrop = CROPS.SPRING_WHEAT;
        break;
      case "winter wheat":
        selectedCrop = CROPS.WINTER_WHEAT;
        break;
      case "soybean":
        selectedCrop = CROPS.SOYBEAN;
        break;
      case "canola":
        selectedCrop = CROPS.CANOLA;
    }

    return markersData.filter((item) => {
      return Object.entries(currentFilters).every(([key, filterValue]) => {
        if (filterValue === "") return true;

        const dataKey = key.replace("listbox-", "");
        const itemValue = item.properties[dataKey];
        return itemValue
          ? itemValue.toString().toLowerCase() === filterValue
          : false;
      });
    });
  };

  const createCustomMarker = (props) => {
    let markerIcon;
    const cropLowerCase = props.crop.toLowerCase();

    switch (cropLowerCase) {
      case "corn":
        markerIcon = CROPS.CORN.URL;
        break;
      case "spring wheat":
        markerIcon = CROPS.SPRING_WHEAT.URL;
        break;
      case "winter wheat":
        markerIcon = CROPS.WINTER_WHEAT.URL;
        break;
      case "soybean":
        markerIcon = CROPS.SOYBEAN.URL;
        break;
      case "canola":
        markerIcon = CROPS.CANOLA.URL;
        break;
      default:
        markerIcon = `${THEME_PATH_URL}assets/images/truresponse-default-marker.svg`;
    }

    const markerElement = document.createElement("div");
    markerElement.className = "custom-marker";
    markerElement.style.backgroundImage = `url(${markerIcon})`;
    markerElement.style.width = "25px";
    markerElement.style.height = "25px";
    markerElement.style.backgroundSize = "contain";
    markerElement.style.backgroundRepeat = "no-repeat";
    return markerElement;
  };

  if (crop) {
    let cookieCropValue = crop.toLowerCase();
    let dropdownCropValue;

    if (cookieCropValue.includes("wheat")) {
      dropdownCropValue = "wheat";
    } else if (cookieCropValue.includes("corn")) {
      dropdownCropValue = "corn";
    } else {
      return;
    }

    const checkbox = document.querySelector(
      `#listbox-crop input[value="${dropdownCropValue}"]`
    );
    if (checkbox) {
      checkbox.checked = true;

      const parentLabel = checkbox.closest(".item");
      if (parentLabel) {
        parentLabel.classList.add("uk-active");
      }

      const labelDiv = document.querySelector(
        "#combo-crop .cn-dropdown__label"
      );
      if (labelDiv) {
        labelDiv.textContent =
          dropdownCropValue.charAt(0).toUpperCase() +
          dropdownCropValue.slice(1);
      }
    }
  }

  mapbox.on("moveend", () => {
    const filteredData = getFilteredData();
    updateAveragesInView(filteredData);
  });

  const geocodeZip = async (zipCode) => {
    const url = `https://api.mapbox.com/geocoding/v5/mapbox.places/${zipCode}.json?access_token=${MAPBOX_API_KEY}&country=us&types=postcode`;

    try {
      const response = await fetch(url);
      const data = await response.json();
      const coordinates = data.features[0].center;
      return coordinates;
    } catch (error) {
      console.error("Geocoding error:", error);
      return null;
    }
  };

  document
    .getElementById("searchButton")
    .addEventListener("click", async (event) => {
      event.preventDefault();
      const zipCode = document.getElementById("zip").value;
      if (zipCode) {
        const coordinates = await geocodeZip(zipCode);
        if (coordinates) {
          mapbox.flyTo({ center: coordinates, zoom: 7 });
        } else {
          console.error("Unable to find location for the provided ZIP code.");
        }
      }
      // collapse filters and hide overlay on mobile
      if (window.innerWidth < 640) {
        const filterContainer = document.getElementById("filter-container");
        filterContainer.setAttribute("aria-expanded", false);
        filterContainer.hidden = true;
        document
          .getElementsByClassName("performance-map")[0]
          .classList.remove("overlay");
      }
    });

  const clearAllFilters = () => {
    filterDropdowns.forEach((dropdownId) => {
      const dropdownButton = document.getElementById(
        `combo-${dropdownId.replace("listbox-", "")}`
      );
      if (dropdownButton) {
        const labelDiv = dropdownButton.querySelector(".cn-dropdown__label");
        if (labelDiv) {
          labelDiv.textContent = "Select";
        }
      }

      const listbox = document.getElementById(dropdownId);
      if (listbox) {
        const checkboxes = listbox.querySelectorAll("input.uk-checkbox");
        checkboxes.forEach((checkbox) => {
          checkbox.checked = false;
        });

        const activeItems = listbox.querySelectorAll(".uk-active");
        activeItems.forEach((item) => {
          item.classList.remove("uk-active");
        });
      }

      // handle reset to corn by default
      if (dropdownId.includes("crop")) {
        const cornCheckbox = listbox.querySelector(
          `input.uk-checkbox[value="${DEFAULT.CROP.FORMATTED_NAME}"]`
        );
        // enable checkbox in case it's selected
        cornCheckbox.disabled = false;
        cornCheckbox.click();
      }

      // handle reset to biopath by default
      if (dropdownId.includes("product")) {
        const biopathCheckbox = listbox.querySelector(
          `input.uk-checkbox[value="${DEFAULT.PRODUCT.NAME}"]`
        );
        // enable checkbox in case it's selected
        biopathCheckbox.disabled = false;
        biopathCheckbox.click();
      }
    });
  };

  document
    .getElementById("clearFiltersButton")
    .addEventListener("click", (event) => {
      event.preventDefault();
      clearAllFilters();
    });

  const getCropIcon = (crop) => {
    switch (crop.toLowerCase()) {
      case "corn":
        return CROPS.CORN.URL;
      case "soybean":
        return CROPS.SOYBEAN.URL;
      case "winter wheat":
        return CROPS.WINTER_WHEAT.URL;
      case "spring wheat":
        return CROPS.SPRING_WHEAT.URL;
      case "canola":
        return CROPS.CANOLA.URL;
    }
  };

  document
    .getElementById("listbox-crop")
    .querySelectorAll(".item")
    .forEach((item) => {
      const el = document.createElement("img");
      el.style.height = "24px";
      const value = item.querySelector("[type=checkbox]").value;
      el.src = getCropIcon(value);
      item.appendChild(el);
    });

  // handle show/hide filters in mobile
  document
    .getElementById("filter-expand-button")
    .addEventListener("click", (event) => {
      const button = event.target;
      const expanded = button.getAttribute("aria-expanded") === "true";
      button.setAttribute("aria-expanded", "" + !expanded);
      const filterContainer = document.getElementById(
        button.getAttribute("aria-controls")
      );
      filterContainer.setAttribute("aria-expanded", !expanded);
      filterContainer.hidden = expanded;
      if (expanded) {
        document
          .getElementsByClassName("performance-map")[0]
          .classList.remove("overlay");
      } else {
        document
          .getElementsByClassName("performance-map")[0]
          .classList.add("overlay");
      }
    });

  // show filters if viewport changes to tablet/desktop
  let debouncer;
  window.addEventListener("resize", () => {
    clearTimeout(debouncer);
    debouncer = setTimeout(() => {
      if (window.innerWidth > 639) {
        const filterContainer = document.getElementById("filter-container");
        filterContainer.hidden = false;
        filterContainer.setAttribute("aria-expanded", true);
      }
    }, 250);
  });
};

export default initPerformanceMap;
