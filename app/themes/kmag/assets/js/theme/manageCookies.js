import queryString from 'query-string';

export const setCookie = (cname, cvalue) => {
    document.cookie = cname + "=" + cvalue + "; path=/;samesite=strict";
};

export const setExpiringCookie = (cname, cvalue, expires) => {
    document.cookie = cname + "=" + cvalue + ";expires=" + expires.toGMTString() +";path=/;samesite=strict";
};

export const getCookie = (name) => {
    let cookie_string = document.cookie;
    let cookie_array = cookie_string.split('; ');
    let cookies = {};

    if (cookie_string.length > 0) {
        for(let i = 0;i < cookie_array.length;i++) {
            const array = cookie_array[i].split('=');
            cookies[array[0]] = array[1];
        }
        return cookies[name];
    }
    return false;
};

export const deleteCookie = (cname) => {
    document.cookie = cname + "=; expiresThu, 18 Dec 2013 12:00:00 UTC;path=/;samesite=strict";
};

export const checkRegionCropParams = () => {
    const params = queryString.parse(window.location.search);

    if (params.region && params.crop) {
        return [params.region, params.crop];
    } else {
        return null;
    }
};

/**
 * Wrapper to get selected region cookie directly
 */
export const getSelectedRegion = () => {
    return getCookie('region_cookie');
};

/**
 * Wrapper to get selected crop cookie directly
 */
export const getSelectedCrop = () => {
    return getCookie('crop_cookie');
};

/**
 * Check Url Params and Cookies for Crop/Region
 */
export const getCropAndRegion = () => {
    const regionCrop = checkRegionCropParams();

    if (regionCrop) {
        const [region, crop] = regionCrop;
        return [region, crop];
    } else {
        const region = getCookie('region_cookie');
        const crop = getCookie('crop_cookie');

        if (region && crop) {
            return [region, crop];
        } else {
            return null;
        }
    }
};
