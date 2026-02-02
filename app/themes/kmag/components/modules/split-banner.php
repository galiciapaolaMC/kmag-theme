<?php
/**
 * ACF Module: SplitBanner
 *
 * @global $data
 * @var array $data
 * @var string $row_id
 * @var string $cell_number
 */

use CN\App\Fields\ACF;
use CN\App\Fields\Util;
use CN\App\Media;

$type = ACF::getField('type', $data, 'large-banner');
$performance_product = ACF::getField('performance-product', $data);

$image_position = ACF::getField('image-position', $data, 'left');
$background_color = ACF::getField('content-background-color', $data, '#161E10');
$font_color = ACF::getField('font-color', $data, 'black');
$image_id = ACF::getField('image', $data);
$mobile_image_id = ACF::getField('mobile-image', $data);
$left_image_id = ACF::getField('left-image', $data);
$left_mobile_image_id = ACF::getField('left-mobile-image', $data);
$right_image_id = ACF::getField('right-image', $data);
$right_mobile_image_id = ACF::getField('right-mobile-image', $data);
$subtitle = ACF::getField('subtitle', $data);
$headline = ACF::getField('headline', $data);
$content = ACF::getField('content', $data);
$link_button = ACF::getField('link-button', $data);
$download_button = ACF::getField('download-button', $data);
$headline_right_column = ACF::getField('headline-right-column', $data);
$content_right_column = ACF::getField('content-right-column', $data);
$link_button_right_column = ACF::getField('link-button-right-column', $data);
$left_logo_id = ACF::getField('left-content-logo', $data);
$right_logo_id = ACF::getField('right-content-logo', $data);
$location_icon_color = ACF::getField('location-icon-color', $data, 'white');
$region_crop_cta = ACF::getField('region-crop-cta', $data, false);
$video_thumbail_id = ACF::getField('video-thumbnail', $data);
$video_link = ACF::getField('video-link', $data);
$center_class = '';
$region_crop_activated_class = '';

$button_color = ACF::getField('button-color', $data, 'primary');
$button_base_class = 'btn btn--small';
$button_color_class = $button_color === 'btn--primary' ? '' : 'btn--' . $button_color;
$region_crop_button_class = $region_crop_cta ? 'region-crop-cta-button' : '';
$button_classes = implode(' ', [$button_base_class, $button_color_class, $region_crop_button_class]);

$button_args = ['class' => $button_classes];

if ($region_crop_cta) {
    $region_crop_activated_class = ' region-crop-cta-activated';
}

$left_button_icon = ACF::getField('button-icons_left_icon', $data);
if (!empty($left_button_icon) && $left_button_icon !== 'none') {
    $button_args['icon-start'] = $left_button_icon;
}
$right_button_icon = ACF::getField('button-icons_right_icon', $data);
if (!empty($right_button_icon) && $right_button_icon !== 'none') {
    $button_args['icon-end'] = $right_button_icon;
}

$second_button_color = ACF::getField('second-button-color', $data, 'primary');
$second_button_base_class = 'btn btn--small';
$second_button_color_class = $second_button_color === 'btn--primary' ? '' : 'btn--' . $second_button_color;
$second_button_classes = implode(' ', [$second_button_base_class, $second_button_color_class]);

$second_button_args = ['class' => $second_button_classes];

$second_left_button_icon = ACF::getField('second-button-icons_left_icon', $data);
if (!empty($second_left_button_icon) && $second_left_button_icon !== 'none') {
    $second_button_args['icon-start'] = $second_left_button_icon;
}
$second_right_button_icon = ACF::getField('second-button-icons_right_icon', $data);
if (!empty($second_right_button_icon) && $second_right_button_icon !== 'none') {
    $second_button_args['icon-end'] = $second_right_button_icon;
}

if ($type !== 'short-content-banner') {
    $center_class = 'uk-position-center';
}

$performance_product_string = $performance_product;
if (is_array($performance_product)) {
    $performance_product_string = implode(',', $performance_product);
}

do_action('cn/modules/styles', $row_id, $data);
$video_modal_html ='';
$unique_class = wp_unique_id('watch-video_');
?>

