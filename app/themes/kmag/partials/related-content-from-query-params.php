<?php
/**
 * Related Content partial template
 */
use CN\App\Fields\ACF;
use CN\App\Fields\Util;
use CN\App\Media;

// get product from url parameters
$products = isset($_GET['product']) ? explode(',', strtolower($_GET['product'])) : [];
$safe_products = array_map('sanitize_text_field', $products);
$data = ACF::getPostMeta($post_id);
$fetched_performance_products = null;
$related_performance_products = array();
if (empty($products)) {
    return;
}


$fetched_performance_products = new \WP_Query([
    'post_type' => 'performance-products',
    'posts_per_page' => -1,
    'order' => 'ASC',
]);



if ($fetched_performance_products->have_posts()) {
    foreach ($fetched_performance_products->posts as $fetched_performance_product) {
        if (in_array($fetched_performance_product->post_name, $safe_products)) {
            $pp_data = ACF::getPostMeta($fetched_performance_product->ID);
            $slug = ACF::getField('performance_product_slug', $pp_data);
            $tagline = ACF::getField('tagline', $pp_data);
            $logo_id = ACF::getField('card-logo', $pp_data);
            $formatted_name = ACF::getField('name', $pp_data);

            $related_performance_product = array(
                'name' => $fetched_performance_product->post_name,
                'slug' => $slug,
                'tagline' => $tagline,
                'logo_id' => $logo_id,
                'formatted_name' => $formatted_name
            );
            array_push($related_performance_products, $related_performance_product);
        }
    }
}

?>
