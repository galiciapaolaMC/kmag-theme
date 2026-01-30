<?php
/**
 * ACF Module: BentoBox
 *
 * @global $data
 */

use CN\App\Fields\ACF;
use CN\App\Fields\Util;

// Facts
$fact_posts = [];
$facts_query = new WP_Query([
    'post_type' => 'agrifacts',
    'posts_per_page' => -1,
    'status' => 'publish',
]);

// grabbing all of agrifact data that we need
foreach ($facts_query->posts as $fact) {
    $meta = $fact->meta ?? ACF::getPostMeta($fact->ID);
    $fact_data = [];
    
    $crops = get_the_terms($fact->ID, 'crop');
    $crop_terms_slugs = [];
    if ($crops && count($crops) > 0) {
        $crop_terms_slugs = array_map(function ($term) {
            return $term->slug;
        }, $crops);
    }
    $fact_data['crops'] = $crop_terms_slugs;

    $products = get_the_terms($fact->ID, 'performance-product');
    $product_terms_slugs = [];
    if ($products && count($products) > 0) {
        $product_terms_slugs = array_map(function ($term) {
            return $term->slug;
        }, $products);
    }
    $fact_data['products'] = $product_terms_slugs;
    
    $yield_stats = ACF::getField('yield_stats', $meta, []);
    $yield_stats = Util::convertJsonQuotes($yield_stats);
    $fact_data['unit'] = esc_html($yield_stats[0]['unit'] ?? '-');
    $fact_data['amount'] = esc_html($yield_stats[0]['amount'] ?? '-');
    $fact_data['description'] = esc_html($yield_stats[0]['description'] ?? '');
    $fact_data['title'] = esc_html($fact->post_title);
    $fact_data['url'] = esc_html($fact->guid);

    $fact_posts[] = $fact_data;
}

$crops_query = new WP_Query([
    'post_type' => 'crops',
    'posts_per_page' => -1,
    'status' => 'publish',
]);

$crop_region_product_json = [];

// grabbing all of crop data that we need
foreach ($crops_query->posts as $crop) {
    $crop_meta = $crop->meta ?? ACF::getPostMeta($crop->ID);

    $relationship_json = ACF::getField('relationships_json', $crop_meta, '{}');
    // serialize the json string to an array
    $relationship_json = json_decode($relationship_json, true);
    $crop_region_product_json = array_merge($crop_region_product_json, $relationship_json);
}

// serialize $crop_region_product_json to a json string
$crop_region_product_json = json_encode($crop_region_product_json);


$product_json_url = get_template_directory_uri() . '/assets/data/cropRegionProduct.json';
$response = wp_remote_get($product_json_url, array('sslverify' => false));

if (is_wp_error($response)) {
    return;
} else {
    $product_json_data = wp_remote_retrieve_body($response);
}

do_action('cn/modules/styles', $row_id, $data);

?>

<section class="module bento-box" id="<?php echo esc_attr($row_id); ?>">
    <div class="uk-child-width-1-2@m bento-box__title bento-box__wrapper hidden" uk-grid>
        <div class="bento-box__title-column">
        </div>
    </div>
    <div class="uk-grid-medium uk-child-width-1-2@m bento-box__wrapper hidden" uk-grid>
        <div class="bento-box__left-column">
            <div class="bento-box__left-cell">
            </div>
        </div>
        <div class="bento-box__right-column">
            <div class="bento-box__right-cell">
            </div>
        </div>
        <div class="bento-box__mobile-column">
            <div class="bento-box__mobile-cell">
            </div>
        </div>
    </div>
    <div class="bento-box__load-more">
        <button id="bento-box-load-more" class="bento-box__more-less-button"><span id="bento-btn-text">Load More</span></button>
    </div>
    <?php
    wp_localize_script('cn-theme', "crop_region_product", array(
        'product_json_data' => $product_json_data,
        'crop_region_product_json' => $crop_region_product_json,
        'agrifacts' => $fact_posts
    ));
    ?>
</section>
