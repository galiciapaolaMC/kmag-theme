<?php
/**
 * ACF Module: Nutrient Slider
 *
 * @global $data
 *
 *
 */

use CN\App\Fields\ACF;
use CN\App\Fields\Util;

$nutrients = ACF::getField('nutrients', $data);

global $post;

$pagename = $post->post_name;
$text_content = [];
$html_desktop = '';
$html_mobile = '';
$ind = '0';

foreach ($nutrients as $index => $item) {
    $selected = '';

    $fields = ACF::getPostMeta($item);
    
    if ($fields['slug'] === $pagename) {
        $text_content['description'] = $fields['description'];
        $text_content['intro_heading'] = $fields['intro_heading'];
        $text_content['intro_content'] = $fields['intro_content'];
        $selected = ' selected';
        $ind = $index;
    }

    $html_desktop .= '<li>
        <a href="/kmag/key-nutrients/' . esc_html($fields['slug']) . '" class="nutrient-slider__nutrient-box'
            . $selected .'">
            <p class="nutrient-symbol">' . esc_html($fields['symbol']) . '</p>
            <p class="nutrient-name">' . esc_html(ucfirst($fields['slug'])) . '</p>
        </a>
    </li>';

    $html_mobile .= '<option data-url="/kmag/key-nutrients/' . esc_html($fields['slug']) . '" value="' . esc_html($fields['slug']) . '" '. $selected .'>
            ' . esc_html(ucfirst($fields['slug'])) . '
        </option>';
}

wp_reset_postdata();

do_action('cn/modules/styles', $row_id, $data);
?>

<section class="module nutrient-slider" id="<?php echo esc_attr($row_id); ?>">
    <div class="nutrient-slider__slider-wrapper nutrient-slider__desktop">
        <div class="uk-nutrient-slider" uk-slider="index: <?php echo $ind; ?>">
            <div class="uk-slider-container">
                <ul class="uk-slider-items">
                    <?php echo $html_desktop; ?>
                </ul>
            </div>

            <div class="nutrient-slider__button-wrapper">
                <button class="uk-hidden-hover" uk-slidenav-previous uk-slider-item="previous"><?php echo Util::getIconHTML('slider-prev'); ?></button>
                <button class="uk-hidden-hover" uk-slidenav-next uk-slider-item="next"><?php echo Util::getIconHTML('slider-next'); ?></button>
            </div>
        </div>
    </div>

    <div class="nutrient-slider__slider-wrapper nutrient-slider__mobile">
        <div class="uk-container uk-container-large">
            <div class="uk-grid uk-grid-small">
                <div class="uk-width-1-3 label-container">
                    <p class="nutrient-slider__mobile-label"><?php _e('NUTRIENT:', 'kmag'); ?></p>
                </div>

                <div class="uk-width-2-3">
                    <div class="nutrient-select-container">
                        <select name="nutrient_select" class="nutriend-select">
                            <?php echo $html_mobile; ?>
                        </select>

                        <svg class="icon icon-select-dropdown" aria-hidden="true">
                            <use xlink:href="#icon-select-dropdown"></use>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="nutrient-slider__text-wrapper">
        <div class="nutrient-slider__description">
            <h1><?php echo esc_html(strtoupper($pagename)); ?></h1>
            <p><?php echo esc_html($text_content['description']); ?></p>
        </div>
        <div class="nutrient-slider__intro">
            <div class="nutrient-slider__intro-inner">
                <h2><?php echo esc_html($text_content['intro_heading']); ?></h2>
                <p><?php echo esc_html($text_content['intro_content']); ?></p>
            </div>
        </div>
    </div>
</section>

