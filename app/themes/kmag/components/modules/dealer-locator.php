<?php

/**
 * ACF Module: Dealer Locator
 *
 * @global $data
 */

use CN\App\Components\ComboBox;
use CN\App\Fields\ACF;
use CN\App\Fields\Options;
use CN\App\Fields\Util;
use CN\App\Models\Dealer;

$options = Options::getSiteOptions();

/*$body_json = ACF::getField('dealer-locator-json-content', $options, null);
if ($body_json === null) {
    error_log(
        sprintf(
            'Dealer Locator JSON file not found in ACF field for module: %s',
            isset($data['id']) ? $data['id'] : 'unknown'
        )
    );
    $sf_dealers = wp_remote_get('https://mosaicco.my.salesforce-sites.com/siteforce/activeretailaccounts?callback=?/api/dealers');
    $body = $sf_dealers['body'];
    $start_pos = strpos($body, '[');
    $end_pos = strrpos($body, ']');
    $body_json = substr($body, $start_pos, $end_pos - $start_pos + 1);
}

$items = json_decode($body_json, true); */

$dealers = [];
//$items = json_decode(do_shortcode('[sfdl_dealer_list]'), true);

$body_json = ACF::getField('dealer-locator-json-content', $options, null);
$items = json_decode($body_json, true);
foreach ($items as $key => $item) {
    /* if($item["IsActive"] === true) {
        $dealers[] = new Dealer($item);
    } */

    $dealers[] = new Dealer($item);
}

$headline = ACF::getField('headline', $data);
$allowed_tags = array(
    'b' => array(),
    'i' => array(),
    'sup' => array(),
    'sub' => array(),
);

$maps_api_key = ACF::getField('google-maps-api_api-key', $options);
$map_should_load = !empty($maps_api_key);

wp_localize_script(
    'cn-theme',
    'dealer_locator',
    [
        'theme_path_url' => CN_THEME_PATH_URL,
        'maps_api_key' => esc_html($maps_api_key)
    ]
);

