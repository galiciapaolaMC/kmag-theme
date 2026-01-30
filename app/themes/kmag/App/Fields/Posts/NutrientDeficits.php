<?php

namespace CN\App\Fields\Posts;

use Extended\ACF\Fields\Image;
use Extended\ACF\Fields\Repeater;
use Extended\ACF\Fields\Text;

/**
 * Class NutrientDeficits
 *
 * @package CN\App\Fields\Posts
 */
class NutrientDeficits
{
    /**
     * Defines fields used within Nutrient Deficit post type.
     *
     * @return array
     */
    public function fields()
    {
        return apply_filters(
            'cn/posts/nutrient-deficits',
            [
                Text::make(__('Crop', 'kmag')),
                Repeater::make(__('Deficit Images', 'kmag'))
                    ->fields([
                        Image::make(__('Image', 'kmag'))
                    ])
            ]
        );
    }
}
