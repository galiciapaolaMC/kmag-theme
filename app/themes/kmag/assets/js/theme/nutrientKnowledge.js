/* eslint-env jquery */
const $ = jQuery;

const initnutrientKnowledge = () => {
  if (typeof $ === 'undefined') {
    console.log('jQuery is not loaded.');
    return false; 
  }

  const benefit_box = $('.nutrient-knowledge__benefit');
  const benefit_node = $('.nutrient-benefit-node');

  activateBenefit(0);

  if (window.outerWidth >= 960) {
    $(benefit_box).mouseenter(function() {
      var benefit_id = $(this).attr('data-id');
      activateBenefit(benefit_id);
    });

    $(benefit_node).mouseenter(function() {
      var benefit_id = $(this).attr('data-id');
      activateBenefit(benefit_id);
    });
  } else {
    $('.uk-slider-nav').click(function() {
      setTimeout(function() {
        var benefit_id = $('.uk-slider-items li.uk-active').attr('data-id');
        
        $(benefit_node).removeClass('nutrient-active');
        $('.nutrient-benefit-node[data-id="' + benefit_id + '"]').addClass('nutrient-active');
      }, 1000);
    });

    $(benefit_node).click(function() {
      var benefit_id = $(this).attr('data-id');
      $('.uk-dotnav li[uk-slider-item="' + benefit_id + '"]').trigger('click');
      console.log('click');
    });
  }

  function activateBenefit(benefit_id) {
    $(benefit_box).removeClass('nutrient-active');
    $(benefit_node).removeClass('nutrient-active');

    $('.nutrient-knowledge__benefit[data-id="' + benefit_id + '"]').addClass('nutrient-active');
    $('.nutrient-benefit-node[data-id="' + benefit_id + '"]').addClass('nutrient-active');
  }
};

export default initnutrientKnowledge;
