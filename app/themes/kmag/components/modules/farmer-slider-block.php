<?php
/**
 * ACF Module: Farmer Slider Block
 *
 * @var array $data
 * @var string $row_id
 *
 */

use CN\App\Fields\ACF;
use CN\App\Media;

$section_class = ACF::getField('section_class', $data);
$sliders = ACF::getRowsLayout('slides_farmer_details', $data);
$columns = ACF::getRowsLayout('columns', $data);
$background_color = ACF::getField('background_color', $data);
$gap_size = ACF::getField('gap_size', $data);
$reverse_columns_mobile = ACF::getField('reverse_mobile', $data);
$column_count = count($columns);
if (!empty($section_class)) {
    $section_class = " {$section_class}";
}
do_action('cn/modules/styles', $row_id, $data);
?>
<section id="<?php echo esc_attr($row_id); ?>"
         class="module farmer-slider-block <?php echo esc_attr($section_class); ?>"
         style="background: <?php echo esc_attr($background_color); ?>;">
    <div class="farmer-slider-block__slider">
        <div uk-slider>
            <div class="uk-slider-container uk-position-relative uk-visible-toggle uk-light" tabindex="-1">
                <ul class="uk-slider-items uk-child-width-1-1@s uk-grid">
                    <?php foreach ($sliders as $key => $item) {
                        ?>
                        <li data-index="<?php echo esc_attr($key); ?>">
                            <div class="main-holder">
                                <div class="left">
                                    <div class="img-holder">
                                        <?php

                                        $has_image = !empty($item['image']);
                                        $image_attachment = $has_image ? Media::getAttachmentByID($item['image']) : false;
                                        $src = $image_attachment ? ACF::getField('full', $image_attachment->sizes, $image_attachment->url) : null;
                                        $image_alt = '';
                                        if ($has_image) {
                                            $image_alt = !empty($image_attachment->alt) ? esc_attr($image_attachment->alt) : esc_attr($image_attachment->title);
                                        }

                                        $has_logo = !empty($item['farmer_logo']);
                                        $logo_attachment = $has_logo ? Media::getAttachmentByID($item['farmer_logo']) : false;
                                        $logo_src = $logo_attachment ? ACF::getField('full', $logo_attachment->sizes, $logo_attachment->url) : null;
                                        $logo_alt = '';
                                        if ($has_logo) {
                                            $logo_alt = !empty($logo_attachment->alt) ? esc_attr($logo_attachment->alt) : esc_attr($logo_attachment->title);
                                        }

                                        $body = $item['body'];
                                        $link_array = $item['link'];
                                        $crops = $item['crop_details_crops'];
                                        $tillage = $item['tillage'];
                                        $title = $item['title'];
                                        $sub_title = $item['sub_title'];
                                        $next_link = '';
                                        if (isset($item['link']['title'])) {
                                            $next_link = $item['link']['title'];
                                        }
                                        $social_media_facebook_link = $item['social_media_facebook_link'];
                                        $social_media_twitter_link = $item['social_media_twitter_link'];
                                        $social_media_instagram_link = $item['social_media_instagram_link'];
                                        $social_media_tiktok_link = $item['social_media_tiktok_link'];
                                        $acres = $item['acres_details_acres'];
                                        $acres_bg = $item['acres_details_background_color'];
                                        $acres_fn_color = $item['acres_details_font_color'];
                                        $crop_bg = $item['crop_details_background_image'];

                                        $has_crop_bg = !empty($crop_bg);
                                        $crop_bg_attachment = $has_crop_bg ? Media::getAttachmentByID($crop_bg) : false;
                                        $crop_bg_src = $crop_bg_attachment ? ACF::getField('full', $crop_bg_attachment->sizes, $crop_bg_attachment->url) : null;

                                        ?>
                                        <img src="<?php echo esc_url($src); ?>"
                                             alt="<?php echo esc_attr($image_alt); ?>"
                                             class="slider-img">
                                        <div class="content-holder">
                                            <img src="<?php echo esc_url($logo_src); ?>"
                                                 alt="<?php echo esc_attr($logo_alt); ?>" class="farmer-logo">
                                        </div>
                                    </div>
                                </div>
                                <div class="right">
                                    <div class="mt-wrapper">
                                        <div>
                                            <h3 class="title"><?php echo esc_html($title); ?></h3>
                                            <div class="sub-title"><?php echo esc_html($sub_title); ?></div>
                                            <div class="content">
                                                <?php echo apply_filters('the_content', $body); ?>
                                            </div>
                                            <?php if ($social_media_facebook_link || $social_media_twitter_link || $social_media_instagram_link || $social_media_tiktok_link) { ?>
                                                <div class="social-media-wrapper">
                                                    <?php if ($social_media_facebook_link) { ?>
                                                        <div class="icon-wrapper">
                                                            <a href="<?php echo esc_url($social_media_facebook_link); ?>"
                                                               target="_blank">
                                                                <svg class="icon" aria-hidden="true">
                                                                    <use xlink:href="#icon-facebook"></use>
                                                                </svg>
                                                            </a>
                                                        </div>
                                                    <?php } ?>
                                                    <?php if ($social_media_twitter_link) { ?>
                                                        <div class="icon-wrapper">
                                                            <a href="<?php echo esc_url($social_media_twitter_link); ?>"
                                                               target="_blank">
                                                                <svg class="icon" aria-hidden="true">
                                                                    <use xlink:href="#icon-twitter-new"></use>
                                                                </svg>
                                                            </a>
                                                        </div>
                                                    <?php } ?>
                                                    <?php if ($social_media_instagram_link) { ?>
                                                        <div class="icon-wrapper">
                                                            <a href="<?php echo esc_url($social_media_instagram_link); ?>"
                                                               target="_blank">
                                                                <svg class="icon" aria-hidden="true">
                                                                    <use xlink:href="#icon-instagram"></use>
                                                                </svg>
                                                            </a>
                                                        </div>
                                                    <?php } ?>
                                                    <?php if ($social_media_tiktok_link) { ?>
                                                        <div class="icon-wrapper">
                                                            <a href="<?php echo esc_url($social_media_tiktok_link); ?>"
                                                               target="_blank">
                                                                <svg class="icon" aria-hidden="true">
                                                                    <use xlink:href="#icon-tiktok"></use>
                                                                </svg>
                                                            </a>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            <?php } ?>
                                            <?php if ($next_link) { ?>
                                                <div class="next-move">
                                                    <button uk-slidenav-next uk-slider-item="next"
                                                            type="button">
                                                        <?php echo esc_html($next_link); ?>
                                                        <div class="arrow">
                                                            <svg class="icon" aria-hidden="true">
                                                                <use xlink:href="#icon-arrow-right"></use>
                                                            </svg>
                                                        </div>
                                                    </button>
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <?php if ($acres || (is_array($crops) && count($crops)) || $tillage) { ?>
                                            <div>
                                                <div class="operation-overview">
                                                    <div class="sub-holder">
                                                        <div class="top-label"><?php _e('Operation overview:', 'kmag'); ?></div>
                                                        <div class="group-wrapper">
                                                            <?php if ($acres) { ?>
                                                                <div class="land-wrapper" <?php if ($acres_bg) { ?> style="background-color: <?php echo esc_attr($acres_bg); ?>;" <?php } ?>>
                                                                    <div class="label" <?php if ($acres_fn_color) { ?> style="color: <?php echo esc_attr($acres_fn_color); ?>;" <?php } ?>>
                                                                        <?php _e('Acres:', 'kmag'); ?></div>
                                                                    <div class="data" <?php if ($acres_fn_color) { ?> style="color: <?php echo esc_attr($acres_fn_color); ?>;" <?php } ?>>
                                                                        <?php echo number_format(esc_html($acres)); ?>
                                                                    </div>
                                                                </div>
                                                            <?php } ?>
                                                            <?php if (is_array($crops) && count($crops)) { ?>
                                                                <div class="crops-wrapper"
                                                                    <?php if ($crop_bg_src) { ?> style="background-image: url(<?php echo esc_url($crop_bg_src); ?>);" <?php } ?>
                                                                    <?php if (empty($crop_bg_src)) { ?> style="border: 3px solid var(--color-white); border-radius: 10px;" <?php } ?>
                                                                >
                                                                    <div class="title"><?php _e('Crops:', 'kmag'); ?></div>
                                                                    <div class="crops-list">
                                                                        <?php foreach ($crops as $crop_name) { ?>
                                                                            <div class="crop">
                                                                                <div class="crop-ico-holder">
                                                                                    <svg class="icon icon-<?php echo esc_attr($crop_name); ?>">
                                                                                        <use xlink:href="#icon-<?php echo esc_attr($crop_name); ?>"></use>
                                                                                    </svg>
                                                                                </div>
                                                                                <div class="crop-name"><?php echo esc_html($crop_name); ?></div>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                </div>
                                                            <?php } ?>
                                                            <?php if ($tillage) { ?>
                                                                <div class="tillage-wrapper">
                                                                    <div class="title"><?php _e('Tillage', 'kmag'); ?></div>
                                                                    <div class="content"><?php echo esc_html($tillage); ?></div>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                        </li>
                    <?php } ?>
                </ul>
                <ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin"></ul>
            </div>
        </div>
    </div>
</section>
