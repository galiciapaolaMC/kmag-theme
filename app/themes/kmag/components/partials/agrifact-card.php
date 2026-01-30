<?php

/**
 * Partial: Agrifact Card
 *
 * @var WP_Post $fact
 * @var array $fact->meta (optional post meta from ACF::getPostMeta())
 * @var array $fact->crops (optional crop terms from get_the_terms())
 * @var array $fact->products (optional product terms from get_the_terms())
 */

use CN\App\Fields\ACF;
use CN\App\Fields\Util;

$meta = $fact->meta ?? ACF::getPostMeta($fact->ID);

$crop_terms = $fact->crops ?? get_the_terms($fact->ID, 'crop');
$crop_terms_slugs = [];
$crop_icon_html = '';
if ($crop_terms && count($crop_terms) > 0) {
    $crop_terms_slugs = array_map(function ($term) {
        return $term->slug;
    }, $crop_terms);
    $crop_icon_html = Util::getIconHTML($crop_terms[0]->slug);
}

$product_terms = $fact->products ?? get_the_terms($fact->ID, 'performance-product');
$product_terms_slugs = [];
$product_icon_html = '';
if ($product_terms && count($product_terms) > 0) {
    $product_terms_slugs = array_map(function ($term) {
        return $term->slug;
    }, $product_terms);
    $product_icon_html = Util::getIconHTML($product_terms[0]->slug);
}
$trial_years = ACF::getField('trial_years', $meta);
$trial_years_list = explode('-', $trial_years);
if (count($trial_years_list) === 2) {
    $trial_years = $trial_years_list[1] - $trial_years_list[0];
    $trial_years = sprintf(
        _n('%d Year of data', '%d Years of data', $trial_years, 'kmag'),
        $trial_years
    );
}

$yield_stats = ACF::getField('yield_stats', $meta, []);
$yield_stats = Util::convertJsonQuotes($yield_stats);
$unit = $yield_stats[0]['unit'] ?? '-';
$amount = $yield_stats[0]['amount'] ?? '-';
$description = $yield_stats[0]['description'] ?? '';

$top_row_html = sprintf(
    '<div class="uk-flex uk-flex-between" style="gap: 16px;">
        <div style="flex: 1;">
            <h5>%1$s</h5>
            <div class="content">%2$s</div>
        </div>
        <div class="icon-wrap">%3$s</div>
    </div>',
    esc_html($fact->post_title),
    esc_html($description),
    $crop_icon_html
);

$metric_row_html = sprintf(
    '<div class="metric">
        <div class="metric__icon">%1$s</div>
        <div class="metric__value">%2$s</div>
        <div class="metric__unit">%3$s</div>
    </div>',
    Util::getIconHTML('arrow-up'),
    esc_html($amount),
    esc_html($unit)
);

$bottom_row_html = sprintf(
    '<div class="uk-flex uk-flex-between">
        <div class="product-icon">%1$s</div>
        <div class="years">%2$s</div>
    </div>',
    $product_icon_html,
    esc_html($trial_years)
);

$card_html = sprintf(
    '<a class="card card--agrifact" href="%1$s">
        %2$s
        <div class="uk-margin-auto-top">
            %3$s
            %4$s
        </div>
    </a>',
    get_permalink($fact->ID),
    $top_row_html,
    $metric_row_html,
    $bottom_row_html
);

printf(
    '<div
        class="agrifact-card-container"
        data-crops="%1$s"
        data-products="%2$s"
        data-title="%3$s"
    >
        %4$s
    </div>',
    implode(',', $crop_terms_slugs),
    implode(',', $product_terms_slugs),
    esc_html($fact->post_title),
    $card_html
);
