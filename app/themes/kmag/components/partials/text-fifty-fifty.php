<?php
/**
 * ACF Module Partial: TextFiftyFifty
 *
 * @var array $data
 *
 * @var string $cell_number
 */

use CN\App\Fields\ACF;
use CN\App\Fields\Util;

$headline = ACF::getField('headline', $data);
$paragraph = ACF::getField('paragraph', $data);
$link = ACF::getField('link', $data);
$heading_tag = ACF::getField('heading_tag', $data);
$theme_color = 'theme-' . ACF::getField('theme_color', $data);
$style_classes = "{$theme_color} {$cell_number}-child";

?>

<div class="partial column-content__text-fifty-fifty <?php echo esc_attr($style_classes); ?>">
    <div class="text-fifty-fifty__positioner">
        <div class="text-fifty-fifty__inside-wrap">
            <?php
            if (!empty($headline)) {
                printf(
                    '<%1$s>%2$s</%1$s>',
                    esc_html($heading_tag),
                    nl2br(strip_tags($headline, ALLOWED_FORMAT_TAGS))
                );
            }
            if (!empty($paragraph)) {
                printf(
                    '<p class="text-fifty-fifty__text-content">%1$s</p>',
                    nl2br(strip_tags($paragraph, ALLOWED_FORMAT_TAGS))
                );
            } ?>

            <?php if (!empty($link)) {
              
                $button_color_field_value = ACF::getField('button-options_button_color', $data);
                $button_color_class = $button_color_field_value === 'default' ? 'btn' : 'btn btn--' . $button_color_field_value;
                $button_classes = implode(' ', [$button_color_class, 'text-fifty-fifty__button']);

                echo '<div class="text-fifty-fifty__link-wrap">';
                echo Util::getButtonHTML($link, [
                    'class' => $button_classes
                ]);
                echo '</div>';
            } ?>
        </div>
    </div>
</div>