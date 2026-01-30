const initCarouselHeros = () => {
    const carouselHeroes = document.querySelectorAll('.carousel-hero');
    console.log('initCarouselHeros');
    [...carouselHeroes].forEach(element => {
        initCarouselHero(element);
    });
}

const initCarouselHero = carouselHeroEl => {
    // Elements
    const slides = carouselHeroEl.querySelectorAll('.carousel-hero-slide');
    const dotButton = carouselHeroEl.querySelectorAll('.carousel-hero-controls__dot');
    const prevButton = carouselHeroEl.querySelector('.carousel-hero-controls__prev');
    const nextButton = carouselHeroEl.querySelector('.carousel-hero-controls__next');
    const playPauseButton = carouselHeroEl.querySelector('.carousel-hero-controls__play-pause');
    
    // constants
    const totalSlides = slides.length;
    const displayInterval = carouselHeroEl.dataset.interval || 5000;

    // State
    let currentSlide = 0;
    let intervalId = null;

    // event handlers
    const handlePrev = () => {
        if (currentSlide === 0) {
            currentSlide = totalSlides - 1;
        } else {
            currentSlide--;
        }
        resetInterval();
        renderSlide();
        renderDots();
    }

    const handleNext = () => {
        if (currentSlide === totalSlides - 1) {
            currentSlide = 0;
        } else {
            currentSlide++;
        }
        resetInterval();
        renderSlide();
        renderDots();
    }
    
    const handleDotClick = e => {
        const target = e.target;
        currentSlide = parseInt(target.getAttribute('data-dot-index'), 10);

        resetInterval();
        renderSlide();
        renderDots();
    }

    // functions
    const renderSlide = () => {
        const currentActiveSlide = carouselHeroEl.querySelector('.carousel-hero-slide--active');
        currentActiveSlide.classList.remove('carousel-hero-slide--active');

        const newActiveSlide = carouselHeroEl.querySelector(`[data-slide-index="${currentSlide}"]`);
        newActiveSlide.classList.add('carousel-hero-slide--active');
    }

    const renderDots = () => {
        dotButton.forEach((dot, index) => {
            if (index === currentSlide) {
                dot.classList.add('carousel-hero-controls__dot--active');
            } else {
                dot.classList.remove('carousel-hero-controls__dot--active');
            }
        });
    }

    const intializeEventListeners = () => {
        if (prevButton && prevButton !== null) {
            prevButton.addEventListener('click', handlePrev);
        }
        if (nextButton && nextButton !== null) {
            nextButton.addEventListener('click', handleNext);
        }
        if (playPauseButton && playPauseButton !== null) {
            playPauseButton.addEventListener('click', togglePlayPause);
        }
        dotButton.forEach(dot => {
            dot.addEventListener('click', handleDotClick);
        });
    }

    const togglePlayPause = () => {
        if (intervalId) {
            clearInterval(intervalId);
            intervalId = null;
        } else {
            intervalId = setInterval(() => {
                handleNext();
            }, displayInterval);
        }
    }

    const resetInterval = () => {
        if (intervalId) {
            clearInterval(intervalId);
            intervalId = setInterval(() => {
                handleNext();
            }, displayInterval);
        }
    }

    const init = () => {
        intializeEventListeners();
        togglePlayPause();
    }

    init();
}

export default initCarouselHeros;