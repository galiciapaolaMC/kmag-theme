<?php

/**
 * ACF Module: Product Panel
 *
 * @global $data
 */

use CN\App\Fields\ACF;
use CN\App\Fields\Util;
use CN\App\Media;

$product_image = ACF::getField('product_image', $data);
$subtitle = ACF::getField('tagline', $data);
$source = ACF::getField('panel-source', $data);
$product_logo = ACF::getField('logo', $data);
$background_color = ACF::getField('background-color', $data, 'biopath');
$background_color_class = 'product-cards__product--' . $background_color;

do_action('cn/modules/styles', $row_id, $data);
?>

<section id="<?php echo esc_attr($row_id); ?>" class="module product-cards product-panel"
    data-page="<?php echo esc_attr($page); ?>" data-secondary="<?php echo esc_attr($secondary); ?>">


    <div
        class="product-cards__card product-panel_card product-cards__card--light-text <?php echo $background_color_class; ?> product_panel uk-grid-margin">
        <div class="product-cards__inner-wrap product-cards__inner-wrap--tools">
            <div class="product-cards__icon-wrap">
                <?php if( $product_logo ) {
                    echo wp_get_attachment_image( $product_logo, 'full' );
                }?>
            </div>
            <h3 class="product-cards__fertilizer-type"><?php echo esc_html($subtitle); ?></h3>
            <div class="product-cards__button-wrap">
                <?php if (!empty($source)) {
                $source['title'] = $source['title'];
                echo Util::getButtonHTML($source, ['class' => 'btn product-cards__button']);
            } ?>
            </div>
            <?php if (!empty($product_image)) { ?>
            <img src="<?php echo Media::getAttachmentSrcById($product_image, 'full'); ?>"
                class="product-cards__product-image">
            <?php }?>
        </div>


    </div>

</section>