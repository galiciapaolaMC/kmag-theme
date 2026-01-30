<?php
/**
 * ACF Module: Product Cards
 *
 * @global $data
 */

use CN\App\Fields\ACF;
use CN\App\Fields\ModuleUtils\PerformanceProductCardsUtils;
use CN\App\Fields\Util;

$context_options = array(
    "ssl" => array(
        "verify_peer" => false,
        "verify_peer_name" => false
    )
);  

$product_json_data = file_get_contents(get_template_directory_uri() . '/assets/data/cropRegionProduct.json', false, stream_context_create($context_options));

$products = ACF::getField('products', $data, []);

$product_data = array_map(function ($product_id) {
    $product = get_post($product_id);
    $meta = ACF::getPostMeta($product->ID);
    $image_url = '';
    $image_id = ACF::getField('product_image', $meta, '');
    if (!empty($image_id)) {
        $image_url = wp_get_attachment_image_src($image_id, 'full')[0];
    }
    $logo_id = ACF::getField('card-logo', $meta, '');
    $logo_image_url = '';
    if (!empty($logo_id)) {
        $logo_image_url = wp_get_attachment_image_src($logo_id, 'full')[0];
    }
    $product_data = [];
    $product_data['slug'] = $product->post_name;
    $product_data['tagline'] = ACF::getField('tagline', $meta, '');
    $product_data['description'] = ACF::getField('description', $meta, '');
    $product_data['name'] = ACF::getField('name', $meta, '');
    $product_data['product-category'] = ACF::getField('product-fertilizer-category', $meta, '');
    $product_data['icon-section'] = ACF::getField('icon-section-variant', $meta, '');
    $product_data['product-type'] = ACF::getField('product-type', $meta, '');
    // get posts from nutrients array of post ids
    $product_data['text-color'] = ACF::getField('text-color', $meta, '');
    $product_data['bg-color'] = ACF::getField('color', $meta, '#78BB43');

    $product_data['nutrients'] = array_map(function ($nutrient_id) {
        $nutrient_post = get_post($nutrient_id);
        $nutrient_post_meta = ACF::getPostMeta($nutrient_id);
        $name = $nutrient_post->post_name;
        $symbol = ACF::getField('symbol', $nutrient_post_meta, '');
        return array('name' => $name, 'symbol' => $symbol);
    }, ACF::getField('nutrients', $meta, []));
    $product_data['product-image'] = $image_url;
    $product_data['product-logo'] = $logo_image_url;
    $product_data['url'] = ACF::getField('performance_product_slug', $meta, '');
    return $product_data;
}, $products);
$product_json_post_data = json_encode($product_data);

$crops_query = new WP_Query([
    'post_type' => 'crops',
    'posts_per_page' => -1,
    'status' => 'publish',
]);

$crop_region_product_json = [];

// grabbing all of crop data that we need

foreach ($crops_query->posts as $crop) {
    $crop_meta = ACF::getPostMeta($crop->ID);

    $relationship_json = ACF::getField('relationships_json', $crop_meta, '{}');
    // serialize the json string to an array
    $relationship_json = json_decode($relationship_json, true);
    if (!empty($relationship_json)) {
        $crop_region_product_json = array_merge($crop_region_product_json, $relationship_json);
    }
}


$page = ACF::getField('product_page', $data);
$secondary = ACF::getField('secondary', $data, '0');
$variant = ACF::getField('card-variant', $data, 'tagline-and-description');

do_action('cn/modules/styles', $row_id, $data);

?>

<section id="<?php echo esc_attr($row_id); ?>" class="module product-cards" data-page="<?php echo esc_attr($page); ?>" data-secondary="<?php echo esc_attr($secondary); ?>">
    <div class="uk-grid uk-grid-medium uk-child-width-1-2@m product-cards__grid-wrapper" uk-grid>
        <?php
            foreach ($product_data as $key => $product) {
                echo PerformanceProductCardsUtils::renderPerformanceProductCard($product, $variant);
            }
        ?>
    </div>
    <?php
    wp_localize_script('cn-theme', "product_card_data", array(
        'card_json_data' => $product_json_data,
        'card_json_posts' => $product_json_post_data,
        'crop_region_product_json' => json_encode($crop_region_product_json),
        // Since ACF refuses to return an array for buttongroups
        'card_translations' => array(
            'performance-fertilizer' => __('Performance Fertilizer', 'kmag'),
            'biological-fertilizer-compliment' => __('Biological Fertilizer Compliment', 'kmag'),
            'suplemental-fertilizer' => __('Suplemental Fertilizer', 'kmag'),
            'nutrient-list' => __('Nutrient List', 'kmag'), 
            'product-type' => __('Product Type', 'kmag'),
            'nutrient-enhancer' => __('Nutrient Enhancer', 'kmag'),
            'beneficial-input' => __('Beneficial Input', 'kmag'),
        )
    ));
    ?>
</section>

