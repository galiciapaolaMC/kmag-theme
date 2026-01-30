<?php

namespace CN\App;

use CN\App\Fields\Util;
use CN\App\Interfaces\WordPressHooks;

/**
 * Class Shortcodes
 *
 * @package CN\App
 */
class Shortcodes implements WordPressHooks
{

    /**
     * Add class hooks.
     */
    public function addHooks()
    {
        add_shortcode('button', [$this, 'button']);
        add_shortcode('tooltip', [$this, 'tooltip']);
        add_shortcode('rvc_form', [$this, 'rvc_form']);
        add_shortcode('image_slider', [$this, 'image_slider']);
    }

    /**
     * Generate button markup
     *
     * @param $atts
     * @param null $content
     *
     * @return string
     */
    public function button($atts, $content = null)
    {
        $atts = shortcode_atts(
            [
                'link'    => '#',
                'target'  => '_blank',
                'classes' => 'btn',
                'style'   => 'btn-default',
                'block'   => ''
            ],
            $atts,
            'button'
        );

        $classes = $atts['classes'] . ' ' . $atts['style'];
        $classes .= (! empty($atts['block']) && 'true' === $atts['block']) ? ' btn-block' : '';

        return "<a class=\"{$classes}\" href=\"{$atts['link']}\" target=\"{$atts['target']}\">{$content}</a>";
    }

    /**
     * Bootstrap tooltip markup
     *
     * @param $atts
     * @param null $content
     *
     * @return string
     */
    public function tooltip($atts, $content = null)
    {
        $atts = shortcode_atts(
            [
                'text'      => 'NO TEXT ENTERED',
                'placement' => 'top'
            ],
            $atts,
            'tooltip'
        );

        return "<span data-toggle=\"tooltip\" data-placement=\"{$atts['placement']}\" title=\"{$atts['text']}\">" . do_shortcode($content) . "</span>";
    }

    public function rvc_form($atts, $content = null)
    {
        $atts = shortcode_atts(
            [
                'confirmation_slug' => '',
            ],
            $atts,
            'rvc_form'
        );

        wp_localize_script('cn-theme', 'rvc_data', array(
            'confirmation_page_slug' => $atts['confirmation_slug']
        ));

        return get_template_part('/partials/retail-value-calculator-form');
    }

    /**
     * For pushing image with captions as a slider
     * @param $atts
     * @return false|string
     */
    public function image_slider($atts)
    {
        $atts = shortcode_atts(
            array(
                'links' => '',
                'texts' => '',
                'id' => '',
                'nav' => 'true',
                'class' => 'uk-child-width-1-1@s uk-child-width-1-1@m'
            ), $atts, 'image_slider'
        );
        $links = explode('|', $atts['links']);
        $texts = explode('|', $atts['texts']);
        $items = [];
        foreach ($links as $key => $link) {
            $items[$key]["link"] = $link;
            $items[$key]["text"] = isset($texts[$key]) ? $texts[$key] : '';
        }

        $id = $atts['id'];
        ob_start();
        ?>
        <div class="uk-position-relative uk-visible-toggle uk-light img-slider-shtcode" <?php if (!empty($id)) {
            echo 'id="' . $id . '"';
        } ?> tabindex="-1" uk-slider autoplay center>
            <ul class="uk-slider-items <?php echo esc_attr($atts['class']); ?> uk-grid">
                <?php foreach ($items as $key => $item) {
                    ?>
                    <li data-index="<?php echo esc_attr($key); ?>">
                        <div class="uk-flex uk-flex-center">
                            <figure>
                                <img src="<?php echo esc_attr($item["link"]); ?>"
                                     alt="<?php if (!empty($item["text"])) {
                                         echo esc_attr($item["text"]);
                                     } ?>">
                                <?php if (!empty($item["text"])) { ?>
                                    <figcaption
                                            class="uk-flex"><?php echo esc_html($item["text"]); ?></figcaption>
                                <?php } ?>
                            </figure>
                        </div>
                    </li>
                <?php } ?>
            </ul>
            <?php if ($atts['nav'] == 'true') { ?>
                <button class="uk-position-center-left uk-position-small uk-hidden-hover cust-nav" href="#" uk-slidenav-previous
                   uk-slider-item="previous"></button>
                <button class="uk-position-center-right uk-position-small uk-hidden-hover cust-nav" href="#" uk-slidenav-next
                   uk-slider-item="next"></button>
            <?php } ?>
        </div>
        <?php
        return ob_get_clean();
    }
}
