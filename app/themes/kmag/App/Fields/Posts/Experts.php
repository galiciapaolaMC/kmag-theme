<?php

namespace CN\App\Fields\Posts;

use Extended\ACF\Fields\Image;
use Extended\ACF\Fields\Number;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\Textarea;
use Extended\ACF\Fields\TrueFalse;

/**
 * Class Experts
 *
 * @package CN\App\Fields\Posts
 */
class Experts
{
    /**
     * Defines fields used within Expert post type.
     *
     * @return array
     */
    public function fields()
    {
        return apply_filters(
            'cn/posts/experts',
            [
                Text::make(__('Title', 'kmag')),
                TrueFalse::make(__('Featured Expert', 'kmag'))
                    ->defaultValue(false),
                Number::make(__('Order', 'kmag')),
                Textarea::make(__('Description', 'kmag'))
                    ->characterLimit(50000)
                    ->rows(2),
                Image::make(__('Expert Image', 'kmag'))
            ]
        );
    }
}
