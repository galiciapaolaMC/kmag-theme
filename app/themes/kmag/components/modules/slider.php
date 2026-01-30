<?php
/**
 * ACF Module: Slider
 *
 * @global $data
 */

use CN\App\Fields\ACF;
use CN\App\Fields\Util;
use CN\App\Media;

$items = ACF::getRowsLayout('items', $data);

if (!$items) {
    return;
}

do_action('cn/modules/styles', $row_id, $data);
?>

<div class="module slider" id="<?php echo esc_attr($row_id); ?>">
    <div class="slider__container" uk-slider>
        <div class="uk-position-relative">
            <div class="uk-slider-container">
                <ul class="uk-slider-items uk-child-width-1-2@m uk-child-width-1-1@s uk-grid">
                    <?php foreach ($items as $index => $item) { 
                        $media_type = ACF::getField('media-type', $item, 'image'); 
                        $description = ACF::getField('description', $item);
                        
                        if ($media_type === 'image') {
                            $image_id = ACF::getField('image', $item); ?>

                            <li class="slider__item-image">
                                <div class="slider__item-image-container" style="<?php echo Util::getBackgroundImageStyle($image_id); ?>"></div>
                                
                                <?php if (!empty($description)) { ?>
                                    <div class="slider__item-description">
                                        <?php echo esc_html($description); ?>
                                    </div>
                                <?php } ?>
                            </li>
                        <?php } 
                        
                        if ($media_type === 'video') {
                            $video_link = ACF::getField('video-link', $item);
                            $video_image = Media::getAttachmentByID(ACF::getField('preview-image', $item)); 
                            $event = "{$row_id}-{$index}";

                            if (!empty($video_image)) {
                                $desktop_image = ' style="background-image: url(' . esc_url($video_image->url) . ');"';
                            } ?>

                            <li class="slider__item-video">
                                <div class="slider__item-video--inside-wrap">
                                    <div class="slider__item-video--image-holder" <?php echo $desktop_image; ?>></div>
                                    <div class="slider__item-video--button-wrapper">
                                        <button class="slider__item-video--play-btn" data-src="<?php echo esc_attr($video_link); ?>" data-event="<?php echo esc_attr($event); ?>">
                                            <?php echo Util::getIconHTML('play-arrow'); ?> 
                                        </button>
                                    </div>
                                </div>

                                <?php
                                
                                if (!empty($description)) { ?>
                                    <div class="slider__item-description">
                                        <?php echo esc_html($description); ?>
                                    </div>
                                <?php } ?>
                            </li>
                        <?php } ?>

                    <?php } ?>
                </ul>

                <?php foreach ($items as $index => $item) { 
                    $media_type = ACF::getField('media-type', $item, 'image'); 
                    
                    if ($media_type === 'video') {
                        $event = "{$row_id}-{$index}";
                        
                        echo do_shortcode('[mc_modal trigger_type="event" event_name="event-' . esc_attr($event) . '" has_close_button="true" close_on_background_click="true"]<div class="column-content__modal-iframe-wrapper"><iframe src="" class="slider-item-video" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div>[/mc_modal]');
                            
                    } 
                } ?>

                <div class="slider-button-navigation uk-visible@m">
                    <button class="uk-position-center-left-out uk-position-small" uk-slidenav-previous uk-slider-item="previous"></button>
                    <button class="uk-position-center-right-out uk-position-small" uk-slidenav-next uk-slider-item="next"></button>
                </div>

                <div class="slider-button-navigation-mobile uk-hidden@m uk-light">
                    <button class="uk-position-center-left uk-position-small" uk-slidenav-previous uk-slider-item="previous"></button>
                    <button class="uk-position-center-right uk-position-small" uk-slidenav-next uk-slider-item="next"></button>
                </div>

                <ul class="uk-slider-nav uk-dotnav"></ul>
            </div>
        </div>
    </div>
</div>