<?php
/**
 * ACF Module: Short Hero
 *
 * @global $data
 */

use CN\App\Fields\ACF;
use CN\App\Fields\Util;
use CN\App\Media;

$headline = ACF::getField('headline', $data);
$link = ACF::getField('link', $data);
$type = ACF::getField('type', $data, 'short-hero');
$text_color = ACF::getField('text-color', $data, 'white');
$mobile_text_size = ACF::getField('mobile-text-size', $data, 'big');
$hero_media = ACF::getField('hero-media', $data);
$image_overlay = ACF::getField('image-overlay', $data, 'true');
$image_id = ACF::getField('image', $data);
$mobile_image_id = ACF::getField('mobile-image', $data);
$video_id = ACF::getField('video-file', $data);
$mobile_video_id = ACF::getField('mobile-video-file', $data);
$vimeo_id = ACF::getField('vimeo-link-id', $data);
$video_class = '';
$dynamic_swap_desktop = ' module__background--desktop';
$dynamic_swap_mobile = ' module__background--mobile';
$overlay_class = '';

if ($hero_media === 'video-hero') {
    $video_class = 'video-hero';
}

if ($image_overlay === 'true') {
    $overlay_class = 'hero__image-overlay';
}

do_action('cn/modules/styles', $row_id, $data);
?>

<section class="module hero uk-inline short-hero-module <?php echo esc_attr($type); ?> <?php echo esc_attr($video_class); ?> <?php echo esc_attr($overlay_class); ?>" id="<?php echo esc_attr($row_id); ?>">
    <?php if ($hero_media === 'image-hero') {
        if (!empty($image_id)) { ?> 
            <div class="hero__image-container uk-background-cover<?php echo $dynamic_swap_desktop; ?>" style="background-image: url(<?php echo Media::getAttachmentSrcById($image_id, 'full'); ?>); <?php echo Util::getInlineBackgroundStyles($data); ?>" data-default-image="<?php echo Media::getAttachmentSrcById($image_id, 'full'); ?>"></div>

            <?php if (!empty($mobile_image_id)) { ?> 
                <div class="hero__image-container-mobile short-hero uk-background-cover<?php echo $dynamic_swap_mobile;?>">
                    <img src="<?php echo Media::getAttachmentSrcById($mobile_image_id, 'full'); ?>" />
                </div>
            <?php } else { ?>
                <div class="hero__image-container-mobile short-hero uk-background-cover<?php echo $dynamic_swap_mobile;?>">
                    <img src="<?php echo Media::getAttachmentSrcById($image_id, 'full'); ?>" />
                </div>
            <?php } 
        }
    } ?>

    <?php if ($hero_media === 'video-hero') {
        if (!empty($video_id)) {
            $attachment_video = Media::getAttachmentByID($video_id); ?> 

            <video autoplay loop muted playsinline preload="yes" class="hero__video uk-position-center-center">
                <source src="<?php echo esc_html($attachment_video->url); ?>" type="video/mp4">
            </video>

            <?php if (!empty($mobile_video_id)) {
                $attachment_video_mobile = Media::getAttachmentByID($mobile_video_id); ?>

                <video autoplay loop muted playsinline preload="yes" class="hero__video-mobile uk-position-center-center">
                    <source src="<?php echo esc_html($attachment_video_mobile->url); ?>" type="video/mp4">
                </video>
            <?php } else { ?>
                <video autoplay loop muted playsinline preload="yes" class="hero__video-mobile uk-position-center-center">
                    <source src="<?php echo esc_html($attachment_video->url); ?>" type="video/mp4">
                </video>
            <?php } ?>
        <?php }

        if (!empty($vimeo_id)) { ?>
            <iframe class="hero__video-link" src="https://player.vimeo.com/video/<?php echo esc_html($vimeo_id); ?>?badge=0&autoplay=1&loop=1&title=0&byline=0&portrait=0&muted=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
        <?php }
    } ?>

    <?php if (!empty($headline)) { ?>
        <div class="hero__banner-content text-color-<?php echo esc_attr($text_color); ?>">
            <?php if (!empty($headline)) {
                printf(
                    '<h1 class="hero__title %1$s">%2$s</h1>',
                    esc_attr($mobile_text_size),
                    nl2br(strip_tags($headline, ALLOWED_FORMAT_TAGS))
                );
            } ?>

            <?php if (!empty($link)) {
                echo Util::getButtonHTML($link, ['class' => 'btn btn--tertiary']);
            } ?>
        </div>
<?php } ?>
</section>

