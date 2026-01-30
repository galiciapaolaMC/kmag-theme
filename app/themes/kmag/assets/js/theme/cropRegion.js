/* eslint-env jquery */

const $ = jQuery;
import { setCookie, getCookie, deleteCookie, checkRegionCropParams } from './manageCookies';
import jqueryEasings from './vendors/jqueryEasings';
import { debounce } from './debounce';


// Initialize the module
const initCropRegionChoice = () => {
    if (typeof $ === 'undefined') {
        console.log('jQuery is not loaded.');
        return false; 
    }

    if (window?.ignore_crop_region_dynamics?.ignore) {
        return false;
    }

    if (window.crop_region) {
        setupCropRegionSelect();
        initializeButton();
    } else {
        return false;
    }
};


// If no region/crop selected, we load these pages with the
// crop/region selector open
const productPaths = [ '/biosciences/', '/biosciences/nutrient-use-enhancements/',
                        '/biosciences/nutrient-use-enhancements/biopath/',
                        '/biosciences/nutrient-use-enhancements/powercoat/',
                        '/biosciences/nutrient-use-enhancements/manage/',
                        '/biosciences/nutrient-use-enhancements/root-honey-plus/',
                        '/biosciences/bio-crop-stimulants/', '/biosciences/bio-crop-stimulants/refirma-hydraguard/',
                        '/kmag/aspire/',  '/kmag/k-mag/',
                        '/kmag/microessentials/', '/kmag/pegasus/',
                        '/performance-acre-plus/'
                    ];


