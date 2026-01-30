<?php
/**
 * ACF Module: Video
 *
 * @global $data
 */

use CN\App\Fields\ACF;
use CN\App\Media;
use CN\App\Fields\Util;

$type = ACF::getField('type', $data);
$video_link = ACF::getField('video-link', $data);
$video_file_id = ACF::getField('video-file', $data);
$preview_image_id = ACF::getField('preview-image', $data);

if (! $type) {
    return;
}

do_action('cn/modules/styles', $row_id, $data);
?>

<div class="module video" id="<?php echo esc_attr($row_id); ?>">
    <div class="video__container">
        <?php if ($type === 'link') { ?>
            <iframe class="video__content" src="<?php echo esc_url($video_link); ?>"></iframe>
        <?php } else {
            $attachment_video = Media::getAttachmentByID($video_file_id); 
            $preview_image = '';

            if (!empty($preview_image_id)) {
                $preview_image_url = Media::getAttachmentByID($preview_image_id);  ?>

                <video class="video__content video-file" src="<?php echo esc_html($attachment_video->url); ?>" style="background-image: url(<?php echo esc_url($preview_image_url->url); ?>)" poster="<?php bloginfo('template_url'); ?>/assets/images/poster.png" controls playsinline type="video/mp4" uk-video="autoplay: false"></video>
            <?php } else { ?> 
                <video class="video__content video-file" src="<?php echo esc_html($attachment_video->url); ?>" controls playsinline type="video/mp4" uk-video="autoplay: false"></video>
            <?php } ?> 

            <button class="play-btn">
                <svg class="icon icon-play-arrow " aria-hidden="true">
                    <use xlink:href="#icon-play-arrow"></use>
                </svg> 
            </button>

        <?php } ?>
    </div>
</div>
