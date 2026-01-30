/* global nutrient_excerpts */

/* eslint-env jquery */
const $ = jQuery;

const initNutrientSelect = () => {
    if (typeof $ === 'undefined') {
        console.log('jQuery is not loaded.');
        return false; 
    }

    if (!$('.nutrient-slider__mobile').length) {
        return false;
    }

    nutrientSelect();
};

const nutrientSelect = () => {
    const nutrient_select = $('select[name="nutrient_select"]');

    $(nutrient_select).change(function() {
        const nutrient_url = $('select[name="nutrient_select"] option:selected').attr('data-url');
        window.location = nutrient_url;
    });
};

export default initNutrientSelect;
