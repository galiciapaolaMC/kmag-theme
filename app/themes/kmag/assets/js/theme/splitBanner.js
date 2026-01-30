import initLocation from "./location";

const initSplitBanner = () => {
  initSplitBannerLocation();
}

const initSplitBannerLocation = () => {
  const locationContainerEls = document.querySelectorAll('.get-location-container');
  locationContainerEls.forEach(locationContainer => {
    const searchBtnEl = locationContainer.querySelector('.btn-location-search');
    const postalCodeInputEl = locationContainer.querySelector('input.location-postal-code');
    const performanceProduct = searchBtnEl.getAttribute('data-performance-product');

    searchBtnEl.addEventListener('click', event => {
      event.preventDefault();
      const postalCode = postalCodeInputEl.value;
      if (postalCode !== null && postalCode !== undefined && postalCode !== '') {
        window.location.href = formatWhereToBuyURL(postalCode, performanceProduct)
      }
    })
  });
}

const formatWhereToBuyURL = (addressParameter = null, performanceProduct = null) => {
  const currentUrl = window.location.href;
  const urlObject = new URL(currentUrl);

  const domain = urlObject.hostname;
  const protocol = urlObject.protocol;
  
  let addressParamString = '';
  if (addressParameter !== null) {
    addressParamString = `address=${addressParameter}`;
  }

  let performanceProductParamString = '';
  if (performanceProduct !== null) {
    performanceProductParamString = `product=${performanceProduct}`
    if (addressParamString !== '') {
      performanceProductParamString = `&product=${performanceProduct}`
    }
    
  }

  if (addressParameter !== null || performanceProduct !== null) {
    return `${protocol}//${domain}/where-to-buy?${addressParamString}${performanceProductParamString}`;
  }
  return `${protocol}//${domain}/where-to-buy`;
}

export default initSplitBanner;