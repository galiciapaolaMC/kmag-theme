import { getCookie, checkRegionCropParams } from './manageCookies';

const initProductCards = () => {
    const productCards = Array.from(document.querySelectorAll('.product-cards'));
    if (productCards.length) {
        console.log('Initializing Product Cards...');
        registerCropChangeListener();
    }
};

const registerCropChangeListener = () => {
    const productData = JSON.parse(window.product_card_data.crop_region_product_json);
    const loadEvent = new Event('product_cards_loaded');

    let region = getCookie('region_cookie');
    let crop = getCookie('crop_cookie');

    const onCropRegionChange = () => {
        const cardsModules = Array.from(document.querySelectorAll('.product-cards'));
        region = getCookie('region_cookie');
        crop = getCookie('crop_cookie');

        cardsModules.forEach((productCardModule) => {
            const cards = productCardModule.querySelectorAll('.product-cards__card');
            let performanceProducts = [];
                
            // todo check how productCardModule.dataset.secondary === '1' is set in origial function
            if (region && crop) {
                performanceProducts = productData[crop].regions[region].primaryProducts;
                if (productCardModule.dataset.secondary === '1') {
                    performanceProducts = productData[crop].regions[region].secondaryProducts;
                } else {
                    performanceProducts = productData[crop].regions[region].primaryProducts;
                }
                cards.forEach((card) => {
                    const cardProduct = card.getAttribute('data-card-product');
                    if (performanceProducts.includes(cardProduct)) {
                        card.classList.remove('hidden', 'performance-card');
                    } else {
                        card.classList.add('hidden', 'performance-card');
                    }
                });
            } else {
                cards.forEach((card) => {
                    card.classList.remove('performance-card', 'hidden');
                });
            }    
        });
        window.dispatchEvent(loadEvent);
    }

    // Listen for crop change event
    window.addEventListener('crop_has_changed', onCropRegionChange);

    if (region && crop) {
        onCropRegionChange();
    }
}

export default initProductCards;