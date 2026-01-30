import { getCropAndRegion } from './manageCookies';

const initDynamicRegionCropSection = () => {
    const dynamicShowSections = document.querySelectorAll('.show-with-region-crop');
    const dynamicHideSections = document.querySelectorAll('.hide-with-region-crop');

    // Show or Hide dynamic sections when Region/Crop is selected
    // or the Region/Crop selection is cleared
    const toggleDynamicSections = () => {
        if (getCropAndRegion() === null) {
            if (dynamicShowSections.length > 0) {
                dynamicShowSections.forEach((section) => {
                    section.classList.add('unshow');

                    setTimeout(() => {
                        section.classList.add('hide');
                    }, 300);
                });
            }
            if (dynamicHideSections.length > 0) {
                dynamicHideSections.forEach((section) => {
                    section.classList.remove('hide');

                    setTimeout(() => {
                       section.classList.remove('unshow'); 
                    }, 30);
                });
            }
        } else {
            if (dynamicShowSections.length > 0) {
                dynamicShowSections.forEach((section) => {
                    section.classList.remove('hide');

                    setTimeout(() => {
                       section.classList.remove('unshow'); 
                    }, 30);
                });
            }
            if (dynamicHideSections.length > 0) {
                dynamicHideSections.forEach((section) => {
                    section.classList.add('unshow'); 
                    
                    setTimeout(() => {
                       section.classList.add('hide');
                    }, 300);
                });
            }
        }
    };

    if (dynamicShowSections.length === 0 && dynamicHideSections.length === 0) {
        return false;
    }

    toggleDynamicSections();

    window.addEventListener('crop_has_changed', () => {
        toggleDynamicSections();
    });
};

export default initDynamicRegionCropSection;
