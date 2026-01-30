<?php

namespace CN\App\Fields\Options;

use Extended\ACF\Fields\Tab;
use Extended\ACF\Fields\Textarea;

/**
 * Class Scripts
 *
 * @package CN\App\Fields\Options
 */
class Scripts
{
    /**
     * Defines fields used within Options tab.
     *
     * @return array
     */
    public function fields()
    {
        return apply_filters(
            'cn/options/scripts',
            [
                Tab::make(__('Scripts', 'kmag'))
                    ->placement('left'),
                Textarea::make(__('Head Scripts', 'kmag'), 'head_scripts')
                    ->rows(10),
                Textarea::make(__('Body Scripts', 'kmag'), 'body_scripts')
                    ->rows(10),
                Textarea::make(__('Footer Scripts', 'kmag'), 'footer_scripts')
                    ->rows(10),
            ]
        );
    }
}
