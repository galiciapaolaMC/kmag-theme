<?php

namespace CN\App\Fields\Options;

use Extended\ACF\Fields\Tab;
use Extended\ACF\Fields\Repeater;
use Extended\ACF\Fields\Text;

/**
 * Class CropList
 *
 * @package CN\App\Fields\Options
 */
class CropList
{
    /**
     * Defines fields used within Options tab.
     *
     * @return array
     */
    public function fields()
    {
        return apply_filters(
            'cn/options/crop-list',
            [
                Tab::make(__('CropList', 'kmag'))
                    ->placement('left'),
                Repeater::make(__('Crops', 'kmag'))
                    ->fields([
                        Text::make(__('Name', 'kmag')),
                        Text::make(__('Slug', 'kmag'))
                    ])
                    ->buttonLabel(__('Add Crop', 'kmag'))
                    ->layout('table')
            ]
        );
    }
}
