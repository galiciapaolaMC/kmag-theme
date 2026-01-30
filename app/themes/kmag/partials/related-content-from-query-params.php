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

<div class="related-content-partial">
<?php if (!empty($related_performance_products) && count($related_performance_products)) { ?>
  <div class="related-content-list">
    <div class="related-content-list__title-container">
      <h3 class="related-content-list__title"><?php _e('MENTIONED ON THIS PAGE'); ?></h3>
      <div class="related-content-list__controls">
        <button class="related-content-list__previous-button">
          <?php echo Util::getIconHTML('arrow-left')?>
        </button>
        <button class="related-content-list__next-button">
          <?php echo Util::getIconHTML('arrow-right')?>
        </button>
      </div>
    </div>
    <div class="related-performance-products">
        <?php
        foreach ($related_performance_products as $key => $pp) {
            $logo_id = $pp['logo_id'];
            $logo_attachment = ! empty($logo_id) ? Media::getAttachmentByID($logo_id) : false;
            $logo_args = array('class' => 'related-performance-product__logo');
            $logo_html = ! empty($logo_attachment) ? Util::getImageHTML($logo_attachment, 'medium', $logo_args) : '';
            $slug = $pp['slug'];
            $class_name = "related-performance-product--" . $pp['name'];
            $data_visible = true;
            // only show the first three products on page load
            if ($key >= 3) {
              $data_visible = false;
            }
        ?>
        <div
          class="related-performance-product <?php echo esc_attr($class_name)?>"
          data-pp-index="<?php echo esc_attr($key) ?>"
          <?php if ($data_visible) {
            echo 'data-pp-visible';
          } ?>
        >
            <?php echo $logo_html ?>
                <p class="related-performance-product__tagline">
            <?php echo esc_html($pp['tagline']); ?>
            </p>
                <a class="related-performance-product__link" href="<?php echo esc_url($slug); ?>">
                <?php echo __('Go to ', 'kmag') . esc_html($pp['formatted_name'])?>
            </a>
        </div>
        <?php } ?>
    </div>
  </div>
<?php } ?>
</div>