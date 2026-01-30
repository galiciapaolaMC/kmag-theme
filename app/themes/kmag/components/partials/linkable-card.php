<?php
/**
 * ACF Module: Card
 *
 * @global $data
 */

use CN\App\Fields\ACF;
use CN\App\Fields\Util;
use CN\App\Fields\ModuleUtils\CardUtils;
use CN\App\Media;

// element preferences
$card_size = ACF::getField('card-size', $data);
$desktop_rounding = ACF::getField('image-corner-rounding_desktop-rounding', $data, []);
$mobile_rounding = ACF::getField('image-corner-rounding_mobile-rounding', $data, []);
$desktop_image_size = ACF::getField('desktop-image-size', $data, 'cover');
$mobile_image_size = ACF::getField('mobile-image-size', $data, 'cover');

// Card Classes
$card_size_class = $card_size === 'large' ? '' : 'card--small';
$desktop_rounding_classes = CardUtils::getRoundingCssClasses($desktop_rounding);
$mobile_rounding_classes = CardUtils::getRoundingCssClasses($mobile_rounding);

// Elements
$heading = ACF::getField('card-headline', $data);
$has_heading = ! empty($heading);
$text_content = ACF::getField('card-paragraph', $data);
$has_text_content = ! empty($text_content);
$button = ACF::getField('card-button', $data);
$has_button = ! empty($button);

// Linking Option 
$has_card_link = ACF::getField('has-card-link', $data);
if ($has_card_link) {
    $link = ACF::getField('card-link', $data);
    $card_link = $link['url'];
    $card_target = ACF::getField('set-target-top', $data) ? '_top' : $link['target'];
    $card_target = $card_target ? $card_target : '_self';
}

// Image
$card_image = ACF::getField('card-image', $data);
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
$card_image_mobile = ACF::getField('card-image-mobile', $data);
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

<div class="module card <?php echo esc_attr($card_size_class); ?>">
    <?php if ($has_card_link) { ?>
        <a href="<?php echo esc_url($card_link); ?>" target="<?php echo esc_attr($card_target); ?>">
    <?php } ?>
    <?php if ($has_image || $has_mobile_image) { ?>
        <div class="card__figure <?php echo $desktop_rounding_classes?>" style="<?php echo $desktop_image_styles ?>" aria-label="<?php echo $image_alt ?>"></div>
        <div class="card__figure-mobile <?php echo $mobile_rounding_classes?>" style="<?php echo $mobile_image_styles ?>" aria-label="<?php echo $image_alt ?>"></div>
    <?php } ?>

    <?php if ($has_heading || $has_text_content || $has_button) { ?>
        <div class="card__content">
            <?php 
            if ($has_heading) {
                CardUtils::getHeadingHtml($heading, $card_size);
            }
            ?>

            <?php if ($has_text_content) { ?>
                <div class="card__text"> <?php echo apply_filters('the_content', $text_content); ?> </div>
            <?php } ?>
            <?php if ($has_button) { ?>
                <div class="card__button">
                    <?php echo $button_html; ?>
                </div>
            <?php } ?>

        </div>
    <?php } ?>
    <?php if ($has_card_link) { ?>
        </a>
    <?php } ?>
</div>