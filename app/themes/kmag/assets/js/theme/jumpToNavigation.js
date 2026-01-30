/* eslint-env jquery */
const $ = jQuery;

const initJumpToNavigation = () => {
  if (typeof $ === 'undefined') {
    console.log('jQuery is not loaded.');
    return false; 
  }

  let offset = 200;

  if ($(window).outerWidth() <= 768) {
    offset = 150;
  }

  $('.select-item').on('click', function() {
    let section_id = $(this).attr('data-value');
    const section_name = $(this).find('button').text();

    $('.section-select span').text(section_name);
    section_id = parseInt(section_id) - 1;
    scrollContentNav(section_id);

    $('.section-select').trigger('click');
  });

  function scrollContentNav(section_id) {
    $('html,body').animate({
      scrollTop: $('.module[id*=-' + section_id + ']').offset().top - offset
    },'slow');
  }
};

export default initJumpToNavigation;
