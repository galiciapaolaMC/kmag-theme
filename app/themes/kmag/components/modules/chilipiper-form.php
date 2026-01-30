<?php
/**
 * ACF Module: Chilipiper Form
 *
 * @global $data
 */

use CN\App\Fields\ACF;
use CN\App\Fields\Util;

$headline  = ACF::getField('headline', $data);
$link  = ACF::getField('chilipiper-cta', $data);

$button_color = ACF::getField('button-color', $data, 'primary');
$button_base_class = 'btn btn--small';
$button_color_class = $button_color === 'btn--primary' ? '' : 'btn--' . $button_color;
$button_classes = implode(' ', [$button_base_class, $button_color_class]);

do_action('cn/modules/styles', $row_id, $data);

?>

<div class="module chilipiper-form" id="<?php echo esc_attr($row_id); ?>">
    <?php if (!empty($headline)) : ?>
        <h2 class="chilipiper-form__headline"><?php echo esc_html($headline); ?></h2>
    <?php endif; ?>
    <div class="chilipiper-form__scroll-wrapper">
        <div class="chilipiper-form__iframe-wrapper">
            <iframe src="https://mosaicco.chilipiper.com/router/contact-an-expert_router" frameborder="0"></iframe>
        </div>
    </div>
    <h4 class="chilipiper-form__scroll-message">
        <?php _e('Please scroll to the top after submitting.', 'kmag'); ?>   
    </h4>
    <?php if (!empty($link)) : ?>
        <div class="chilipiper-form__button-wrapper">
        <?php echo Util::getButtonHTML($link, ['class' => $button_classes]); ?>
        </div>
    <?php endif; ?>
</div>

