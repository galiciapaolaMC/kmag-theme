import { getCropAndRegion } from './manageCookies';

const initSplitBannerRegionCrop = () => {
    const cropRegionCTAButtons = document.querySelectorAll('.region-crop-cta-button');
    let isBannerOpen = 1;

    // Remove any RegionCrop Split Banner CTA's from
    // page when a RegionCrop selection has been made.
    // Add back the Split Banners when RegionCrop
    // selection is cleared.
    const toggleSplitBanner = () => {
        const activeComponents = document.querySelectorAll('.region-crop-cta-activated');
        
        if (isBannerOpen) {
            activeComponents.forEach((component) => {
                component.classList.add('unshow');
                setTimeout(() => {
                    component.classList.add('hide');
                }, 300);
            });
            isBannerOpen = 0;
        } else {
            activeComponents.forEach((component) => {
                component.classList.remove('hide');
                setTimeout(() => {
                    component.classList.remove('unshow');
                }, 30);
            });
            isBannerOpen = 1;
        }
    };


    // Set listeners on all modules activated for RegionCrop CTA
    const setButtonListeners = () => {
        const cropRegionButton = document.querySelector('.header__crop-region-button');

        cropRegionCTAButtons.forEach((button) => {
            button.addEventListener('click', (e) => {
                e.preventDefault();

                cropRegionButton.click();
            });
        });

        // listen for event when the RegionCrop selection has changed
        window.addEventListener('crop_has_changed', () => {
            toggleSplitBanner();
        });
    };

    if (cropRegionCTAButtons.length === 0) {
        return false;
    }

    setButtonListeners();

    if (getCropAndRegion() !== null) {
        toggleSplitBanner();
    }
};

export default initSplitBannerRegionCrop
