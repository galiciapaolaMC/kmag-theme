<?php

/**
 *  Bio Science partial template
 */
?>
<section class="power-cal-sections">
  <div class="calcontainer">
    <div class="cal_select_country_tap" id="country_list">
      <ul>
        <li class="active" data-title="USA"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/icon/usa.png"><?php _e(' United States', 'kmag'); ?> </li>
        <li data-title="Canada"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/icon/canada.png"><?php _e(' Canada', 'kmag'); ?> </li>
        <li data-title="Metric"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/icon/metrics.png"><?php _e(' Metric', 'kmag'); ?> </li>
      </ul>
    </div>
    <div class="clearboth"></div>
    <div class="power_calulator_formula_section">
      <div class="power_Cal_left_width padrt15">
        <div class="power_cal_white_bg">
          <div class="fertilizer_app_section">
            <h4><?php _e('Fertilizer application method', 'kmag'); ?></h4>
            <div class="fertilizer_list_sec" id="fertilizer_app_method">
              <ul>
                <li class="active" data-title="Banded"><?php _e('Banded', 'kmag'); ?> </li>
                <li data-title="Broadcast"><?php _e('Broadcast', 'kmag'); ?></li>
              </ul>
            </div>
            <div class="clearboth"></div>
          </div>
          <div class="fertilizer_slider_sec">
            <p><?php _e('Fertilizer application rate', 'kmag'); ?> <span class="country_content country_content_USA country_content_Canada"><?php _e('(lbs/ac)', 'kmag'); ?></span><span class="country_content country_content_Metric"><?php _e('(kg/ha)', 'kmag'); ?></span></p>
            <div class="fertilizer_slider_box">
              <div class="fertilizer_slider_left padrt15">
                <div class="slier_box_sec">
                  <input id="rate" name="rateSlider" data-slider-id='rate' type="text" data-slider-min="50" data-slider-max="300" data-slider-value="1" />
                </div>
              </div>
              <div class="fertilizer_slider_right padlt15">
                <div class="input_box">
                  <input type="text" name="rate" id="rateinput" inputmode="text" placeholder="<?php _e('Enter rate', 'kmag') ?>" class="form_text" autocomplete="Off" onchange="amountChange();">
                </div>

              </div>
            </div>
            <div class="clearboth"></div>
          </div>
          <div class="fertilizer_batch_sec">
            <div class="fertilizer_full_width">
              <div class="fertilizer_half_width padrt15">
                <div class="input_box">
                  <label><?php _e('Enter batch or blender size', 'kmag'); ?></label>
                  <input type="text" name="batchsize" id="batchsize" class="form_text" onchange="calculateWealthy();">
                </div>
              </div>
              <div class="fertilizer_half_width padlt15">
                <div class="input_box">
                  <label><?php _e('Total acres to be treated', 'kmag'); ?></label>
                  <input type="text" name="totalacre" id="totalacre" class="form_text" onchange="calculateWealthy();">
                </div>
              </div>
            </div>
            <div class="clearboth"></div>
          </div>
        </div>
      </div>
      <div class="power_Cal_right_width padlt15">
        <div class="power_cal_grey_bg">
          <div class="power_head">
            <h3><?php _e('Total', 'kmag'); ?></h3>
            <h4><?php _e('Estimated calculations', 'kmag'); ?></h4>
          </div>
          <div class="total_display_box greenbox">
            <p><?php _e('Calculated total PowerCoat product needed', 'kmag'); ?></p>
            <p><strong id="toal_powercoat_one"></strong> | <strong id="toal_powercoat_two"></strong></p>
          </div>
          <div class="cal_select_country_tap print_results_holder">
            <ul>
              <li class="active" id="printresult"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/icon/print.png"><?php _e(' Print Results ', 'kmag'); ?></li>
            </ul>
          </div>
          <div class="total_display_box">
            <p><?php _e('Minimum effective PowerCoat ', 'kmag'); ?><span class="country_content country_content_USA country_content_Canada"><?php _e('rate/ac', 'kmag'); ?></span><span class="country_content country_content_Metric"><?php _e('rate/ha', 'kmag'); ?></span></p>
            <p><strong id="powercoat_rate"></strong></p>
          </div>
          <div class="total_display_box">
            <p class="country_content country_content_USA"><?php _e('Calculated PowerCoat impregnation rate per ST', 'kmag'); ?></p>
            <p class="country_content country_content_Canada country_content_Metric"><?php _e('Calculated PowerCoat impregnation rate per MT', 'kmag'); ?></p>
            <p><strong id="powercoat_impregnation_rate_one"></strong> | <strong id="powercoat_impregnation_rate_two"></strong></p>
          </div>
          <div class="total_display_box">
            <p><?php _e('Calculated PowerCoat product needed per batch or blend', 'kmag'); ?></p>
            <p><strong id="powercoat_product_batch_value_one"></strong> | <strong id="powercoat_product_batch_value_two"></strong></p>
          </div>
          <div class="total_display_box">
            <p><?php _e('Total volume of fertilizer', 'kmag'); ?></p>
            <p><strong id="total_volume"></strong></p>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
  <div class="clearboth"></div>
