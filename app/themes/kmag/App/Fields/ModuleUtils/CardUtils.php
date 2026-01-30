<?php

namespace CN\App\Fields\ModuleUtils;

use CN\App\Fields\Util;

/**
 * Class CardUtils
 *
 * @package CN\App\Fields
 */
class CardUtils
{
    private static $header_sizes = array(
        'small' => 'h3',
        'large' => 'h2'
    );

    public static function getRoundingCssClasses($values, $base_class = 'card__figure')
    {
        $class_list = [];
        foreach ($values as $corner) {
            array_push($class_list, $base_class . '--rounded-' . $corner);
        }
        return implode(' ', $class_list);
    }

    private static function getHeadingTag($size = 'medium')
    {
        if (! array_key_exists($size, self::$header_sizes)) {
            return self::$header_sizes['medium'];
        }

            return self::$header_sizes[$size];
    }

    public static function getHeadingHtml($heading = null, $size = 'large')
    {
        if (!isset($heading)) {
            return '';
        }

        // allow only bold, italics, superscripts, and subscripts
        $heading = strip_tags($heading, ALLOWED_FORMAT_TAGS);

        $heading_tag = self::getHeadingTag($size);
        $heading_size_class = 'card__heading--' . $size;

        echo nl2br(Util::getHTML(
            $heading,
            $heading_tag,
            ['class' => implode(' ', ['card__heading', $heading_size_class])],
            false
        ));
    }
}
