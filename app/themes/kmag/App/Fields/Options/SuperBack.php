<?php

namespace CN\App\Fields\Options;

use Extended\ACF\Fields\Tab;
use Extended\ACF\Fields\Repeater;
use Extended\ACF\Fields\Text;

/**
 * Class SuperBack
 *
 * @package CN\App\Fields\Options
 */
class SuperBack
{
    /**
     * Defines fields used within Options tab.
     *
     * @return array
     */
    public function fields()
    {
        return apply_filters(
            'cn/options/super-back',
            [
                Tab::make(__('Super Back', 'kmag'))
                    ->placement('left'),
                Repeater::make(__('Referrer Slug', 'kmag'))
                    ->fields([
                        Text::make(__('Slug', 'kmag'))
                    ])
                    ->buttonLabel(__('Add Referrer Slug', 'kmag'))
                    ->layout('table')
                    ->instructions(__('When a user follows a link from one of these slugs, the superback will appear on the subsequent page.', 'kmag')),
                Repeater::make(__('Global Filter Referrer Slug', 'kmag'))
                    ->fields([
                        Text::make(__('Slug', 'kmag'))
                    ])
                    ->buttonLabel(__('Add Referrer Slug', 'kmag'))
                    ->layout('table')
                    ->instructions(__('When a user follows a link from one of these slugs, the superback will appear on the subsequent page only when the global filter is set by the visitor.', 'kmag'))
            ]
        );
    }
}
