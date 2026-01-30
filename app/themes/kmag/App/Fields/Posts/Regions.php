<?php

namespace CN\App\Fields\Posts;

use Extended\ACF\Fields\PostObject;
use Extended\ACF\Fields\Repeater;
use Extended\ACF\Fields\Text;

/**
 * Class Regions
 *
 * @package CN\App\Fields\Posts
 */
class Regions
{
    /**
     * Defines fields used within Region post type.
     *
     * @return array
     */
    public function fields()
    {
        return apply_filters(
            'cn/posts/regions',
            [
                PostObject::make(__('Crops', 'kmag'))
                    ->postTypes(['crops'])
                    ->allowMultiple(),
                Repeater::make(__('States', 'kmag'))
                    ->fields([
                        Text::make(__('State Name', 'kmag'))
                    ])
                    ->buttonLabel(__('Add State', 'kmag'))
                    ->layout('table')
            ]
        );
    }
}
