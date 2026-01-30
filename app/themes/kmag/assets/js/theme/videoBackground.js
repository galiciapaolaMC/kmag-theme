/* eslint-env jquery */
const $ = jQuery;

const initVideoBackground = () => {
  if (typeof $ === 'undefined') {
    console.log('jQuery is not loaded.');
    return false; 
  }

  const videoModule = $('.video.module');

  if (videoModule.length === 0) {
    return;
  }

  videoModule.each(function() {
    const module_id = $(this).attr('id');
    const video = $(`#${module_id} .video-file`);
    const play = $(`#${module_id} .play-btn`);

    $(play).click(function(){
      var status = $(video).get(0);

      if (status.paused) {
        status.play();
        videoPlay(video, play);
      } else {
        status.pause();
        videoPause(video, play);
      }
    });

    $(video).bind('play', function (e) {
      videoPlay(video, play);
    });

    $(video).bind('pause', function (e) {
      videoPause(video, play);
    });
  });
  
  function videoPlay(video, play) {
    $(video).addClass('video-play');
    $(play).hide();
  }

  function videoPause(video, play) {
    $(play).show();
  }
};

export default initVideoBackground;
