<?php

namespace CN\App\Fields\Options;

use Extended\ACF\Fields\Group;
use Extended\ACF\Fields\Tab;
use Extended\ACF\Fields\Text;

/**
 * Class PerformanceMap
 *
 * @package CN\App\Fields\Options
 */
class PerformanceMap
{
    /**
     * Defines fields used within Options tab.
     *
     * @return array
     */
    public function fields()
    {
        return apply_filters(
            'cn/options/performance-map',
            [
                Tab::make(__('Performance Map', 'kmag'))
                    ->placement('left'),
                Group::make(__('Mapbox API', 'kmag'), 'mapbox-api')
                    ->layout('block')
                    ->fields([
                        Text::make(__('API Key', 'kmag'), 'api-key'),
                    ]),
                    
            ]
        );
    }
}
