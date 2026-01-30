<?php

namespace CN\App\Fields\Options;

use Extended\ACF\Fields\Number;
use Extended\ACF\Fields\Tab;

/**
 * Class GatedContent
 *
 * @package CN\App\Fields\Options
 */
class GatedContent
{
    /**
     * Defines fields used within Options tab.
     *
     * @return array
     */
    public function fields()
    {
        return apply_filters(
            'cn/options/gated-content',
            [
                Tab::make(__('Gated Content', 'kmag'))
                    ->placement('left'),
                Number::make(__('Gate Delay', 'kmag'), 'gate-delay')
                    ->instructions(__('Delay in seconds before Gate appears on page', 'kmag'))
                    ->defaultValue(5),
                Number::make(__('Gate Duration', 'kmag'), 'gate-duration')
                    ->instructions(__('Set duration in days for how long the has_passed_gate cookie stays in the user\'s browser. You can use decimals such as .5 for a half day.', 'kmag'))
                    ->defaultValue(1),
                Number::make(__('GDA Gate Duration', 'kmag'), 'gda-gate-duration')
                    ->instructions(__('Duration for GDA Testing. Set duration in days for how long the has_passed_gate cookie stays in the user\'s browser. You can use decimals such as .5 for a half day or .01 for 15 minutes.', 'kmag'))
                    ->defaultValue(1)
            ]
        );
    }
}
