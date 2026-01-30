<?php

/**
 * ACF Module: Field Study Page
 *
 * @global $data
 */

namespace CN\App\Fields;

use CN\App\Fields\ACF;
use CN\App\Components\ComboBox;
use CN\App\Fields\Options;

$headline = ACF::getField('headline', $data);
$mobile_headline = ACF::getField('mobile-headline',$data);
$allowed_tags = array(
    'b' => array(),
    'i' => array(),
    'sup' => array(),
    'sub' => array(),
);
$extension = pathinfo($_SERVER['SERVER_NAME'], PATHINFO_EXTENSION);
$img_folder = $extension === 'local' ? 'app' : 'wp-content';
do_action('cn/modules/styles', $row_id, $data);
$options = Options::getSiteOptions();
$maps_api_key = ACF::getField('mapbox-api_api-key', $options);
$google_storage_url = ACF::getField('google-storage_map-json', $data);
$field_study_url = ACF::getField('map-popup_field-study-url', $data);
$now = date("YmdHis");
wp_localize_script(
    'cn-theme',
    'performance_map',
    [
        'theme_path_url' => CN_THEME_PATH_URL,
        'maps_api_key' => esc_html($maps_api_key),
        'google_storage_url' => esc_html($google_storage_url),
        'field_study_url' => esc_url($field_study_url['url'])
    ]
);
$param_crops = filter_input(INPUT_GET, 'crop', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$crop = [
    [
        'value' => 'Corn',
        'label' => __('Corn', 'kmag'),
        'selected' => true,
    ],
    [
        'value' => 'Spring Wheat',
        'label' => __('Spring Wheat', 'kmag'),
        'selected' => $param_crops === 'springwheat',
    ],
    [
        'value' => 'Winter Wheat',
        'label' => __('Winter Wheat', 'kmag'),
        'selected' => $param_crops === 'winterwheat',
    ],
    [
        'value' => 'Canola',
        'label' => __('Canola', 'kmag'),
        'selected' => $param_crops === 'canola',
    ]
];
$param_product = filter_input(INPUT_GET, 'product', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$product = [
    [
        'value' => 'biopath',
        'label' => __('BioPath®', 'kmag'),
        'selected' => true,
    ],
    [
        'value' => 'powercoat',
        'label' => __('PowerCoat®', 'kmag'),
        'selected' => $param_product === 'powercoat',
    ],
];
$param_method = filter_input(INPUT_GET, 'method', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$method = [
    [
        'value' => 'pre-plant',
        'label' => __('Pre-Plant', 'kmag'),
        'selected' => $param_method === 'pre-plant',
    ],
    [
        'value' => 'in-furrow',
        'label' => __('In-furrow', 'kmag'),
        'selected' => $param_method === 'in-furrow',
    ],
    [
        'value' => 'sidedress',
        'label' => __('Sidedress', 'kmag'),
        'selected' => $param_method === 'sidedress',
    ],
    [
        'value' => 'topdress',
        'label' => __('Topdress', 'kmag'),
        'selected' => $param_method === 'topdress',
    ],
];
$param_irrigation = filter_input(INPUT_GET, '$irrigation', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$irrigation = [
    [
        'value' => 'yes',
        'label' => __('Yes', 'kmag'),
        'selected' => $param_irrigation === 'yes',
    ],
    [
        'value' => 'no',
        'label' => __('No', 'kmag'),
        'selected' => $param_irrigation === 'no',
    ],
];
$param_tillage = filter_input(INPUT_GET, '$param_tillage', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$tillage = [
    [
        'value' => 'conventional',
        'label' => __('Conventional', 'kmag'),
        'selected' => $param_tillage === 'conventional',
    ],
    [
        'value' => 'reduced',
        'label' => __('Reduced', 'kmag'),
        'selected' => $param_tillage === 'reduced',
    ],
];
?>
<link href="<?php echo "https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.css?now={$now}" ?>" rel='stylesheet' />

<div class="performance-map overlay" id="<?php echo esc_attr($row_id); ?>">
    <img src="<?php bloginfo('template_url'); ?>/assets/images/truresponse-logo-white.svg" class="truresponse-logo">
    <?php
    if (!empty($headline)) {
        echo sprintf(
            '<p class="performance-map__headline";">%1$s</p>',
            wp_kses($headline, $allowed_tags)
        );
    }
    if (!empty($mobile_headline)) {
        echo sprintf(
            '<p class="performance-map__headline mobile-headline";">%1$s</p>',
            wp_kses($mobile_headline, $allowed_tags)
        );
    }
    ?>
    <button aria-expanded="true" aria-controls="filter-container" id="filter-expand-button" class="filter-button"><?php _e("Choose Filter Data Type", "kmag") ?></button>
    <div class="filter-container-wrapper">
        <div class="filter-container" id="filter-container" aria-expanded="true">
            <div class="performance-map__dropdown dropdown-crop">
                <?php
                // Single Distance Dropdown
                $crop_button_list_html = ComboBox::buildSingleSelectListHtml($crop);
                echo ComboBox::getComboboxHtml(
                    [
                        'id' => 'crop',
                        'label-html' => __('Crop*', 'kmag'),
                        'list-html' => $crop_button_list_html,
                    ]
                );
                ?>
            </div>
            <div class="performance-map__dropdown">
                <?php
                // Multi Product Dropdown
                $product_button_list_html = ComboBox::buildSingleSelectListHtml($product);
                echo ComboBox::getComboboxHtml(
                    [
                        'id' => 'product',
                        'label-html' => __('Product*', 'kmag'),
                        'list-html' => $product_button_list_html,
                    ]
                );
                ?>
            </div>
        
            <div class="performance-map__dropdown">
                <?php
                // Single Distance Dropdown
                $method_button_list_html = ComboBox::buildSingleSelectListHtml($method);
                echo ComboBox::getComboboxHtml(
                    [
                        'id' => 'method',
                        'label-html' => __('Methods', 'kmag'),
                        'list-html' => $method_button_list_html,
                    ]
                );
                ?>
            </div>
            <div class="performance-map__dropdown">
                <?php
                // Single Distance Dropdown
                $irrigation_button_list_html = ComboBox::buildSingleSelectListHtml($irrigation);
                echo ComboBox::getComboboxHtml(
                    [
                        'id' => 'irrigation',
                        'label-html' => __('Irrigation', 'kmag'),
                        'list-html' => $irrigation_button_list_html,
                    ]
                );
                ?>
            </div>
            <div class="performance-map__dropdown">
                <?php
                // Single Distance Dropdown
                $tillage_button_list_html = ComboBox::buildSingleSelectListHtml($tillage);
                echo ComboBox::getComboboxHtml(
                    [
                        'id' => 'tillage',
                        'label-html' => __('Tillage', 'kmag'),
                        'list-html' => $tillage_button_list_html,
                    ]
                );
                ?>
            </div> 
            <div class="zip-code">
                <label for="zip">
                    <?php _e('ZIP', 'kmag') ?>
                </label>
                <div class="zip-input">
                    <input type="input" name="zip" id="zip" />
                </div>
            </div>
            <div class="zip-input">
                <button id="searchButton" class="btn btn--biopath" type="submit"> <?php _e('Search', 'kmag'); ?> </button>
            </div>
            <div class="clear-filter"><a href="#" id="clearFiltersButton"><?php _e("X Clear Filters", "kmag") ?></a></div>
        </div>
    </div>
    <div class="map-wrapper">
        <div class="averages-wrapper">
            <div class="averages-header one-column">
                <?php _e('Proven biological performance.', 'kmag'); ?>
            </div>
                <p class="two-column current-count"><?php _e('Currently Viewing', 'kmag'); ?><span id="countTreatmentYLD"></span></p>
                <p class="two-column total-count"><span id="totalTreatmentYLD"></span><?php _e('Total Field Studies', 'kmag'); ?></p>
                <hr class="one-column average-break">
                <p class="one-column average-yield"><?php _e('Average Yield Increase', 'kmag'); ?><span id="avgYLDDiff"></span></p>
                <div class="averages-detail one-column">
                    <?php _e('Average performance based on all trials within current map view.', 'kmag'); ?>
                </div>
                <hr class="one-column average-break">
                <div class="one-column"><p class="averages-disclaimer"><?php _e('*To ensure anonymity of trial participants, the above map has been slightly altered to remove exact location identifiers.', 'kmag'); ?></p></div>
        </div>
        <div id="performance-mapbox"></div>
    </div>
</div>