<?php

/**
 * ACF Module: Content Block
 *
 * @global $data
 */

use CN\App\Fields\ACF;
use CN\App\Fields\Util;

$content_type = ACF::getField('content-type', $data, 'headline');
$headline_type = ACF::getField('headline-type', $data, 'h3');
$headline = ACF::getField('headline', $data);
$content  = ACF::getField('content', $data);
$link  = ACF::getField('link', $data);
$headline_link  = ACF::getField('headline-link', $data);

$dynamic_display = ACF::getField('dynamic-display', $data);

$button_color = ACF::getField('button-color', $data, 'primary');
$button_base_class = 'btn';
$button_color_class = $button_color === 'btn--primary' ? '' : 'btn--' . $button_color;
$button_classes = implode(' ', [$button_base_class, $button_color_class]);

$button_args = ['class' => $button_classes];

$left_button_icon = ACF::getField('button-icons_left_icon', $data);
if (!empty($left_button_icon) && $left_button_icon !== 'none') {
    $button_args['icon-start'] = $left_button_icon;
}
$right_button_icon = ACF::getField('button-icons_right_icon', $data);
if (!empty($right_button_icon) && $right_button_icon !== 'none') {
    $button_args['icon-end'] = $right_button_icon;
}

$dynamic_display_class = '';
if ($dynamic_display !== 'none') {
    $dynamic_display_class = " $dynamic_display";
}

if (empty($headline)) {
    return;
}

if ($content_type === 'headline') {
    $headline_type = 'h3';
}

$allowed_tags = array(
    'b' => array(),
    'i' => array(),
    'sup' => array(),
    'sub' => array(),
);

do_action('cn/modules/styles', $row_id, $data);
?>

<div class="module content-block<?php echo esc_attr($dynamic_display_class); ?>" id="<?php echo esc_attr($row_id); ?>">
    <div class="uk-container">
        <div class="content-block__heading">
            <?php
            echo sprintf(
                '<%1$s class="content-block__title">%2$s</%1$s>',
                $headline_type,
                wp_kses($headline, $allowed_tags)
            );
            ?>

            <?php if ($content_type === 'headline') {
                if (!empty($headline_link)) { ?>
            <div class="content-block__button-container">
                <?php echo Util::getButtonHTML($headline_link, $button_args); ?>
            </div>
            <?php }
            } ?>
        </div>

        <?php if ($content_type === 'headline-content') { ?>
        <div class="content-block__content-container">
            <?php if (!empty($content)) { ?>
            <div class="content-block__content">
                <?php echo apply_filters('the_content', $content); ?>
            </div>
            <?php } ?>

            <?php if (!empty($link)) { ?>
            <div class="content-block__button-container">
                <?php echo Util::getButtonHTML($link, $button_args); ?>
            </div>
            <?php } ?>
        </div>
        <?php } ?>
    </div>
</div>