</section>
<section class="powercost_metric_content_sec">
  <div class="calcontainer">
    <div class="powercost_content_terms usa_terms">
      <p><?php _e('For best results, apply PowerCoat to the finished formulated blend of dry fertilizer. If applying to only one component of the blend, use that component\'s application rate for "Fertilizer application rate" to calculate the PowerCoat impregnation rate per ST.', 'kmag'); ?></p>
      <p><?php _e('The minimum effective PowerCoat application rate is 2.5 fl oz/ac for banded or 2x2 applications and 5 fl oz/ac for broadcast applications. The impregnation rate of PowerCoat to dry fertilizer is dependent on the application method and rate of fertilizer. This allows for a variable impregnation rate of PowerCoat to dry fertilizer.', 'kmag'); ?></p>
    </div>
    <div class="powercost_content_terms canada_terms">
      <p><?php _e('For best results, apply PowerCoat to the finished formulated blend of dry fertilizer. If applying to only one component of the blend, use that component\'s application rate for "Fertilizer application rate" to calculate the PowerCoat impregnation rate per MT.', 'kmag'); ?></p>
      <p><?php _e('The minimum effective PowerCoat application rate is 75 mL/A for banded applications and 150 mL/A for broadcast applications. The impregnation rate of PowerCoat to dry fertilizer is dependent on the application method and rate of fertilizer. This allows for a variable impregnation rate of PowerCoat to dry fertilizer.', 'kmag'); ?></p>
    </div>
    <div class="powercost_content_terms metrics_terms">
      <p><?php _e('For best results, apply PowerCoat to the finished formulated blend of dry fertilizer. If applying to only one component of the blend, use that component\'s application rate for "Fertilizer application rate" to calculate the PowerCoat impregnation rate per MT.', 'kmag'); ?></p>
      <p><?php _e('The minimum effective PowerCoat application rate is 185 mL/Ha for banded or 2x2 applications and 370 mL/Ha for broadcast applications. The impregnation rate of PowerCoat to dry fertilizer is dependent on the application method and rate of fertilizer. This allows for a variable impregnation rate of PowerCoat to dry fertilizer.', 'kmag'); ?></p>
    </div>

  </div>
</section>

