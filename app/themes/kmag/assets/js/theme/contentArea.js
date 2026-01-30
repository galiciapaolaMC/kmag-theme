/* eslint-env jquery */
const $ = jQuery;

const initContentArea = () => {
  if (typeof $ === 'undefined') {
    console.log('jQuery is not loaded.');
    return false; 
  }

  $('.section-name').click(function() {
    var section_name = $(this).attr('data-id');
    scrollContent(section_name);
  });

  $('select[name="jump_to"]').change(function() {
    var section_name = $('select[name="jump_to"] option:selected').val();
    scrollContent(section_name);
  });

  function scrollContent(section_name) {
    $('html,body').animate({
      scrollTop: $("#" + section_name).offset().top - 100
    },'slow');
  }
};

export default initContentArea;
