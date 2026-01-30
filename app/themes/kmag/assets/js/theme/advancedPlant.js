/* eslint-env jquery */
const $ = jQuery;

const initAdvancedPlant = () => {
  if (typeof $ === 'undefined') {
    console.log('jQuery is not loaded.');
    return false; 
  }

  const cn_image_btn = $('.cn-container');
  const bio_image_btn = $('.bio-container');

  $(cn_image_btn).mouseenter(function() {
    $('.main-image').fadeOut();
    $('.bio-image').fadeOut();
    $('.cn-image').fadeIn();
    $('.main-content-container, .bio-container').css('opacity', '0.5');
  }).mouseleave(function() {
    $('.cn-image').fadeOut();
    $('.bio-image').fadeOut();
    $('.main-image').fadeIn();
    $('.main-content-container, .bio-container').css('opacity', '1');
  });

  $(bio_image_btn).mouseenter(function() {
    $('.main-image').fadeOut();
    $('.cn-image').fadeOut();
    $('.bio-image').fadeIn();
    $('.main-content-container, .cn-container').css('opacity', '0.5');
  }).mouseleave(function() {
    $('.cn-image').fadeOut();
    $('.bio-image').fadeOut();
    $('.main-image').fadeIn();
    $('.main-content-container, .cn-container').css('opacity', '1');
  });
};

export default initAdvancedPlant;
