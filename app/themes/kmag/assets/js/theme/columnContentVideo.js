/* eslint-env jquery */
const $ = jQuery;

const initColumnContentVideo = () => {
    if (typeof $ === 'undefined') {
        console.log('jQuery is not loaded.');
        return false; 
    }
    if (!$('.column-content__video-fifty-fifty').length) {
        return false;
    }

    videoHandler();
};

const videoHandler = () => {
    const video_button = $('.video-fifty-fifty__play-btn');
    let video_container = {};

    video_button.on('click', (e) => {
        const video_id = $(e.target).attr('data-id');
        const event_id = $(e.target).attr('data-event');
        const column_content_event = new Event(`event-${event_id}`);

        video_container = $(e.target).closest('.column-content').find('.column-content-video');

        const source = `https://player.vimeo.com/video/${video_id}` +
        `?h=ccc922f06d&amp;badge=0&amp;autopause=0&amp;player_id=0&amp;app_id=58479`;

        window.dispatchEvent(column_content_event);

        video_container.attr('src', source);
    });

    $(document).on('modal_is_closed', () => {
        video_container.attr('src', '');
    });
};

export default initColumnContentVideo;
