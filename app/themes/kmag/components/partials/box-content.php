<?php
/**
 * ACF Module: Box Content
 *
 * @global $data
 */

use CN\App\Fields\ACF;
use CN\App\Fields\Util;
use CN\App\Fields\ModuleUtils\CardUtils;
use CN\App\Media;

// element preferences
$desktop_rounding = ACF::getField('image-corner-rounding_desktop-rounding', $data, []);
$mobile_rounding = ACF::getField('image-corner-rounding_mobile-rounding', $data, []);
$desktop_image_size = ACF::getField('desktop-image-size', $data, 'cover');
$mobile_image_size = ACF::getField('mobile-image-size', $data, 'cover');

// Card Classes
$desktop_rounding_classes = CardUtils::getRoundingCssClasses($desktop_rounding);
$mobile_rounding_classes = CardUtils::getRoundingCssClasses($mobile_rounding);

// Elements
$heading = ACF::getField('box-headline', $data);
$has_heading = ! empty($heading);

$text_content = ACF::getField('box-paragraph', $data);
$has_text_content = ! empty($text_content);
$button = ACF::getField('box-button', $data);
$has_button = ! empty($button);

// Image
$card_image = ACF::getField('box-image', $data);
$has_image = ! empty($card_image);
$image_attachment = $has_image ? Media::getAttachmentByID($card_image) : false;
$src = $image_attachment ? ACF::getField('full', $image_attachment->sizes, $image_attachment->url) : null;
$image_alt = '';
if ($has_image) {
    $image_alt = ! empty($image_attachment->alt) ? esc_attr($image_attachment->alt) : esc_attr($image_attachment->title);
}

$desktop_image_styles = '';
if (! empty($src)) {
    $desktop_image_styles = 'background-image: url(' . esc_html($src) . '); background-size: ' . esc_attr($desktop_image_size) . ';';
}

// Mobile Image
$card_image_mobile = ACF::getField('box-image-mobile', $data);
$has_mobile_image = ! empty($card_image_mobile);
$image_attachment_mobile = $has_mobile_image ? Media::getAttachmentByID($card_image_mobile) : false;
$src_mobile = $image_attachment_mobile ? ACF::getField('full', $image_attachment_mobile->sizes, $image_attachment_mobile->url) : null;
$image_alt_mobile = '';
if ($has_mobile_image) {
    $image_alt_mobile = ! empty($image_attachment_mobile->alt) ? esc_attr($image_attachment_mobile->alt) : esc_attr($image_attachment_mobile->title);
}

$mobile_image_styles = '';
if (! empty($src_mobile) || ! empty($src)) {
    $final_mobile_src = ! empty($src_mobile) ? $src_mobile : $src;
    $mobile_image_styles = 'background-image: url(' . $final_mobile_src . '); background-size: ' . esc_attr($mobile_image_size) . ';';
}

// Button Options
$button_color = ACF::getField('button-options_button-color', $data);
$button_base_class = 'btn';
$button_color_class = $button_color === 'btn--primary' ? '' : 'btn--' . $button_color;
$button_size_class = $card_size === 'large' ?  '' : 'btn--small';
$button_classes = implode(' ', [$button_base_class, $button_color_class, $button_size_class]);
$button_html = $has_button ? Util::getButtonHTML($button, ['class' => $button_classes]) : '';

?>

<div class="module box-content <?php echo $desktop_rounding_classes?> <?php echo $mobile_rounding_classes?>">
    <?php if ($has_image || $has_mobile_image) { ?>
        <div class="box-content__figure" style="<?php echo $desktop_image_styles ?>"
        aria-label="<?php echo $image_alt ?>"></div>
        
        <div class="box-content__figure-mobile" style="<?php echo $mobile_image_styles ?>"
        aria-label="<?php echo $image_alt ?>"></div>
    <?php } ?>

    <?php if ($has_heading || $has_text_content || $has_button) { ?>
        <div class="box-content__content">
            <?php 
            if ($has_heading) { ?>
                <h2 class='box-content__heading'><?php echo $heading; ?></h2>
            <?php }

            if ($has_text_content) { ?>
                <div class="box-content__text"> <?php echo apply_filters('the_content', $text_content); ?> </div>
            <?php } ?>

            <?php if ($has_button) { ?>
                <div class="box-content__button">
                    <?php echo $button_html; ?>
                </div>
            <?php } ?>
        </div>
    <?php } ?>
</div>