<?php

namespace CN\App\Fields;

use CN\App\Media;

/**
 * Class Util
 *
 * @package CN\App\Fields
 */
class Util
{

    /**
     * Wraps data in HTML w/ optional attributes / escaping.
     *
     * @param       $data - the content (typically text) to wrap
     * @param       $element - the HTML element to wrap the content with
     * @param array $atts - any attributes that should be added to the HTML element
     * @param mixed $escape - whether to escape $data - defaults to true - can be an escaping function
     * @param bool $self_closing - whether the element is self closing i.e. <img />
     *
     * @return string - an HTML element.
     */
    public static function getHTML($data = null, $element = 'span', $atts = [], $escape = true, $self_closing = false)
    {
        $atts_output = ' ';

        // data cannot be empty without the element being self-closing
        if (empty($data) && $self_closing === false) {
            return '';
        }

        if (is_callable($escape)) {
            $data = $escape($data);
        } elseif ($escape) {
            $data = esc_html($data);
        }

        foreach ($atts as $key => $att) {
            // do not proceed if key is empty
            if (empty($key)) {
                continue;
            }

            // if key is present and attribute is empty, add only key to output.
            // This allows for HTML5 boolean attributes.
            // e.g. <input type="checkbox" checked disabled>Test</input>
            if (!isset($att) || empty($att)) {
                $atts_output .= esc_attr($key) . ' ';
                continue;
            }

            $atts_output .= esc_attr($key) . '="' . esc_attr($att) . '" ';
        }

        return $self_closing ? '<' . $element . $atts_output . ' />' : '<' . $element . $atts_output . '>' . $data . '</' . $element . '>';
    }


    /**
     * Helper/wrapper function that makes dealing with ACF image objects easier.
     * Grabs the required data from the ACF image object renders values into proper image markup.
     *
     * @param $attachment
     * @param string $size
     * @param array $args
     *
     * @return string
     */
    public static function getImageHTML($attachment, $size = 'medium', $args = [])
    {
        $src    = ACF::getField($size, $attachment->sizes, $attachment->url);
        $alt    = !empty($attachment->alt) ? esc_attr($attachment->alt) : esc_attr($attachment->title);
        $params = '';
        foreach ($args as $attr => $value) {
            $params .= sprintf(
                ' %1$s="%2$s"',
                $attr,
                esc_attr($value)
            );
        }
        $image_markup = sprintf(
            '<img src="%1$s" alt="%2$s"%3$s>',
            esc_url($src),
            esc_attr($alt),
            $params
        );
        // check for image caption
        if (!empty($attachment->caption)) {
            $image_markup = sprintf(
                '<figure class="image__caption">%1$s <figcaption>%2$s</figcaption></figure>',
                $image_markup,
                esc_html($attachment->caption)
            );
        }

        return $image_markup;
    }

    /**
     * Helper/wrapper function that makes dealing with ACF image objects easier in relation to background images.
     * Grabs the required data from the ACF image object and generates the string that can be concatenated into a style property.
     * This function could probably be refactored with fewer conditions
     *
     * @param $image_id
     * @param string $additional_inline_style
     *
     * @return string
     */
    public static function getBackgroundImageStyle($image_id, $additional_inline_style = '')
    {
        $has_image = ! empty($image_id);

        if (!$has_image) {
            return '';
        }

        $image_attachment = $has_image ? Media::getAttachmentByID($image_id) : false;

        if ($image_attachment) {
            $src = ACF::getField('full', $image_attachment->sizes, $image_attachment->url);
            if (! empty($src)) {
                return 'background-image: url(\'' . esc_html($src) . '\'); '. $additional_inline_style .'';
            }
        }

        return '';
    }

    /**
     * Check for background options in module data and output inline styles.
     *
     * @param $data
     * @param $size
     *
     * @return string
     */
    public static function getInlineBackgroundStyles($data, $size = 'full')
    {
        if (empty($data) || !isset($data['background_background-size'])) {
            return '';
        }

        // build out our inline background styles
        $styles = sprintf(
            'background-repeat: %1$s; background-position: %2$s; background-size: %3$s;',
            ACF::getField('background_background-repeat', $data, 'no-repeat'),
            ACF::getField('background_background-position', $data, 'center center'),
            ACF::getField('background_background-size', $data, 'auto auto')
        );

        return $styles;
    }

    /**
     * Returns transformed icons along with a class--modifier value in place of the default SVG
     *
     * @param string $icon_name
     *
     * @return array
     */
    public static function transformRedundantIcons($icon_name)
    {
        if (empty($icon_name)) {
            return null;
        }

        $icon_transformations = array(
            'arrow-left' => array('icon' => 'arrow-right', 'class' => 'icon--rotate-180')
        );

        if (array_key_exists($icon_name, $icon_transformations)) {
            return $icon_transformations[$icon_name];
        }

        return null;
    }

    /**
     * Returns standardized icon html by name
     *
     * @param string $icon_name
     * @param bool $position - optional, 0 for icon-start, 1 for icon-end
     *
     * @return string
     */
    public static function getIconHTML($icon_name, $position = null)
    {
        if (empty($icon_name)) {
            return '';
        }

        $pos = '';
        if ($position !== null) {
            $pos = $position === 0 ? ' icon-start' : ' icon-end';
        }

        $redundant_icon_properties = self::transformRedundantIcons($icon_name);
        $icon_transform_class = '';
        if (!empty($redundant_icon_properties)) {
            $icon_transform_class = $redundant_icon_properties['class'];
            $icon_name = $redundant_icon_properties['icon'];
        }
        return sprintf(
            '<svg class="icon icon-%1$s%2$s %3$s" aria-hidden="true">
                <use xlink:href="#icon-%1$s"></use>
            </svg>',
            $icon_name,
            $pos,
            $icon_transform_class
        );
    }

    /**
     * Wrapper function for parsing button data and outputting proper markup.
     *
     * @param $link_array
     * @param array $args
     *
     * @return string
     */
    public static function getButtonHTML($link_array, $args = [])
    {
        $output = '';
        if (!isset($link_array['title'])) {
            return $output;
        }
        $valid_button_types = ['default', 'inline-link'];
        $defaults = [
            'class' => 'btn btn-primary',
            'icon-end' => '',
            'icon-start' => '',
            'button-type' => 'default'
        ];
        $atts = wp_parse_args($args, $defaults);

        if (in_array($atts['button-type'], $valid_button_types) && $atts['button-type'] == 'inline-link') {
            $atts['class'] = $atts['class'] . ' btn--inline-link';
        }

        $icon_start = self::getIconHTML($atts['icon-start'], 0);
        $icon_end = self::getIconHTML($atts['icon-end'], 1);

        $output = sprintf(
            '<a href="%2$s" target="%3$s" class="%4$s">%5$s%1$s%6$s</a>',
            esc_html($link_array['title']),
            esc_url($link_array['url']),
            esc_attr($link_array['target']),
            $atts['class'],
            $icon_start,
            $icon_end,
        );

        return $output;
    }

    /**
     * Convert contentful json single quotes to double quotes
     * and then decode the JSON string into an array
     *
     * @param string $json_string
     *
     * @return array
     */
    public static function convertJsonQuotes($json_string)
    {
        if (empty($json_string)) {
            return [];
        }

        // Replace single quotes with double quotes
        $json_stats = str_replace("'", '"', $json_string);

        // Decode the JSON string into an array
        $stats_array = json_decode($json_stats, true);

        return $stats_array;
    }
}