// the main module for the region-crop dropdown selector with US map
const setupCropRegionSelect = () => {
    const region_map = $('.header__region-map');
    const crop_select = $('.header__dropdown-nav');
    const region_inputs = $('.header__region-input-wrapper');
    const apply_crop_select = $('#apply-crop-select');
    const crop_inputs = $('.header__crop-input-wrapper');
    const regions = window.crop_region.regions;
    const crops = window.crop_region.crops;
    const event = new Event('crop_has_changed');
    const region_crop = checkRegionCropParams();
    let tentative_region = '';
    let region_choice = '';
    let crop_choice = '';


    // refresh crop options when region changes
    const populateOptions = (region) => {
        const crop_selector = $('.header__crop-dropdown .uk-dropdown-nav');
        const btn_content = $('#dropdown-button-content');
        const region_crops = regions[region][1];
        let options = '';

        for(let i = 0;i < region_crops.length;i++) {
            let slug = crops[region_crops[i]][0];
            options += `<li class="dropdown-li" data-val="${slug}">
                            <svg class="icon icon-${slug}">
                                <use xlink:href="#icon-${slug}"></use>
                            </svg>
                            ${crops[region_crops[i]][1]}
                        </li>`;
        }
        crop_selector.empty().append(options);
        btn_content.fadeOut('fast', function() {
            btn_content.text('').fadeIn('slow');
            $('.header__dropdown-button-placeholder').fadeIn('slow');
        });
        apply_crop_select.removeClass('activated').prop('disabled', true);
        apply_crop_select.off('click');
        setCropListener();
    };

    
    // update the region name in the right side panel
    const updateRegionNameHTML = (region) => {
        const display_area = $('#region-display-name, #final-region-choice');
        const conditional_word = $('#conditional-word, #final-conditional-word');
        const display_name = regions[region][0];

        display_area.fadeOut('fast', function() {
            if (display_name === 'Western Canada' || display_name === 'Eastern Canada') {
                conditional_word.fadeOut('fast');
            } else {
                conditional_word.fadeIn('slow');
            }
            display_area.text(display_name).fadeIn('slow');
        });
    };


    // update the region-crop toggle button that 
    // is attached to the bottom of the header
    const updateCropRegionButton = (region, crop, title, cb) => {
        const crop_region_button = $('.header__crop-region-button');
        const region_text = $('.header__crop-region-button-region');
        const crop_text = $('.header__crop-region-button-crop');
        const deselector = $('.header__crop-region-button-deselector');
        const inside_wrap = $('.header__crop-region-button-wrap');
        const icon = $('.header__crop-region-button .icon');
        const icon_wrapper = $('.header__crop-region-button .header__icon-wrapper');
        const mobile_wrapper = $('.mobile-crop-icon');
        const mobile_edit_crop = $('.header__crop-region-mobile-edit');
        
        inside_wrap.fadeOut('fast', function() {
            if (crop) {
                crop_text.text(`${title} -`).addClass('small-margin');
                icon_wrapper.addClass('maximize');
                icon.addClass(`icon icon-${crop}`).children('use').attr('xlink:href', `#icon-${crop}`);
                icon.fadeIn('slow');
                mobile_wrapper.fadeIn('slow');
                mobile_edit_crop.addClass('mobile-active');
            } else {
                icon.fadeOut();
                mobile_wrapper.fadeOut();
                mobile_edit_crop.removeClass('mobile-active');
                crop_text.text('').removeClass('small-margin');
            }
            crop_text.fadeIn('slow');

            if (region) {
                region_text.addClass('bold').text(regions[region][0]);
            } else {
                if (crop_region_button.hasClass('open')) {
                    region_text.removeClass('bold').text('Close');
                    mobile_edit_crop.hide();
                } else {
                   if ($(window).outerWidth() > 960) {
                    region_text.removeClass('bold').text('Choose Region & Crop'); 
                   } else {
                    region_text.removeClass('bold').text(''); 
                    mobile_edit_crop.show();
                   }
                }
            }
            inside_wrap.fadeIn('slow', () => {
                crop_region_button.css({'min-width': 'auto', 'min-height': 'auto'});
            });
        });
        setTimeout(() => {
            if (cb) {
                cb();
            }
        }, 300);
    };


    // click handler for a crop change: sets cookie and fires event
    const changeCrop = (e) => {
        const btn_content = $('#dropdown-button-content');
        const selected = $(e.target);
        const crop = selected.attr('data-val');
        const crop_title = selected.text().trim();

        $('#crop-button').trigger('click');
        $('.header__dropdown-button-placeholder').fadeOut('fast');
        btn_content.fadeOut('fast', function() {
            btn_content.text(crop_title).fadeIn('slow');
        });
        $('.header__dropdown-nav li').removeClass('selected');
        selected.addClass('selected');
        $('.header__crop-region-button-crop').fadeOut('fast');
        
        setApplyButton(crop, crop_title);
    };


    // sets listener on the crop dropdown when the croplist is refreshed
    const setCropListener = () => {
        $('.header__dropdown-nav li').off('click', changeCrop);
        $('.header__dropdown-nav li').on('click', changeCrop);
    };


    // cache crop data and set listener on Apply button
    // for when the user clicks to apply crop/region choices
    const setApplyButton = (crop, crop_title) => {
        const icon = $('.header__crop-region-button .icon');
        const saved_crop = crop;
        const saved_title = crop_title;

        const applyCrop = (crop) => {
            const crop_text = $('.header__crop-region-button-crop');
            setCookie('crop_cookie', saved_crop);
            setCookie('region_cookie', tentative_region);
            window.dispatchEvent(event);
            apply_crop_select.removeClass('activated').prop('disabled', true);
            updateCropRegionButton(getCookie('region_cookie'), saved_crop, saved_title)
            $('#final-crop-choice').text(saved_title);
            $('.header__crop-region-button').removeClass('mobile-active');
            updateRightSidePanel('final_choice_panel');

            if ($(window).outerWidth() <= 960) {
                $('.header__crop-region-mobile-edit').show();
            }
        };

        apply_crop_select.addClass('activated').prop('disabled', false);
        apply_crop_select.off('click', applyCrop);
        apply_crop_select.on('click', applyCrop);
    };


    /*************************************************************************\
       The main setup/pageload logic for this updateCropRegionButton function
    \*************************************************************************/

        // If we have url params for region and crop, we
        // set the region and crop cookies to those params
        if (region_crop) {
            region_choice = region_crop[0];
            crop_choice = region_crop[1];
            if (region_choice) {
                setCookie('region_cookie', region_choice);
            } 
            if (crop_choice) {
                setCookie('crop_cookie', crop_choice);
            }
        } else {
            region_choice = getCookie('region_cookie');
            crop_choice = getCookie('crop_cookie');
        }
        

        // Check if region_choice cookie is set
        if (region_choice) {
            if (crop_choice) {
                let crop_array = Object.values(crops);
                let crop_title = '';
                for (const el of crop_array) {
                    if (el[0] === crop_choice) {
                        crop_title = el[1];
                        break;
                    }
                }

                $('#final-crop-choice').text(crop_title);
                $('#final-region-choice').text(regions[region_choice][0]);
                updateCropRegionButton(region_choice, crop_choice, crop_title)
                updateRightSidePanel('final_choice_panel');
            }
        } else {
            updateCropRegionButton(region_choice, crop_choice, '', () => {
                const urlPath = location.pathname;
                const referrer = document.referrer;
                
                if (productPaths.includes(urlPath) && referrer === '') {
                    document.querySelector('.header__crop-region-button').click();
                }
            });
        }

        // set the apply crop choice button to disabled
        apply_crop_select.prop('disabled', true);

    /************************************************************\
        End main setup/pageload logic for updateCropRegionButton
    \************************************************************/



    // Event Listeners
    // Listen for click on the region map
    region_map.on('click', (e) => {
        const region = $(e.target).closest('.region-group').attr('id');

        if (!region || region === 'USA' || region === 'Canada') {
            return;
        } else {
            tentative_region = region;
            populateOptions(region);
            scrollToRegion(region);
            updateRegionNameHTML(region);
            updateRightSidePanel('crop_select_panel');
        }
    });

    // Closes the crop/region selector dropdown
    $('.header__enjoy-website').on('click', () => {
        $('.header__crop-region-button').trigger('click');
    });

    // Clears crop and region cookies and resets selector
    $('.header__clear-selection').on('click', () => {
        updateRightSidePanel('welcome_panel');
        deleteCookie('region_cookie');
        deleteCookie('crop_cookie');
        updateCropRegionButton();
        window.dispatchEvent(event);

        if ($(window).outerWidth() <= 960) {
            $('.header__crop-region-button').addClass('mobile-active');
        }
    });

    // allows the RegionCrop component to scroll when height 
    // is less than 654px on desktop
    const debounceCheckWindowHeight = debounce(function() {
        checkWindowHeight();
    }, 250);
    window.addEventListener('resize', debounceCheckWindowHeight);

    // make the initial height check
    checkWindowHeight();

}; // end of the main module: setupCropRegionSelect()