<script src="<?php echo get_template_directory_uri(); ?>/assets/js/theme/bootbox.min.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/assets/js/theme/bootstrap-slider.js"></script>
<script type="text/javascript">
  const monthamountSlider = new Slider("#rate", {
    formatter: function(value) {
      jQuery("#rateinput").val(value);
      return value;
    },
    ticks_tooltip: true
  }).on("slideStop", function(slideEvt) {
    calculateWealthy();
  });

  function amountChange() {
    const inv_amount = jQuery("#rateinput").val();
    monthamountSlider.setValue(inv_amount);
    calculateWealthy();
  }

  function calculateWealthy() {
    const multiplierUs = 2000
    const multiplierCA = 2200
    const multiplierMe = 1000
    const twentyTwo = 22
    const impregnatioMultiplierCA = 0.7
    const impregnationCalcUS = 0.062584
    const impregnationCalcCA = 0.96
    const powercoatBatchOneCalcUS = 128
    const powercoatBatchTwoCalcUS = 8.01
    const US_BANDED_POWERCOAT_RATE = 2.5
    const US_BROADCAST_POWERCOAT_RATE = 5
    const CA_BANDED_POWERCOAT_RATE = 75
    const CA_BROADCAST_POWERCOAT_RATE = 150
    const METRIC_BANDED_POWERCOAT_RATE = 185
    const METRIC_BROADCAST_POWERCOAT_RATE = 370
    let country = jQuery('#country_list li.active').data('title')
    let fertilizer_method = jQuery('#fertilizer_app_method li.active').data('title')
    let fertilizer_application_rate = jQuery('#rateinput').val()
    let batchsize = jQuery('#batchsize').val()
    let totalarea = jQuery('#totalacre').val()
    let powercoat_rate, powercoat_impregnation_rate, powercoat_impregnation_rate_two, powercoat_product_batch_value_one, powercoat_product_batch_value_two, total_volume, toal_powercoat_one, toal_powercoat_two
    if (country === "USA") {
      if (fertilizer_method === "Banded") {
        powercoat_rate = US_BANDED_POWERCOAT_RATE
      }
      if (fertilizer_method === "Broadcast") {
        powercoat_rate = US_BROADCAST_POWERCOAT_RATE
      }

      powercoat_impregnation_rate = Math.max(twentyTwo, ((multiplierUs / fertilizer_application_rate) * (powercoat_rate)))

      if (fertilizer_method === "Broadcast") {
        if (powercoat_impregnation_rate > 102) {
          powercoat_impregnation_rate = 102;
        }
      }

      powercoat_impregnation_rate = parseFloat(powercoat_impregnation_rate).toFixed(1)
      powercoat_impregnation_rate_two = parseFloat(powercoat_impregnation_rate * impregnationCalcUS).toFixed(2)
      powercoat_product_batch_value_one = parseFloat((powercoat_impregnation_rate * batchsize) / powercoatBatchOneCalcUS).toFixed(1)
      powercoat_product_batch_value_two = parseFloat(powercoat_product_batch_value_one * powercoatBatchTwoCalcUS).toFixed(1)
      total_volume = parseFloat((totalarea * fertilizer_application_rate) / multiplierUs).toFixed(1)
      toal_powercoat_one = (powercoat_impregnation_rate * total_volume) / powercoatBatchOneCalcUS;
      toal_powercoat_one = parseFloat(toal_powercoat_one).toFixed(1)
      toal_powercoat_two = toal_powercoat_one * powercoatBatchTwoCalcUS
      toal_powercoat_two = parseFloat(toal_powercoat_two).toFixed(1)

      jQuery('#powercoat_rate').html(powercoat_rate + " fl oz");
      jQuery('#powercoat_impregnation_rate_one').html(powercoat_impregnation_rate + " fl oz")
      jQuery('#powercoat_impregnation_rate_two').html(powercoat_impregnation_rate_two + " lbs ")
      jQuery('#powercoat_product_batch_value_one').html(powercoat_product_batch_value_one + " gal ")
      jQuery('#powercoat_product_batch_value_two').html(powercoat_product_batch_value_two + " lbs ")
      jQuery('#total_volume').html(total_volume + " ST ")
      jQuery('#toal_powercoat_one').html(toal_powercoat_one + " gal ")
      jQuery('#toal_powercoat_two').html(toal_powercoat_two + " lbs ")
      jQuery('.powercost_content_terms').hide();
      jQuery('.usa_terms').show();
    }
    if (country === "Canada") {
      if (fertilizer_method === "Banded") {
        powercoat_rate = CA_BANDED_POWERCOAT_RATE
      }
      if (fertilizer_method === "Broadcast") {
        powercoat_rate = CA_BROADCAST_POWERCOAT_RATE
      }

      powercoat_impregnation_rate = Math.max(impregnatioMultiplierCA, ((multiplierCA / fertilizer_application_rate) * (powercoat_rate)) / multiplierMe)

      if (fertilizer_method === "Broadcast") {
        if (powercoat_impregnation_rate > 3.3) {
          powercoat_impregnation_rate = 3.3;
        }
      }

      powercoat_impregnation_rate = parseFloat(powercoat_impregnation_rate).toFixed(2)
      powercoat_impregnation_rate_two = parseFloat(powercoat_impregnation_rate * impregnationCalcCA).toFixed(2)

      powercoat_product_batch_value_one = parseFloat((powercoat_impregnation_rate * batchsize)).toFixed(1)
      powercoat_product_batch_value_two = parseFloat(powercoat_product_batch_value_one * impregnationCalcCA).toFixed(1)
      total_volume = (totalarea * fertilizer_application_rate) / multiplierCA
      total_volume = parseFloat(total_volume).toFixed(1)
      toal_powercoat_one = (powercoat_impregnation_rate * total_volume)
      toal_powercoat_one = parseFloat(toal_powercoat_one).toFixed(1)
      toal_powercoat_two = toal_powercoat_one * impregnationCalcCA
      toal_powercoat_two = parseFloat(toal_powercoat_two).toFixed(1)

      jQuery('#powercoat_rate').html(powercoat_rate + " mL")
      jQuery('#powercoat_impregnation_rate_one').html(powercoat_impregnation_rate + " Litre")
      jQuery('#powercoat_impregnation_rate_two').html(powercoat_impregnation_rate_two + " kg ")
      jQuery('#powercoat_product_batch_value_one').html(powercoat_product_batch_value_one + " Litre ")
      jQuery('#powercoat_product_batch_value_two').html(powercoat_product_batch_value_two + " kg ")
      jQuery('#total_volume').html(total_volume + " MT ")
      jQuery('#toal_powercoat_one').html(toal_powercoat_one + " Litre ")
      jQuery('#toal_powercoat_two').html(toal_powercoat_two + " kg ")
      jQuery('.powercost_content_terms').hide()
      jQuery('.canada_terms').show()
    }
    if (country === "Metric") {
      if (fertilizer_method === "Banded") {
        powercoat_rate = METRIC_BANDED_POWERCOAT_RATE
      }
      if (fertilizer_method === "Broadcast") {
        powercoat_rate = METRIC_BROADCAST_POWERCOAT_RATE
      }

      powercoat_impregnation_rate = Math.max(impregnatioMultiplierCA, ((multiplierMe / fertilizer_application_rate) * (powercoat_rate)) / multiplierMe)

      if (fertilizer_method === "Broadcast") {
        if (powercoat_impregnation_rate > 3.3) {
          powercoat_impregnation_rate = 3.3;
        }
      }
      
      powercoat_impregnation_rate = parseFloat(powercoat_impregnation_rate).toFixed(2)
      powercoat_impregnation_rate_two = parseFloat(powercoat_impregnation_rate * impregnationCalcCA).toFixed(2)

      powercoat_product_batch_value_one = parseFloat((powercoat_impregnation_rate * batchsize)).toFixed(1)
      powercoat_product_batch_value_two = parseFloat(powercoat_product_batch_value_one * impregnationCalcCA).toFixed(1)
      total_volume = (totalarea * fertilizer_application_rate) / multiplierMe
      total_volume = parseFloat(total_volume).toFixed(1)
      toal_powercoat_one = (powercoat_impregnation_rate * total_volume)
      toal_powercoat_one = parseFloat(toal_powercoat_one).toFixed(1)
      toal_powercoat_two = toal_powercoat_one * impregnationCalcCA
      toal_powercoat_two = parseFloat(toal_powercoat_two).toFixed(1)

      jQuery('#powercoat_rate').html(powercoat_rate + " mL")
      jQuery('#powercoat_impregnation_rate_one').html(powercoat_impregnation_rate + " Litre")
      jQuery('#powercoat_impregnation_rate_two').html(powercoat_impregnation_rate_two + " kg ")
      jQuery('#powercoat_product_batch_value_one').html(powercoat_product_batch_value_one + " Litre ")
      jQuery('#powercoat_product_batch_value_two').html(powercoat_product_batch_value_two + " kg ")
      jQuery('#total_volume').html(total_volume + " MT ")
      jQuery('#toal_powercoat_one').html(toal_powercoat_one + " Litre ")
      jQuery('#toal_powercoat_two').html(toal_powercoat_two + " kg ")
      jQuery('.powercost_content_terms').hide()
      jQuery('.metrics_terms').show()
    }
  }

  jQuery('#fertilizer_app_method li').click(function() {
    jQuery('#fertilizer_app_method li').removeClass('active');
    jQuery(this).addClass('active');
    calculateWealthy();
  })
  jQuery('#country_list li').click(function() {
    jQuery('#country_list li').removeClass('active');
    jQuery(this).addClass('active');
    jQuery(".country_content").hide()
    jQuery(".country_content_" + jQuery(this).data('title')).show()
    if (jQuery(this).data('title') === 'USA') {
      jQuery("input[name='rateSlider']").data("slider-min", "49")
    } else {
      jQuery("input[name='rateSlider']").data("slider-min", "45")
    }
    
    calculateWealthy();
  })
  jQuery('#printresult').click(function() {
    window.print();
  })
  jQuery(".country_content").hide()
  jQuery(".country_content_USA").show()
  jQuery('head').append('<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/bootstrap-slider.css" type="text/css" />')
  calculateWealthy()
</script>