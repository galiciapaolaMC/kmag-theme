<?php
/**
 * ACF Module: Background Gradient
 *
 * @global $data
 */

use CN\App\Fields\ACF;
use CN\App\Fields\Util;

$page_type = ACF::getField('page-type', $data, 'core-page');
$gradient_position = ACF::getField('gradient-position', $data, 'top');
$performance_product = ACF::getField('perfomance-products-option', $data);

if (!empty($performance_product)) {
    $meta = ACF::getPostMeta($performance_product[0]);
    $product_color = ACF::getField('color', $meta, 'transparent');
}

if (!$page_type) {
    return;
}

?>

<?php if (!empty($performance_product)) { ?>
    <div class="background-gradient gradient-<?php echo esc_attr($page_type); ?> position-<?php echo esc_attr($gradient_position); ?>" style="background: linear-gradient(0deg, rgba(255,255,255,1) 0%, <?php echo esc_attr($product_color); ?> 200%);">
    </div>
<?php } else { ?>
    <div class="background-gradient gradient-<?php echo esc_attr($page_type); ?> position-<?php echo esc_attr($gradient_position); ?>">
    </div>
<?php } ?>

