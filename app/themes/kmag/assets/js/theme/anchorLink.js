
const initAnchorLink = () => {
    const anchorLinks = document.querySelectorAll('.anchor-link');
    if (anchorLinks.length === 0) {
        return false;
    }

    initializeAnchorLinks(anchorLinks);
};

const initializeAnchorLinks = (links) => {
    let hash = window.location.hash;

    const scrollToLink = (scrollLink) => {
        const campaignTemplate = document.getElementById('primary-campaign');
        const elementHeight = scrollLink.clientHeight;
        let topOfElement = scrollLink.offsetTop;
        let windowHeight = window.innerHeight;

        if (!campaignTemplate) {
            const headerOffset = window.innerWidth >= 960 ? 98 : 73;
            windowHeight = windowHeight - headerOffset;
        }
        
        if (windowHeight > elementHeight) {
            const calcHeight = (windowHeight - elementHeight) / 2;
            topOfElement = topOfElement - calcHeight;
        }
        window.scroll({ top: topOfElement, behavior: "smooth" });
    };

    if (hash !== '') {
        const nonVisualTags = ['SCRIPT', 'LINK', 'META', 'STYLE', 'TEMPLATE', 'NOSCRIPT', 'BASE', 'TITLE', 'HEAD'];
        hash = hash.substring(1);

        links.forEach((link) => {
            const anchor = link.dataset.anchor;

            if (anchor === hash) {
                let linkSibling = link.nextElementSibling;

                // loop until we get a visual tag 
                while (linkSibling && nonVisualTags.includes(linkSibling.tagName)) {
                    linkSibling = linkSibling.nextElementSibling;
                }
                
                if (linkSibling.classList.contains('product-cards')) {
                    window.addEventListener('product_cards_loaded', () => {
                        setTimeout(() => {
                            scrollToLink(linkSibling);
                        }, 500);
                    });
                } else if (linkSibling.classList.contains('bento-box')) {
                    window.addEventListener('bento_box_loaded', () => {
                        setTimeout(() => {
                            scrollToLink(linkSibling);
                        }, 500);
                    });
                } else {
                    setTimeout(() => {
                        scrollToLink(linkSibling);
                    }, 100);
                }
            }
        });
    }
};

export default initAnchorLink;