<div class="module split-banner<?php echo $region_crop_activated_class; ?>" id="<?php echo esc_attr($row_id); ?>">
    <div class="split-banner__<?php echo esc_attr($type); ?>">
        <div class="uk-grid uk-grid-large uk-child-width-1-2@m uk-child-width-1-1@s uk-grid-match image-<?php echo esc_attr($image_position); ?>">
            <?php if ($type !== 'video-banner' && $type !== 'short-content-banner' && $type !== 'short-content-split-banner') { ?>
                <div class="split-banner__image uk-inline image-<?php echo esc_attr($image_position); ?>">
                    <div class="image-background uk-background-cover uk-visible@m" style="background-image: url(<?php echo Media::getAttachmentSrcById($image_id, 'full'); ?>)"></div>

                    <?php if (!empty($mobile_image_id)) { ?>
                        <div class="image-background uk-background-cover uk-hidden@m" style="background-image: url(<?php echo Media::getAttachmentSrcById($mobile_image_id, 'full'); ?>)"></div>
                    <?php } else { ?>
                        <div class="image-background uk-background-cover uk-hidden@m" style="background-image: url(<?php echo Media::getAttachmentSrcById($image_id, 'full'); ?>)"></div>
                    <?php } ?>
                </div>
            <?php } ?>
            <?php if ($type === 'video-banner') {?>
                <div class="split-banner__video uk-inline">
                    <div class="video-background uk-background-cover"
                         style="background-image: url(<?php echo Media::getAttachmentSrcById($video_thumbail_id, 'full'); ?>)"></div>
                    <div class="video-button-wrapper">
                        <button class="video-banner__play-btn <?php echo esc_attr($unique_class); ?> yt__play-btn">
                            <?php echo Util::getIconHTML('video'); ?>
                        </button>
                    </div>
                </div>
                <?php
                $video_modal_html .= do_shortcode('[mc_modal trigger_type="click" click_identifier=".' . esc_attr($unique_class) . '" has_close_button="true" close_on_background_click="true"]<div class="split-banner__modal-iframe-wrapper"><iframe data-backup_src="' . esc_attr($video_link) . '" src="' . esc_attr($video_link) . '" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div>[/mc_modal]');
            } ?>
            <?php if ($type !== 'short-content-split-banner') { ?>
                <div class="split-banner__content uk-inline image-<?php echo esc_attr($image_position); ?>">
                    <div class="split-banner__color-block <?php echo ($type == 'video-banner') ? 'split-banner__no-border-radius' : '' ?>" style="background-color: <?php echo esc_attr($background_color); ?>">
                        <div class="split-banner__content-container font-color-<?php echo esc_attr($font_color); ?> <?php echo esc_attr($center_class); ?>">
                            <?php if (!empty($subtitle)) { ?>
                                <h3 class="subtitle"><?php echo esc_html($subtitle); ?></h3>
                            <?php } ?>

                            <?php if (!empty($headline)) { ?>
                                <h2 class="headline"><?php echo $headline; ?></h2>
                            <?php } ?>

                            <?php if (!empty($content)) { ?>
                                <?php echo apply_filters('the_content', $content); ?>
                            <?php } ?>

                            <?php if ($type !== 'short-location-banner' || $type !== 'video-banner') { ?>
                                <?php if (!empty($link_button)) {
                                    if ($type === 'large-banner') {
                                        echo Util::getButtonHTML($link_button, $button_args);
                                    } else {
                                        echo Util::getButtonHTML($link_button, $button_args);
                                    }
                                } ?>

                                <?php if (!empty($download_button)) {
                                    echo Util::getButtonHTML($download_button, $second_button_args);
                                }
                            } ?>

                            <?php if ($type == 'video-banner') { ?>
                                <button class="btn btn--small btn--tertiary yt__play-btn <?php echo esc_attr($unique_class);?>">
                                    <?php _e('Watch', 'kmag'); ?>
                                </button>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <?php if ($type === 'short-content-banner') { ?>
                <div class="split-banner__content second-content-block uk-inline">
                    <div class="split-banner__color-block" style="background-color: <?php echo esc_attr($background_color); ?>">
                        <div class="split-banner__content-container font-color-<?php echo esc_attr($font_color); ?>">
                            <?php if (!empty($headline_right_column)) { ?>
                                <h2 class="headline"><?php echo $headline_right_column; ?></h2>
                            <?php } ?>

                            <?php if (!empty($content_right_column)) { ?>
                                <?php echo apply_filters('the_content', $content_right_column); ?>
                            <?php } ?>

                            <?php if (!empty($link_button_right_column)) {
                                echo Util::getButtonHTML($link_button_right_column, $button_args);
                            } ?>
                        </div>
                    </div>
                </div>
            <?php } ?>


            <?php if ($type === 'short-content-video-banner') { ?>
                <div class="split-banner__content second-content-block uk-inline">
                    <div class="split-banner__color-block"
                         style="background-color: <?php echo esc_attr($background_color); ?>">
                        <div class="split-banner__content-container font-color-<?php echo esc_attr($font_color); ?>">
                            <?php if (!empty($headline_right_column)) { ?>
                                <h2 class="headline"><?php echo $headline_right_column; ?></h2>
                            <?php } ?>

                            <?php if (!empty($content_right_column)) { ?>
                                <?php echo apply_filters('the_content', $content_right_column); ?>
                            <?php } ?>

                            <?php if (!empty($link_button_right_column)) {
                                echo Util::getButtonHTML($link_button_right_column, $button_args);
                            } ?>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <?php if ($type === 'short-content-split-banner') { ?>
                <div class="split-banner">
                    <div class="split-banner-container left-container">
                        <div class="split-banner-image uk-background-cover uk-visible@m" style="background-image: url(<?php echo Media::getAttachmentSrcById($left_image_id, 'full'); ?>)" ></div>

                        <?php if (!empty($left_mobile_image_id)) { ?>
                            <div class="split-banner-image uk-background-cover uk-hidden@m" style="background-image: url(<?php echo Media::getAttachmentSrcById($left_mobile_image_id, 'full'); ?>)" ></div>
                        <?php } else { ?>
                            <div class="split-banner-image uk-background-cover uk-hidden@m" style="background-image: url(<?php echo Media::getAttachmentSrcById($left_image_id, 'full'); ?>)" ></div>
                        <?php } ?>

                        <div class="split-banner-content">
                            <div class="block-content">
                                <?php if (!empty($left_logo_id)) { ?>
                                    <img src="<?php echo Media::getAttachmentSrcById($left_logo_id, 'full'); ?>" class="logo-image" />
                                <?php } ?>

                                <?php if (!empty($content)) { ?>
                                    <?php echo apply_filters('the_content', $content); ?>
                                <?php } ?>
                            </div>

                            <?php if (!empty($link_button)) {
                                echo Util::getButtonHTML($link_button, $button_args);
                            } ?>
                        </div>
                    </div>
                </div>

                <div class="split-banner right-split-content">
                    <div class="split-banner-container right-container">
                        <div class="split-banner-image uk-background-cover uk-visible@m" style="background-image: url(<?php echo Media::getAttachmentSrcById($right_image_id, 'full'); ?>)" ></div>

                        <?php if (!empty($right_mobile_image_id)) { ?>
                            <div class="split-banner-image uk-background-cover uk-hidden@m" style="background-image: url(<?php echo Media::getAttachmentSrcById($right_mobile_image_id, 'full'); ?>)" ></div>
                        <?php } else { ?>
                            <div class="split-banner-image uk-background-cover uk-hidden@m" style="background-image: url(<?php echo Media::getAttachmentSrcById($right_image_id, 'full'); ?>)" ></div>
                        <?php } ?>

                        <div class="split-banner-content">
                            <div class="block-content">
                                <?php if (!empty($right_logo_id)) { ?>
                                    <img src="<?php echo Media::getAttachmentSrcById($right_logo_id, 'full'); ?>" class="logo-image" />
                                <?php } ?>

                                <?php if (!empty($content_right_column)) { ?>
                                    <?php echo apply_filters('the_content', $content_right_column); ?>
                                <?php } ?>
                            </div>

                            <?php if (!empty($link_button_right_column)) {
                                echo Util::getButtonHTML($link_button_right_column, $button_args);
                            } ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <?php if(!empty($video_modal_html) && $type === 'video-banner'){echo $video_modal_html;} ?>
</div>
