<?php

namespace CN\App\Fields\Options;

use Extended\ACF\Fields\Tab;
use Extended\ACF\Fields\Image;

/**
 * Class Branding
 *
 * @package CN\App\Fields\Options
 */
class Branding
{
    /**
     * Defines fields used within Options tab.
     *
     * @return array
     */
    public function fields()
    {
        return apply_filters(
            'cn/options/branding',
            [
                Tab::make(__('Branding', 'kmag'))
                    ->placement('left'),
                Image::make(__('Site Logo', 'kmag'))
                    ->returnFormat('array')
                    ->previewSize('thumbnail')
            ]
        );
    }
}
