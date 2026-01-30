import { getCookie, getCropAndRegion } from "./manageCookies";

const initScript = () => {
    const initSuperLinks = () => {
        const mainContainerElement = document.querySelector('main.super-link-entry-point');
        const currentSlug = window.location.pathname;

        const restrictedReferrerSlugs = window?.super_back_referrer_slugs?.restrictedSlugs ?? [];
        const unrestrictedReferrerSlugs = window?.super_back_referrer_slugs?.unrestrictedSlugs ?? [];

        const cropAndRegionIsSet = getCropAndRegion() !== null;
    
        // slugs within restrictedReferrerSlugs can only create superlinks if region and crop are selected
        const isValidRestrictedSlug = restrictedReferrerSlugs.includes(currentSlug) && cropAndRegionIsSet;
        const isValidUnrestrictedSlug = unrestrictedReferrerSlugs.includes(currentSlug);

        // only setup super links on pages that contain an entry point
        if (mainContainerElement !== null && isValidUnrestrictedSlug || isValidRestrictedSlug) {
            setupSuperLinks(mainContainerElement);
            checkUrlForSuperLinkId();
        // Remove superlinks if cookie has been unset
        } else if (restrictedReferrerSlugs.includes(currentSlug) && !cropAndRegionIsSet) {
            removeSuperLinks(mainContainerElement);
        }
    }

    document.addEventListener('DOMContentLoaded', initSuperLinks);
    window.addEventListener('crop_has_changed', initSuperLinks);
}

const setupSuperLinks = (mainElement) => {
    const links = mainElement.querySelectorAll('a');
    // convert nodelist to an array for the sake of browser compatibility
    [...links].forEach((link, linkIndex) => {
        link.setAttribute('data-super-link-id', `super-link-${linkIndex}`);
        link.addEventListener('click', superLinkEventHandler)
    })
}

const removeSuperLinks = (mainElement) => {
    const links = mainElement.querySelectorAll('a');
    [...links].forEach((link, linkIndex) => {
        link.removeAttribute('data-super-link-id');
    });
}

const superLinkEventHandler = (e) => {
    const superLinkId = e.target.getAttribute('data-super-link-id');

    replaceCurrentUrl(superLinkId);
}

const createSuperLinkEntry = (url) => {
    sessionStorage.setItem("super-back-referral-url", url);
}

const replaceCurrentUrl = (superLinkId) => {
    const currentUrl = window.location.href;
    const baseUrl = currentUrl.split('#');

    const newUrl = `${baseUrl[0]}#${superLinkId}`;
    createSuperLinkEntry(newUrl);
    history.replaceState(null, '', newUrl);
}

const checkUrlForSuperLinkId = () => {
    const urlParts = window.location.href.split('#');

    if (urlParts.length > 1 && urlParts[1].includes('super-link-')) {
        const superLink = urlParts[1];
        scrollToSuperLinkId(superLink);
    }
}

const scrollToSuperLinkId = (superLinkId) => {
    const superLink = document.querySelector(`[data-super-link-id="${superLinkId}"]`);
    if (superLink) {
        superLink.scrollIntoView({ behavior: 'smooth' });
    }
}

export default initScript;