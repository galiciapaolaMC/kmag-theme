/* global nutrient_excerpts */

/* eslint-env jquery */
const $ = jQuery;

const initNutrientTable = () => {
    if (typeof $ === 'undefined') {
        console.log('jQuery is not loaded.');
        return false; 
    }
    if (!$('.module.nutrient-table').length) {
        return false;
    }

    nutrientTable();
};

const nutrientTable = () => {
    const nutrient = $('.nutrient-table__nutrient-box');
    const excerpts = nutrient_excerpts.excerpts;
    const nutrient_table_event = new Event('nutrient-table-event');

    nutrient.on('click', (e) => {
        let slug,name,symbol,excerpt = '';
        const aside = (window.innerWidth >= 1200) ? $('.nutrient-table__excerpt') : $('.nutrient-table-modal');
        let el = $(e.target);
        const box_group = el.closest('.grid-box').attr('data-container');

        nutrient.removeClass('nutrient-active');
        el.addClass('nutrient-active');

        $('.nutrient-table__nutrient-box-group').removeClass('nutrient-group-active');
        $('.box-group-'+box_group).addClass('nutrient-group-active');
        console.log(box_group);

        if (el.attr('data-nutrient')) {
            slug = el.attr('data-nutrient');
            symbol = el.attr('data-symbol');
        } else {
            slug = el.parent().attr('data-nutrient');
            symbol = el.parent().attr('data-symbol');
        }

        name = slug.substr(0,1).toUpperCase() + slug.substr(1);
        excerpt = excerpts[slug];

        const html = `<div class="nutrient-table__excerpt-wrapper">
                        <div class="nutrient-table__excerpt-inside-wrap">
                            <div class="nutrient-table__excerpt-title">
                                <div>
                                    <p class="symbol-symbol">${symbol}</p>
                                </div>
                                <h2>${name}</h2>
                            </div>
                            <p class="nutrient-table__excerpt-paragraph">${excerpt}</p>
                            <div class="nutrient-table__link-wrapper">
                                <a href="/kmag/key-nutrients/${slug}" role="button" 
                                    class="btn nutrient-table__excerpt-link" tabindex="0">
                                    Explore ${name}
                                </a>
                            </div>
                        </div>
                    </div>`;

        if (window.innerWidth < 1200) {
            window.dispatchEvent(nutrient_table_event);
        }

        aside.empty().append(html);
    });

    const nutrientResize = () => {
        let w = window.innerWidth;
        const mc_modal_close = new Event('mc-modal-close');

        $(window).resize(function() {
            const width = window.innerWidth;

            if (width < 1200 && w >= 1200 && $('.nutrient-table__excerpt').children().length > 0) {
                $('.nutrient-table__excerpt-wrapper').appendTo($('.nutrient-table-modal'));
                window.dispatchEvent(nutrient_table_event);
                w = width;
            } else if (width >= 1200 && w < 1200 && $('.nutrient-table-modal').children().length > 0) {
                $('.nutrient-table__excerpt-wrapper').appendTo($('.nutrient-table__excerpt'));
                window.dispatchEvent(mc_modal_close);
                w = width;
            }
        });
    };
    nutrientResize();
};

export default initNutrientTable;
