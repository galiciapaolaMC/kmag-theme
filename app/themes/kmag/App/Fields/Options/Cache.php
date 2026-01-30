<?php

namespace CN\App\Fields\Options;

use Extended\ACF\Fields\Tab;
use Extended\ACF\Fields\Relationship;

/**
 * Class Cache
 *
 * @package CN\App\Fields\Options
 */
class Cache
{
    /**
     * Defines fields used within Options tab.
     *
     * @return array
     */
    public function fields()
    {
        return apply_filters(
            'cn/options/cache',
            [
                Tab::make(__('Cache Control', 'kmag'))
                    ->placement('left'),
                Relationship::make(__('Non-cached pages', 'kmag'), 'non_cached_pages')
                    ->filters([
                        'search',
                        'post_type',
                    ])
                    ->elements(['featured_image'])
            ]
        );
    }
}
