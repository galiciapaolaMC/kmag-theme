<?php

namespace CN\App\Fields\ModuleUtils;

/**
 * Class ImageFiftyFiftyUtils
 *
 * @package CN\App\Fields
 */
class FiftyFiftyUtils
{
    public static function getRoundingCssClasses($values, $base_class_prefix = 'image', $base_class = '-fifty-fifty__image-holder')
    {
        $class_list = [];
        foreach ($values as $corner) {
            array_push($class_list, $base_class_prefix . $base_class . '--rounded-' . $corner);
        }
        return implode(' ', $class_list);
    }
}