// Checks if window height is less than dropdown height
// and adjusts the dropdown height to initiate scrollbar
const checkWindowHeight = () => {
    const screenWidth = window.innerWidth;
    const screenHeight = window.innerHeight;
    
    if (screenWidth >= 960 && screenHeight < 720) {
        let adjusted = screenHeight - 90; 
        $('.header__crop-region-content').css('max-height', `${adjusted}px`);
    } else {
        $('.header__crop-region-content').css('max-height', '654px');
    }
};


// function to swap the 3 different right side content panels
const updateRightSidePanel = (panel) => {
    const closePanel3 = () => {
        $('.header__crop-region-content').removeClass('final-choice');
        $('.header__region-choice').fadeIn('fast');
        $('.header__crop-choice').fadeIn('fast');
        scrollMapOut();
        $('#final_choice_panel').fadeOut('fast');
    };

    if (panel === 'welcome_panel' && $(`#welcome_panel`).css('display') === 'none') {
        if ($('#final_choice_panel').css('display') === 'block') {
           closePanel3(); 
        } else {
            $('.display-panel').fadeOut('fast');
        }
        $(`#welcome_panel`).fadeIn('fast');
    }
    else if (panel === 'crop_select_panel' && $(`#crop_select_panel`).css('display') === 'none') {
        $('.display-panel').fadeOut('fast');
        $(`#crop_select_panel`).fadeIn('fast');
    } else if (panel === 'final_choice_panel' && $(`#final_choice_panel`).css('display') === 'none') {
        $('.header__crop-region-content').addClass('final-choice');
        $('.header__region-choice').fadeOut('fast');
        $('.header__crop-choice').fadeOut('fast');
        $('.display-panel').fadeOut('fast');
        $(`#final_choice_panel`).fadeIn('slow');
    }
};


