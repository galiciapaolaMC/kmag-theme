<?php
/**
 * ACF Module Partial: VideoBlock
 *
 * @var array $data
 *
 * @var string $row_id
 *
 * @var string $cell_number
 *
 */

use CN\App\Media;
use CN\App\Fields\ACF;
use CN\App\Fields\Util;
use CN\App\Fields\ModuleUtils\FiftyFiftyUtils;

$video_id = ACF::getField('video_id', $data);
$video_image_mobile  = Media::getAttachmentByID(ACF::getField('video_image_mobile', $data));
$video_image_desktop = Media::getAttachmentByID(ACF::getField('video_image_desktop', $data));
$desktop_image_size = ACF::getField('desktop-image-size', $data, 'cover');
$mobile_image_size = ACF::getField('mobile-image-size', $data, 'cover');
$image_shape = ACF::getField('image_shape', $data);
$theme_color = 'theme-' . ACF::getField('theme_color', $data);
$event = "{$row_id}-{$cell_number}";

$mobile_image = '';
$desktop_image = '';

$desktop_rounding = ACF::getField('image-corner-rounding_desktop-rounding', $data, []);
$mobile_rounding = ACF::getField('image-corner-rounding_mobile-rounding', $data, []);
$desktop_rounding_classes = FiftyFiftyUtils::getRoundingCssClasses($desktop_rounding, 'video');
$mobile_rounding_classes = FiftyFiftyUtils::getRoundingCssClasses($mobile_rounding, 'video');

if (!empty($video_image_mobile)) {
    $mobile_image = ' style="background-image: url(' . esc_url($video_image_mobile->url) . '); background-size: ' . esc_attr($mobile_image_size) . ';"';
}

if (!empty($video_image_desktop)) {
    $desktop_image = ' style="background-image: url(' . esc_url($video_image_desktop->url) . '); background-size: ' . esc_attr($desktop_image_size) . ';"';
}

$style_classes = "{$theme_color} {$cell_number}-child";

?>

<div class="partial column-content__video-fifty-fifty video-fifty-fifty--<?php echo esc_attr($image_shape); ?> <?php echo esc_attr($style_classes); ?>">
    <div class="video-fifty-fifty__inside-wrap">
        <div class="video-fifty-fifty__image-holder <?php echo $mobile_rounding_classes; ?> mobile"<?php echo $mobile_image; ?>></div>
        <div class="video-fifty-fifty__image-holder <?php echo $desktop_rounding_classes; ?> desktop"<?php echo $desktop_image; ?>></div>
        <div class="video-fifty-fifty__button-wrapper">
            <button class="video-fifty-fifty__play-btn" data-id="<?php echo esc_attr($video_id); ?>" data-event="<?php echo esc_attr($event); ?>">
                <?php echo Util::getIconHTML('play-arrow'); ?> 
            </button>
        </div>
    </div>
    <?php
    echo do_shortcode('[mc_modal trigger_type="event" event_name="event-' . esc_attr($event) . '" has_close_button="true" close_on_background_click="true"]<div class="column-content__modal-iframe-wrapper"><iframe src="" class="column-content-video" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div>[/mc_modal]'); ?>
</div>
        
  