$param_address = filter_input(INPUT_GET, 'address', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$param_distance = filter_input(INPUT_GET, 'distance', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$param_distance = in_array($param_distance, ['25', '50', '100']) ? $param_distance : '50';
$distance_items = [
    [
        'value' => '25',
        'label' => __('25 Miles', 'kmag'),
        'selected' => $param_distance === '25',
    ],
    [
        'value' => '50',
        'label' => __('50 Miles', 'kmag'),
        'selected' => $param_distance === '50' || empty($param_distance),
    ],
    [
        'value' => '100',
        'label' => __('100 Miles', 'kmag'),
        'selected' => $param_distance === '100',
    ],
];

$param_products = filter_input(INPUT_GET, 'product', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$param_products = explode(',', $param_products);
$args = [
    'hide_empty' => false
];
$products = ComboBox::getTaxItemsForCombobox('performance-product', $args);

if (array_key_exists('pegasus', $products)) {
    unset($products['pegasus']);
}

foreach ($products as $key => $product) {
    $products[$key]['selected'] = in_array($product['value'], $param_products);
}

$accent_color = ACF::getField('color-theme_accent-color', $data, 'green');
$accent_color_class = 'dealer-locator--' . $accent_color;
$button_color_class = $accent_color === 'orange' ? 'btn--microessentials' : 'btn--tertiary';
// TODO get this json from SF instead of static file > reference past cn nuxt app $api call
// $dealer_json_file = file_get_contents(get_template_directory() . '/assets/data/dealers.json');
// $dealers = json_decode($dealer_json_file, true) ?? [];

do_action('cn/modules/styles', $row_id, $data);
?>

<div class="module dealer-locator <?php echo esc_attr($accent_color_class); ?>" id="<?php echo esc_attr($row_id); ?>" data-theme="<?php echo esc_attr($accent_color); ?>">
    <div class="uk-container uk-container-large">
        <?php
        if (!empty($headline)) {
            echo sprintf(
                '<h1 class="dealer-locator__title hdg hdg--2">%1$s</h1>',
                wp_kses($headline, $allowed_tags)
            );
        }
        ?>
        <div class="filter">
            <div class="filter__button-group">
                <form class="wtb-form">
                    <div class="wtb-fields-container">
                        <div class="wtb-form-row">
                            <div class="wtb-location-field-container">
                                <div class="cn-input">
                                    <label><?php _e('Location', 'kmag'); ?></label>
                                    <?php
                                    printf(
                                        '<input
                                            class="uk-input"
                                            type="text"
                                            name="location"
                                            placeholder="%1$s" aria-label="%1$s"  
                                            aria-label="%1$s"
                                            value="%2$s"
                                        >',
                                        __('Enter Zip or Postal Code', 'kmag'),
                                        $param_address
                                    );
                                    ?>
                                </div>
                                <button type="button" class="btn btn--link uk-margin-top" data-button="locate" disabled>
                                    <?php
                                    echo Util::getIconHTML('find-location');
                                    _e('Use current location', 'kmag');
                                    ?>
                                </button>
                            </div>
                            <div class="wtb-distance-field-container">
                                <?php
                                // Single Distance Dropdown
                                $distance_button_list_html = ComboBox::buildSingleSelectListHtml($distance_items);
                                echo ComboBox::getComboboxHtml(
                                    [
                                        'id' => 'distance',
                                        'label-html' => __('Distance', 'kmag'),
                                        'list-html' => $distance_button_list_html,
                                    ]
                                );
                                ?>
                            </div>
                        </div>
                        <div class="wtb-form-row">
                            <div class="wtb-product-container">
                                <?php
                                // Multi Product Dropdown
                                $product_button_list_html = ComboBox::buildMultiSelectProductsListHtml($products);
                                echo ComboBox::getComboboxHtml(
                                    [
                                        'id' => 'products',
                                        'label-html' => __('Filter by Product (optional)', 'kmag'),
                                        'list-html' => $product_button_list_html,
                                        'is-multi' => true,
                                    ]
                                );
                                ?>
                                <button class="btn btn--inline-link btn--close uk-margin-top uk-margin-auto-left" data-button="clear">
                                    <?php
                                    echo Util::getIconHTML('close-x');
                                    _e('Clear Filter', 'kmag');
                                    ?>
                                </button>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn--tertiary uk-margin-top" data-button="submit" disabled>
                        <?php _e('Search', 'kmag'); ?>
                    </button>
                </form>
            </div>
        </div>

        <div class="uk-grid dealer-locator__row dealer-locator__map-container">
            <div class="uk-width-1-1 uk-margin-bottom dealer-locator__results-count">
            </div>
            <div class="uk-width-1-1 uk-width-1-3@m">
                <!-- When filtered dealers list is empty, show this -->
                <div class="dealer-locator__dealers dealer-locator__dealers--no-results filter__no-results">
                    <div class="dealer">
                        <div class="dealer__content">
                            <h3>
                                <?php _e('No Results', 'kmag'); ?>
                            </h3>
                            <p><?php _e('Adjust your search criteria to receive results.', 'kmag'); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Filtered dealers are placed here -->
                <div class="dealer-locator__dealers dealer-locator__dealers--visible"></div>

                <!-- Full list of dealers -->
                <div class="dealer-locator__dealers dealer-locator__dealers--hidden uk-hidden">
                    <?php
                    foreach ($dealers as $index => $dealer) {
                        $dealer_product_items_html = '';
                        foreach ($dealer->products as $key => $product) {
                            $product_exists = array_key_exists($product, PERFORMANCE_PRODUCT_LABEL_MAP);
                            $product_label = $product_exists ? PERFORMANCE_PRODUCT_LABEL_MAP[$product] . PERFORMANCE_PRODUCT_COPYRIGHT_MAP[$product] : $product;

                            $dealer_product_items_html .= sprintf(
                                '<li class="dealer__product-item">%1$s</li>',
                                $product_label
                            );
                        }

                        $dealer_products_html = sprintf(
                            '<div class="dealer__products">
                                <p class="dealer__products-title">%1$s</p>
                                <ul>%2$s</ul>
                            </div>',
                            __('Product Offerings', 'kmag'),
                            $dealer_product_items_html
                        );

                        $dealer_directions_url = sprintf(
                            'http://maps.google.com/?q=%s,%s,%s',
                            esc_html($dealer->name),
                            esc_html($dealer->address),
                            esc_html($dealer->zip)
                        );

                        $dealer_content_html = sprintf(
                            '<div class="dealer__content">
                                <div class="dealer__contact uk-margin-bottom">
                                    <div class="dealer__title">
                                        <p class="dealer__name">%1$s</p>
                                        <p class="dealer__distance"></p>
                                    </div>
                                    <div class="dealer__address uk-margin-bottom">
                                        <p>%2$s</p>
                                        <p>%3$s</p>
                                        <p class="dealer__directions">
                                            <a href="%5$s" target="_blank">%4$s</a>
                                        </p>
                                    </div>
                                    <p class="dealer__phone">%6$s</p>
                                </div>
                                %7$s
                            </div>',
                            esc_html($dealer->name),
                            esc_html($dealer->address),
                            esc_html($dealer->city) . ', ' . esc_html($dealer->state) . ' ' . esc_html($dealer->zip),
                            __('Get Directions', 'kmag'),
                            $dealer_directions_url,
                            esc_html($dealer->phone),
                            $dealer_products_html
                        );

                        $dealer_body_html = sprintf(
                            '<div class="dealer__index">%1$s</div>
                            %2$s',
                            $index,
                            $dealer_content_html,
                        );

                        printf(
                            '<div
                                class="dealer-locator__dealer dealer"
                                data-dealer-products="%2$s"
                                data-dealer-latitude="%3$s"
                                data-dealer-longitude="%4$s"
                                data-dealer-address="%5$s"
                                data-dealer-city="%6$s"
                                data-dealer-state="%7$s"
                                data-dealer-zip="%8$s"
                                data-dealer-phone="%9$s"
                                data-dealer-id="%10$s"
                                data-dealer-name="%11$s"
                                data-dealer-index="%12$s"
                            >
                                %1$s
                            </div>',
                            $dealer_body_html,
                            implode(',', $dealer->products),
                            esc_html($dealer->location['latitude']),
                            esc_html($dealer->location['longitude']),
                            esc_html($dealer->address),
                            esc_html($dealer->city),
                            esc_html($dealer->state),
                            esc_html($dealer->zip),
                            esc_html($dealer->phone),
                            esc_html($dealer->id),
                            esc_html($dealer->name),
                            $index
                        );
                    }
                    ?>
                </div>
            </div>
            <div class="uk-width-1-1 uk-width-2-3@m dealer-locator__map" data-google-map>
                <?php
                if (!$map_should_load) {
                    printf(
                        '<div class="uk-light uk-padding-small uk-panel" style="background-color: var(--color-seed);">
                            <p class="uk-text-small">%s</p>
                        </div>',
                        __('Could not load Dealer Locator map', 'kmag')
                    );
                }
                ?>
            </div>
        </div>
    </div>
</div>