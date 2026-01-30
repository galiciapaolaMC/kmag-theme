<?php
/**
 * ACF Module: Carousel Hero
 *
 * @global $data
 */

use CN\App\Fields\ACF;
use CN\App\Fields\Util;
use CN\App\Media;

$slides = ACF::getRowsLayout('carousel-items', $data);
$display_interval = ACF::getField('display-interval', $data);

$slide_count = count($slides);


do_action('cn/modules/styles', $row_id, $data);
?>

<section class="module carousel-hero" id="<?php echo esc_attr($row_id); ?>" data-row-id="<?php echo esc_attr($row_id);?>" data-interval="<?php echo esc_attr($display_interval);?>">
    <div class="carousel-hero__slides">
    <?php
    foreach ($slides as $index => $slide) {
        $is_active_class = $index === 0 ? 'carousel-hero-slide--active' : '';
        $media_type = ACF::getField('media-type', $slide, 'image-upload');
        $video_link = ACF::getField('video-link', $slide);
        $video_file_id = ACF::getField('video-file', $slide);
        $hero_image_id = ACF::getField('hero-image', $slide);
        $mobile_hero_image_id = ACF::getField('mobile-hero-image', $slide);

        $link_type = ACF::getField('link-type', $slide, 'internal');
        $link_element = ACF::getField('link-element', $slide, 'full-banner');
        $internal_link = ACF::getField('link', $slide, '#');
        $extenal_link_url = ACF::getField('external-link_url', $slide, '#');
        $extenal_link_text = ACF::getField('external-link_link-text', $slide, 'Learn More');
        $link_button_text = null;
        $link_button_href = null;
        $link_button_theme = ACF::getField('button-styles_button-theme', $slide, 'light-gray');
        $link_button_theme_class = 'carousel-hero-slide__button--theme-' . $link_button_theme;
        if ($link_type === 'internal') {
            $link_button_text = $internal_link['title'] ?? null;
            $link_button_href = $internal_link['url'] ?? '#';
        } elseif ($link_type === 'external') {
            $link_button_text = $extenal_link_text;
            $link_button_href = $extenal_link_url;
        }

        $slide_opening_tag = '<div id="slide-'. $row_id . '-' . $index .'" class="carousel-hero-slide '. $is_active_class .'" data-slide-index="' . $index .'">';
        $slide_closing_tag = '</div>';

        if ($link_element === 'full-banner') {
            $slide_opening_tag = '<a id="slide-'. $row_id . '-' . $index .'" href="' . esc_attr($extenal_link_url) . '" class="carousel-hero-slide carousel-hero-slide--link '. $is_active_class .'" data-slide-index="' . $index .'">';
            $slide_closing_tag = '</a>';
        }

        $logo = ACF::getField('logo', $slide);

        $headline_text = nl2br(strip_tags(ACF::getField('headline', $slide), ALLOWED_FORMAT_TAGS));
        $headline_emphasis_color = ACF::getField('heading-styles_emphasis-text-color', $slide, 'light-gray');
        $heading_emphasis_class = 'carousel-hero-slide__headline--emphasis-' . $headline_emphasis_color;
        $headline_text_size = ACF::getField('heading-styles_text-size', $slide, 'medium');
        $heading_size_class = 'carousel-hero-slide__headline--size-' . $headline_text_size;
        $heading_classes = 'carousel-hero-slide__headline ' . $heading_emphasis_class . ' ' . $heading_size_class;


        ?>
            <?php echo $slide_opening_tag; ?>
                <?php if ($media_type === 'image-upload') { ?>
                    <div class="carousel-hero-slide__image" style="background-image: url(<?php echo esc_attr(Media::getAttachmentSrcById($hero_image_id, 'full')); ?>);"></div>
                    <?php if (!empty($mobile_hero_image_id)) { ?>
                        <div
                            class="carousel-hero-slide__image-mobile"
                            aria-label="<?php echo esc_attr(Media::getAttachmentAltById($mobile_hero_image_id)); ?>"
                        >
                            <img src="<?php echo esc_attr(Media::getAttachmentSrcById($mobile_hero_image_id, 'full')); ?>" alt="<?php echo esc_attr(Media::getAttachmentAltById($mobile_hero_image_id)); ?>">
                        </div>
                    <?php } else { ?>
                        <div
                            class="carousel-hero-slide__image-mobile"
                            style="background-image: url(<?php echo esc_attr(Media::getAttachmentSrcById($hero_image_id, 'full')); ?>);"
                            aria-label="<?php echo esc_attr(Media::getAttachmentAltById($hero_image_id)); ?>"
                        >
                        </div>
                    <?php } ?>
                <?php } elseif ($media_type === 'video-link') { ?>
                    <div class="carousel-hero-slide__video">
                        <iframe src="<?php echo esc_attr($video_link); ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" modestbranding
                         loop="1" controls="0" autoplay="1" allowfullscreen></iframe>
                    </div>
                <?php } elseif ($media_type === 'video-upload' && !empty($video_file_id)) { 
                    $attachment_video = Media::getAttachmentByID($video_file_id);
                    ?>
                    <div class="carousel-hero-slide__video">
                        <video autoplay muted loop>
                            <source src="<?php echo esc_html($attachment_video->url); ?>" type="video/mp4">
                            <?php _e('Your browser does not support the video tag.', 'kmag'); ?>
                        </video>
                    </div>
                <?php } ?>
                <div class="carousel-hero-slide__content">
                    <?php if ($logo) { ?>
                        <img src="<?php echo esc_attr(Media::getAttachmentSrcById($logo, 'full')); ?>" alt="<?php echo esc_attr(Media::getAttachmentAltById($logo)); ?>" class="carousel-hero-slide__logo">
                    <?php } else {
                        ?>
                        <div class="carousel-hero-slide__logo--spacer" aria-hidden="true"></div>
                        <?php
                    } ?>
                    <h2 class="<?php echo esc_attr($heading_classes); ?>"><?php echo $headline_text; ?></h2>
                    <?php 
                    if ($link_element === 'button' && !is_null($link_button_text)) {
                        ?>
                            <a href="<?php echo esc_attr($link_button_href); ?>" class="carousel-hero-slide__button <?php echo esc_html($link_button_theme_class); ?>"><?php echo esc_html($link_button_text); ?></a>
                        <?php 
                    }
                    ?>
                </div>
            <?php echo $slide_closing_tag; ?>
        <?php
    }
    ?>
    </div>
    <?php if($slide_count > 1) { ?>
    <div class="carousel-hero-controls">
        <div class="carousel-hero-controls__dots">
            <?php 
            foreach ($slides as $index => $slide) {
                if ($index === 0) {
                    $is_active_class = 'carousel-hero-controls__dot--active';
                } else {
                    $is_active_class = '';
                }
            ?>
                <button class="carousel-hero-controls__dot <?php echo $is_active_class; ?>" aria-controls="<?php echo 'slide-' . $row_id . '-' . $index; ?>" data-corresponding-slide="<?php echo $row_id . '-' . $index; ?>" data-dot-index="<?php echo $index; ?>"></button>
            <?php
            }
            ?>
        </div>
        <div class="carousel-hero-controls__sequential">
            <button class="carousel-hero-controls__prev carousel-hero-controls__control" aria-label="Previous Slide">
                <svg class="icon icon-arrow-left" aria-hidden="true">
                    <use xlink:href="#icon-arrow-left"></use>
                </svg>
            </button>
            <button class="carousel-hero-controls__play-pause carousel-hero-controls__control" aria-label="Play Slideshow">
                <svg class="icon icon-play-pause" aria-hidden="true">
                    <use xlink:href="#icon-play-pause"></use>
                </svg>
            <button class="carousel-hero-controls__next carousel-hero-controls__control" aria-label="Next Slide">
                <svg class="icon icon-arrow-right" aria-hidden="true">
                    <use xlink:href="#icon-arrow-right"></use>
                </svg>
            </button>
        </div>
    </div>
    <?php } ?>
</section>