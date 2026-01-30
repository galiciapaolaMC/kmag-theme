
const initAnnouncementBar = () => {
    const anchorLinks = document.querySelectorAll('.announcement-bar a');
    if (anchorLinks.length === 0) {
        return false;
    }

    initializeAnchorClick(anchorLinks);
};

const initializeAnchorClick = (links) => {
    let hash = window.location.hash;

    if (hash !== '') {
        hash = hash.substring(1);

        links.forEach((link) => {
            const anchor = link.getAttribute("href");

            link.addEventListener('click', (e) => {
                e.preventDefault();
                document.querySelector(`${anchor}`).scrollIntoView({
                    behavior: 'smooth'
                });
            });
            
        });
    }
};

export default initAnnouncementBar;