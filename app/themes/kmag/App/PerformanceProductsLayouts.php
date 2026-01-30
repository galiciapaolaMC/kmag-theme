<?php

namespace CN\App;

use CN\App\Interfaces\WordPressHooks;
use CN\App\Media;
use CN\App\Fields\ACF;
use CN\App\Fields\Util;

/**
 * Class PerformanceProductsLayouts
 *
 * @package CN\App
 */

class PerformanceProductsLayouts implements WordPressHooks
{
    /**
     * Add class hooks.
     */
    public function addHooks()
    {
        add_action('cn/performance-product-banner/output', [$this, 'outputPerformanceProductBanner'], 10, 4);
        add_action('cn/performance-product-logo/output', [$this, 'outputPerformanceProductLogo'], 10, 1);
    }

    public function outputPerformanceProductBanner($product_id, $logo_variant = 'dark', $additional_logo = 'hide', $logo_size = 'small')
    {
        if (empty($product_id)) {
            return;
        }

        if ($logo_variant === 'dark') {
            $logo_field = 'black-logo';
        } else {
            $logo_field = 'logo';
        }

        $args = array(
            'post_type' => 'performance-products',
            'post_status' => 'publish',
            'post__in' => $product_id
        );

        $query = new \WP_Query($args);
        while ($query->have_posts()) :
            $query->the_post();
            $post_id = get_the_ID();
            $meta = ACF::getPostMeta($post_id);
            $product_logo_id = ACF::getField($logo_field, $meta);
            $product_color = ACF::getField('color', $meta, 'transparent');
            if (!empty($product_logo_id)) { ?>
                <div class="hero__logo-container">
                    <div class="hero__product-logo logo-size-<?php echo esc_attr($logo_size); ?>" style="background-color: <?php echo esc_attr($product_color); ?>">
                        <?php echo Util::getImageHTML(Media::getAttachmentByID($product_logo_id)); ?>
                    </div>

                    <?php if ($additional_logo === 'show') {
                        $additional_hero_logo_id = ACF::getField('additional-hero-logo', $meta);
                        if (!empty($additional_hero_logo_id)) { ?>
                            <div class="hero__product-additional-logo">
                                <?php echo Util::getImageHTML(Media::getAttachmentByID($additional_hero_logo_id)); ?>
                            </div>
                        <?php }
                    } ?>
                </div>
            <?php } ?>
            
        <?php endwhile;
    }

    public function outputPerformanceProductLogo($product_id)
    {
        if (empty($product_id)) {
            return;
        }

        $args = array(
            'post_type' => 'performance-products',
            'post_status' => 'publish',
            'post__in' => $product_id
        );

        $query = new \WP_Query($args);

        while ($query->have_posts()) :
            $query->the_post();
            $post_id = get_the_ID();
            $meta = ACF::getPostMeta($post_id);
            $product_logo_id = ACF::getField('black-logo', $meta);
            
            if (!empty($product_logo_id)) { ?>
                <div class="hero__product-campaign-logo">
                    <?php echo Util::getImageHTML(Media::getAttachmentByID($product_logo_id)); ?>
                </div>
            <?php } ?>
            
        <?php endwhile;
    }
}
