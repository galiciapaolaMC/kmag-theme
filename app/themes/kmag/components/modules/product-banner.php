<?php

/**
 * ACF Module: Product Banner
 *
 * @global $data
 */

use CN\App\Fields\ACF;
use CN\App\Fields\Util;
use CN\App\Media;

$type = ACF::getField('type', $data, 'full-width-text');
$image_id = ACF::getField('image', $data);
$mobile_image_id = ACF::getField('mobile-image', $data);
$subtitle = ACF::getField('subtitle', $data);
$content = ACF::getField('content', $data);
$source = ACF::getField('source', $data);
$performance_product = ACF::getField('perfomance-product-banner', $data);
$text_color = ACF::getField('text-color', $data, 'black');

if (is_array($performance_product) && !empty($performance_product)) {
    $fields = ACF::getPostMeta($performance_product[0]);
} else {
    $fields = array(
        'color' => 'background: #202124'
    );
}

if (empty($content)) {
    return;
}

do_action('cn/modules/styles', $row_id, $data);
?>

<div class="module product-banner" id="<?php echo esc_attr($row_id); ?>">
    <?php if ($type === 'full-width-text') { ?>
        <div class="product-banner__content text-color-<?php echo esc_attr($text_color); ?>" style="background-color: <?php echo esc_attr($fields['color']); ?>">
            <div class="uk-container">
                <?php echo apply_filters('the_content', $content); ?>

                <?php if (!empty($source)) {
                    $source['title'] = __('Source: ', 'kmag') . $source['title'];
                    echo Util::getButtonHTML($source, ['class' => 'source']);
                } ?>
            </div>
        </div>
    <?php } ?>

    <?php if ($type === 'campaign-asset') { ?>
        <div class="product-banner__content campaign-asset text-color-<?php echo esc_attr($text_color); ?>" style="background-color: <?php echo esc_attr($fields['color']); ?>">
            <?php if (!empty($image_id)) { ?>
                <div class="product-banner__image-container uk-background-cover" style="background-image: url(<?php echo Media::getAttachmentSrcById($image_id, 'full'); ?>);"></div>

                <?php if (!empty($mobile_image_id)) { ?>
                    <div class="product-banner__image-container-mobile uk-background-cover" style="background-image: url(<?php echo Media::getAttachmentSrcById($mobile_image_id, 'full'); ?>);"></div>
                <?php } else { ?>
                    <div class="product-banner__image-container-mobile uk-background-cover" style="background-image: url(<?php echo Media::getAttachmentSrcById($image_id, 'full'); ?>);"></div>
                <?php } ?>
            <?php } ?>

            <?php if (!empty($subtitle)) {
                echo Util::getHTML(
                    $subtitle,
                    'h1',
                    ['class' => 'product-banner__subtitle']
                );
            } ?>

            <?php if (!empty($content)) { ?>
                <div class="product-banner__campaign-content text-color-<?php echo esc_attr($text_color); ?>">
                    <?php echo apply_filters('the_content', $content); ?>
                </div>
            <?php } ?>

            <?php if (!empty($source)) {
                $source['title'] = __('Source: ', 'kmag') . $source['title'];
                echo Util::getButtonHTML($source, ['class' => 'source']);
            } ?>
        </div>
    <?php } ?>
</div>