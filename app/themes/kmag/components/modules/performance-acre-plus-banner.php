<?php

/**
 * ACF Module: Performance Acre+ Banner
 *
 * @var $data
 */

use CN\App\Media;
use CN\App\Fields\ACF;
use CN\App\Fields\Options;
use CN\App\Fields\Util;

$field_group = 'settings-performance-acre-plus-banner';
$options = Options::getSiteOptions();
$headline = ACF::getField("{$field_group}_headline", $options);
$content = ACF::getField("{$field_group}_content", $options);
$cta_link = ACF::getField("{$field_group}_cta-link", $options);

$background_image_desktop_id = ACF::getField("{$field_group}_background-image-desktop-id", $options);
$background_image_desktop_url = '';
if (!empty($background_image_desktop_id)) {
    $background_image_desktop_url = Media::getAttachmentSrcByID($background_image_desktop_id);
}

$background_image_mobile_id = ACF::getField("{$field_group}_background-image-mobile-id", $options);
$background_image_mobile_url = '';
if (!empty($background_image_mobile_id)) {
    $background_image_mobile_url = Media::getAttachmentSrcByID($background_image_mobile_id);
}

if (empty($content)) {
    return;
}

do_action('cn/modules/styles', $row_id, $data);
?>

<section class="module performance-acre-plus-banner" id="<?php echo esc_attr($row_id); ?>">
    <div class="uk-flex uk-width-full uk-background-primary">
        <?php
        printf(
            '<div
                class="module__background module__background--desktop uk-visible@s"
                style="background-image: url(%1$s)"
                data-default-image="%1$s"
            >
            </div>',
            esc_url($background_image_desktop_url)
        );

        printf(
            '<div
                class="module__background module__background--mobile uk-hidden@s"
                style="background-image: url(%1$s)"
                data-default-image="%1$s"
            >
            </div>',
            esc_url($background_image_mobile_url)
        );
        ?>

        <div class="uk-background-default module__content entry__content">
            <?php
            if (!empty($headline)) {
                printf(
                    '<h2 class="hdg hdg--2">%s</h2>',
                    $headline
                );
            }

            if (!empty($content)) {
                echo apply_filters('the_content', $content);
            }

            if (!empty($cta_link)) {
                $button_color_field_value = ACF::getField('button-options_button_color', $data);
                $button_color_class = $button_color_field_value === 'default' ? 'btn' : 'btn btn--' . $button_color_field_value;
                $button_classes = implode(' ', [$button_color_class, 'btn--sm']);
                echo Util::getButtonHTML($cta_link, ['class' => $button_classes]);
            }
            ?>
        </div>
    </div>
</section>