// scrolls the map to the user's selected region
const scrollToRegion = (region) => {
    const region_div = $('.header__region-choice');
    const region_groups = $('.region-group');
    const expander_div = $('.header__region-map-expander');
    const wrapper_div = $('.header__region-map-wrapper');
    const width = $(window).width();
    let coordinate_set = 0;

    const coordinates = {
        us_southeast: [[360, 500],[645, 938],[691, 831]],
        central_corn_belt: [[317, 330],[432, 651],[555, 541]],
        eastern_canada: [[495, 194],[863, 412],[936, 283]],
        eastern_corn_belt: [[373, 337],[585, 645],[659, 579]],
        northern_corn_belt: [[224, 270],[291, 522],[392, 477]],
        us_northeast: [[507, 330],[851, 598],[935, 556]],
        us_pacific_northwest: [[0, 236],[0, 450],[0, 438]],
        us_southwest: [[145, 465],[272, 862],[344, 790]],
        western_canada: [[98, 83],[125, 221],[228, 169]],
        western_corn_belt: [[189, 348],[300, 651],[390, 594]],
        western_plains: [[98, 283],[144, 489],[247, 461]],
        western_us: [[0, 369],[0, 722],[0, 628]]
    };

    if (width >= 640 && width < 960) {
        coordinate_set = 1;
    } else if (width >= 960) {
        coordinate_set = 2
    }

    // if no region is passed in, we check for a region
    if (!region) {
        region = getCookie('region_cookie');
    }

    if (region) {
        region_groups.removeClass('selected');
        $(`#${region}`).addClass('selected');

        region = region.replace(/-/g, '_');

        expander_div.addClass('expanding');
        wrapper_div.addClass('growing');

        setTimeout(() => {
            region_div.animate({
                'scrollLeft': coordinates[region][coordinate_set][0],
                'scrollTop': coordinates[region][coordinate_set][1]
            }, 350, 'easeOutQuad');
        }, 150);
    }

}; // end scrollToRegion()


// Scroll out the map when user clears selection
const scrollMapOut = (option = 0) => {
    $('.header__region-map-expander').removeClass('expanding');
    setTimeout(() => {
        $('.header__region-map-wrapper').removeClass('growing');
    }, 350);

    const region_div = document.querySelector('.header__region-choice');
    if (option === 0) {
        $('.region-group').removeClass('selected');
        region_div.scrollTo(92,218);
    }
};


// initializes the button opening and closing of the region-crop dropdown
const initializeButton = () => {
    const crop_region_button = $('.header__crop-region-button');
    const deselector = $('.header__crop-region-button-deselector');
    const text = $('.header__crop-region-button-region');
    const crop_region = $('.header__crop-region-content');
    const region_div = document.querySelector('.header__region-choice');
    const crop_icon = $('.header__crop-region-button .header__crop-icon');
    const icon_wrapper = $('.header__crop-region-button .header__icon-wrapper');

    if (crop_region_button.length) {
        crop_region_button.on('click', () => {
            if (crop_region.hasClass('enabled')) {
                crop_region.removeClass('open');
                crop_region_button.removeClass('open');
                crop_region_button.removeClass('mobile-active');

                // un-freeze scroll when RegionCrop dropdown closes
                document.body.classList.remove('stop-scrolling');

                if (!text.hasClass('bold')) {
                    text.fadeOut('fast', function() {
                        if ($(window).outerWidth() > 960) {
                            text.text('Choose Region & Crop').fadeIn('slow');
                        } else {
                            $('.header__crop-region-mobile-edit').show();
                        }
                    });
                    deselector.fadeOut('fast', () => {
                        crop_icon.fadeIn('fast');
                    });
                    icon_wrapper.removeClass('maximize');
                } else {
                    deselector.fadeOut('fast', () => {
                        crop_icon.fadeIn('fast');
                    });
                }

                setTimeout(function() {
                    crop_region.removeClass('enabled');

                    if (!text.hasClass('bold')) {
                        scrollMapOut(1);
                    }
                }, 200);

            } else {
                crop_region.addClass('enabled');
                crop_region_button.addClass('open');

                // freeze scroll when RegionCrop dropdown opens
                document.body.classList.add('stop-scrolling');

                if (!text.hasClass('bold')) {
                    text.fadeOut('fast', function() {
                        text.text('Close').fadeIn('slow');
                        $('.header__crop-region-mobile-edit').hide();
                    });
                    crop_icon.fadeOut('fast', () => {
                        deselector.fadeIn('fast');
                    });
                } else {
                    crop_icon.fadeOut('fast', () => {
                        deselector.fadeIn('fast');
                    });
                }
                icon_wrapper.addClass('maximize');
                
                region_div.scrollTo(92,218);
                setTimeout(function() {
                    crop_region.addClass('open');
                }, 50);
                setTimeout(function() {
                    scrollToRegion();
                }, 300);

                if ($(window).outerWidth() <= 960) {
                    $('.header__crop-region-button').removeClass('mobile-active');
                }
            }
        });
    }
}; // end initializeButton()

export default initCropRegionChoice;
