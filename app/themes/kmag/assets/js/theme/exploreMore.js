
const initExploreMore = () => {
    const exploreLink = document.querySelector('.explore-more__sticky-cta');

    if (exploreLink === null || exploreLink.length === 0) {
        return false;
    }

    window.addEventListener('scroll', function(event) {
        if (window.scrollY >= (document.body.offsetHeight)*.2) {
            exploreLink.classList.add('show');
        } else {
            exploreLink.classList.remove('show');
        }
    });

    exploreLink.addEventListener("click", () => {
        document.querySelector('.module.explore-more').scrollIntoView({
            behavior: 'smooth'
        });
    });
};

export default initExploreMore;