
const initStickyNavigation = () => {
    const anchorLinks = document.querySelectorAll('.sticky-nav li');
    if (anchorLinks.length === 0) {
        return false;
    }

    initializeStickyNavClick(anchorLinks);

    const menutoggle = document.querySelector(".sticky-nav__menu-toggle");

    menutoggle.addEventListener("click", () => {
        menutoggle.classList.toggle("active");
        document.querySelector("header").classList.toggle("mobile-active");

        if (menutoggle.classList.contains("active")) {
            document.body.style.overflow = "hidden";
        } else {
            document.body.style.overflow = "auto";
        }
    });
};

const initializeStickyNavClick = (links) => {
    links.forEach((link) => {
        const anchor = link.getAttribute("data-anchor");

        if (anchor) {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                document.querySelector(`#${anchor}`).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        }
    });
};

export default initStickyNavigation;