<?php
/**
 * ACF Module Partial: ImageFiftyFifty
 *
 * @var array $data
 *
 *  @var string $row_id
 *
 * @var string $cell_number
 */

use CN\App\Fields\ACF;
use CN\App\Fields\ModuleUtils\FiftyFiftyUtils;

$image_shape = ACF::getField('image_shape', $data);
$theme_color = 'theme-' . ACF::getField('theme_color', $data);
$desktop_image_size = ACF::getField('desktop-image-size', $data, 'cover');
$mobile_image_size = ACF::getField('mobile-image-size', $data, 'cover');
$image_caption = ACF::getField('image-caption', $data);

$image_data = apply_filters('cn/modules/handle-image-set-field', $data, $row_id);
$image_mobile = $image_data['image_mobile'];
$image_desktop = $image_data['image_desktop'];

$image_mobile_style = !empty($image_mobile) ? ' style="background-image: url(' . esc_html($image_mobile->url) . '); background-size: ' . esc_attr($mobile_image_size) . ';"' : '';
$image_desktop_style = !empty($image_desktop) ? ' style="background-image: url(' . esc_html($image_desktop->url) . '); background-size: ' . esc_attr($desktop_image_size) . ';"' : '';
$style_classes = "{$theme_color} {$cell_number}-child";

$desktop_rounding = ACF::getField('image-corner-rounding_desktop-rounding', $data, []);
$mobile_rounding = ACF::getField('image-corner-rounding_mobile-rounding', $data, []);
$desktop_rounding_classes = FiftyFiftyUtils::getRoundingCssClasses($desktop_rounding);
$mobile_rounding_classes = FiftyFiftyUtils::getRoundingCssClasses($mobile_rounding);
?>

<div class="partial column-content__image-fifty-fifty image-fifty-fifty--<?php echo esc_attr($image_shape); ?> <?php echo esc_attr($style_classes); ?>">
    <div class="image-fifty-fifty__inside-wrap">
        <div class="image-fifty-fifty__image-holder mobile mobile-crop-image <?php echo $desktop_rounding_classes;?>"<?php echo $image_mobile_style; ?>></div>
        <div class="image-fifty-fifty__image-holder desktop desktop-crop-image <?php echo $mobile_rounding_classes;?>"<?php echo $image_desktop_style; ?>></div>

        <?php if (!empty($image_caption)) : ?>
            <div class="image-fifty-fifty__image-caption">
                <?php echo wp_kses_post(nl2br($image_caption)); ?>
            </div>
        <?php endif; ?>
    </div>
</div>