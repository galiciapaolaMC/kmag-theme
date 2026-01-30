<?php

namespace CN\App\Posts\Types;

use CN\App\Interfaces\WordPressHooks;
use CN\App\Posts\PostTypes;
use CN\App\Posts\Taxonomies;

/**
 * Class Robust Articles
 *
 * @package CN\App\Posts\Types
 */
class RobustArticles implements WordPressHooks
{
    /**
     * Add class hooks.
     */
    public function addHooks()
    {
        add_action('init', [$this, 'registerPost']);
        add_shortcode('ra_video_slider', [$this, 'raVideoSlider']);
    }

    /**
     * Register Post Type.
     */
    public function registerPost()
    {
        PostTypes::registerPostType(
            'robust-articles',
            __('Robust Article', 'kmag'),
            __('Robust Articles', 'kmag'),
            [
                'menu_icon' => 'dashicons-admin-multisite',
                'supports' => ['title', 'thumbnail'],
                'menu_position' => 29,
                'has_archive' => false,
                'rewrite' => array('slug' => 'resource-library')
            ]
        );
    }

    /**
     * For pushing video items to the slider
     * @param $atts
     * @return false|string
     */
    public function raVideoSlider($atts)
    {
        $atts = shortcode_atts(
            array(
                'items' => '',
                'default' => 'autoplay: true; autoplay-interval: 4000; pause-on-hover: true;'
            ), $atts, 'ra_video_slider'
        );
        $items = explode(',', $atts['items']);
        ob_start();
        ?>
        <div class="uk-slider-container ra-video-slider-holder__desktop" tabindex="-1"
             uk-slider="<?php echo esc_attr($atts['default']); ?>">
            <ul class="uk-slider-items uk-child-width-1-1@s uk-child-width-1-3@m uk-grid">
                <?php foreach ($items as $key => $item) {
                    ?>
                    <li data-index="<?php echo esc_attr($key); ?>">
                        <div class="uk-panel">
                            <figure>
                                <video muted="muted" autoplay="autoplay" loop="loop"
                                       src="<?php echo esc_attr($item); ?>"></video>
                            </figure>
                        </div>
                    </li>
                <?php } ?>
            </ul>
        </div>
        <div class="uk-container uk-container-large uk-grid ra-video-slider-holder__mobile">
            <?php foreach ($items as $key => $item) {
                ?>
                <div class="uk-width-1-1@m uk-width-1-1@s uk-padding-remove-left uk-margin-small-top">
                    <div class="uk-panel">
                        <figure>
                            <video muted="muted" autoplay="autoplay" loop="loop"
                                   src="<?php echo esc_attr($item); ?>"></video>
                        </figure>
                    </div>
                </div>
            <?php } ?>
        </div>
        <?php
        return ob_get_clean();
    }
}
