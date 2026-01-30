/* eslint-env jquery */
const $ = jQuery;

const initVideoSlider = () => {
    if (typeof $ === 'undefined') {
        console.log('jQuery is not loaded.');
        return false; 
    }
    if (!$('.slider__item-video').length) {
        return false;
    }

    sliderVideoHandler();
};

const sliderVideoHandler = () => {
    const video_button = $('.slider__item-video--play-btn');
    let video_container = {};

    video_button.on('click', (e) => {
        const video_src = $(e.target).attr('data-src');
        const event_id = $(e.target).attr('data-event');
        const slider_content_event = new Event(`event-${event_id}`);

        video_container = $(e.target).closest('.slider__container').find('.slider-item-video');

        const source = `${video_src}`;

        window.dispatchEvent(slider_content_event);

        video_container.attr('src', source);
    });

    $(document).on('modal_is_closed', () => {
        video_container.attr('src', '');
    });
};

export default initVideoSlider;
