import { getCookie, checkRegionCropParams } from './manageCookies';

const withBgImage = [
    'performance-acre-plus-banner',
    'hero',
];

const initCropImages = () => {
    getCrop();
};

const getCrop = () => {
    // checking the url for region and crop
    let regionCrop = checkRegionCropParams();
    if (regionCrop) {
        cropImages(regionCrop[1]);
    } else {
        cropImages(getCookie('crop_cookie'));
    }

    window.addEventListener('crop_has_changed', () => {
        cropImages(getCookie('crop_cookie'));
    });

    window.addEventListener('gated_content-event', () => {
        console.log('gated content event heard');
    });
}

const getRandomCrop = () => {
    const list = ['alfalfa', 'barley', 'canola', 'citrus', 'corn',
        'cotton', 'dry-beans', 'fruit', 'sorghum', 'oats', 'onions',
        'peanuts', 'peas', 'potato', 'rice', 'soybean', 'spring-cereals',
        'spring-wheat', 'sugar-beet', 'sugar-cane', 'sunflower',
        'tree-fruit-nuts-vines', 'turf', 'vegetables', 'winter-wheat', 'hay'];

    return list[Math.floor((Math.random()*list.length))];
};

const cropImages = (crop) => {
    const sections = document.querySelectorAll('section');
    crop = crop || getRandomCrop();
    sections.forEach((el) => {
        // A global approach to background image replacement
        const containsBgImage = withBgImage.some((className) => el.classList.contains(className));
        if (containsBgImage) {
            let { desktop, mobile } = window.crop_images?.crops[crop]?.banners ?? { desktop: 0, mobile: 0};

            if (typeof getCookie('crop_cookie') === 'undefined') {
                 desktop = 0;
                 mobile = 0;
            }

            const backgroundDesktopEl = el.querySelector('.module__background--desktop');
            if (backgroundDesktopEl && desktop.length > 0) {
                const randomDesktopIndex = Math.floor(Math.random() * desktop.length);
                const desktopImage = window.crop_images.images[desktop[randomDesktopIndex]];
                backgroundDesktopEl.style.backgroundImage = `url(${desktopImage.sizes.large})`;
            } else if (backgroundDesktopEl) {
                backgroundDesktopEl.style.backgroundImage = `url(${backgroundDesktopEl.dataset.defaultImage})`;
            }

            const backgroundMobileEl = el.querySelector('.module__background--mobile');
            if (backgroundMobileEl && mobile.length > 0) {
                const randomMobileIndex = Math.floor(Math.random() * mobile.length);
                const mobileImage = window.crop_images.images[mobile[randomMobileIndex]];
                backgroundMobileEl.style.backgroundImage = `url(${mobileImage.sizes.large})`;
            } else if (backgroundMobileEl) {
                backgroundMobileEl.style.backgroundImage = `url(${backgroundMobileEl.dataset.defaultImage})`;
            }
        }

        // Original method of image replacement
        const section_id = el.id;
        const script_id = section_id.replace('-', '_');
        if (window[`${script_id}_images`]) {
            const images = window[`${script_id}_images`].crop_images;
            const mobile = document.querySelector('#' + section_id).querySelector('.mobile-crop-image');
            const desktop = document.querySelector('#' + section_id).querySelector('.desktop-crop-image');

            if (desktop && desktop.tagName === 'DIV') {
                if (mobile) {
                    if (images[crop].mobile !== '') {
                        mobile.style.backgroundImage = `url(${images[crop].mobile})`;
                    }
                }
                if (images[crop].desktop !== '') {
                    desktop.style.backgroundImage = `url(${images[crop].desktop})`;
                }
            } else {
                if (mobile) {
                    if (images[crop].mobile !== '') {
                        mobile.src = images[crop].mobile;
                    }
                }
                if (images[crop].desktop !== '') {
                    desktop.src = images[crop].desktop;
                }
            }
        }
    });
};

export default initCropImages;
