<?php
/**
 * ACF Module: MediaAssetBanner
 *
 * @global $data
 */

use CN\App\Fields\ACF;
use CN\App\Fields\Util;
use CN\App\Media;

$icon = ACF::getField('science-of-more-icon', $data, 'icon-off');
$content = ACF::getField('content', $data);
$link = ACF::getField('link', $data);
$image_id = ACF::getField('image', $data);
$mobile_image_id = ACF::getField('mobile-image', $data);

$button_color = ACF::getField('button-color', $data);
$button_type = ACF::getField('link-type', $data);
$button_base_class = 'btn';
$button_args = [];

if (!empty($button_type)) {
    $button_args['button-type'] = $button_type;

    if ($button_type == 'inline-link') {
        $button_color = ACF::getField('inline-button-color', $data);
    }
}

$button_color_class = $button_color === 'btn--primary' ? '' : 'btn--' . $button_color;

$button_classes = implode(' ', [$button_base_class, $button_color_class]);

$button_args['class'] = $button_classes;

$left_button_icon = ACF::getField('button-icons_left_icon', $data);
if (!empty($left_button_icon) && $left_button_icon !== 'none') {
    $button_args['icon-start'] = $left_button_icon;
}
$right_button_icon = ACF::getField('button-icons_right_icon', $data);
if (!empty($right_button_icon) && $right_button_icon !== 'none') {
    $button_args['icon-end'] = $right_button_icon;
}

if (empty($image_id)) {
    return;
}

do_action('cn/modules/styles', $row_id, $data);
?>

<div class="module" id="<?php echo esc_attr($row_id); ?>">
    <div class="media-asset uk-inline">
        <div class="media-asset__image-container uk-background-cover"
            style="background-image: url(<?php echo Media::getAttachmentSrcById($image_id, 'full'); ?>); <?php echo Util::getInlineBackgroundStyles($data); ?>">
        </div>

        <?php if (!empty($mobile_image_id)) { ?>
        <div class="media-asset__image-container-mobile uk-background-cover"
            style="background-image: url(<?php echo Media::getAttachmentSrcById($mobile_image_id, 'full'); ?>); <?php echo Util::getInlineBackgroundStyles($data); ?>">
        </div>
        <?php } else { ?>
        <div class="media-asset__image-container-mobile uk-background-cover"
            style="background-image: url(<?php echo Media::getAttachmentSrcById($image_id, 'full'); ?>); <?php echo Util::getInlineBackgroundStyles($data); ?>">
        </div>
        <?php } ?>

        <div class="media-asset__container">
            <?php if (!empty($content)) { ?>
            <div class="media-asset__content">
                <?php echo apply_filters('the_content', $content); ?>
            </div>
            <?php  } ?>

            <?php if (!empty($link)) {
                echo '<div class="media-asset__button-container">'. Util::getButtonHTML($link, $button_args) . '</div>';
            } ?>
        </div>

        <?php if ($icon === 'icon-on') { ?>
        <svg class="icon icon-science-of-more media-asset__science-of-more-icon" aria-hidden="true">
            <use xlink:href="#icon-science-of-more"></use>
        </svg>
        <?php } ?>
    </div>
</div>