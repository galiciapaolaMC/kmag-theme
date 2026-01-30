<?php

namespace CN\App\Fields\Options;

use Extended\ACF\Fields\File;
use Extended\ACF\Fields\Group;
use Extended\ACF\Fields\Tab;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\Textarea;

/**
 * Class DealerLocator
 *
 * @package CN\App\Fields\Options
 */
class DealerLocator
{
    /**
     * Defines fields used within Options tab.
     *
     * @return array
     */
    public function fields()
    {
        return apply_filters(
            'cn/options/dealer-locator',
            [
                Tab::make(__('Dealer Locator', 'kmag'))
                    ->placement('left'),
                Group::make(__('Google Maps API', 'kmag'), 'google-maps-api')
                    ->layout('block')
                    ->fields([
                        Text::make(__('API Key', 'kmag'), 'api-key'),
                    ]),
                Textarea::make(
                    __('Dealer Locator CSV Import File', 'kmag'),
                    'dealer-locator-json-content'
                )
                    ->instructions(__('Add JSON for dealer locator data.', 'kmag'))
            ]
        );
    }
}
