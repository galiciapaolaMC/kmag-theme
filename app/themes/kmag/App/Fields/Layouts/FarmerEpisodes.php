<?php

namespace CN\App\Fields\Layouts;

use CN\App\Fields\Common;
use Extended\ACF\ConditionalLogic;
use Extended\ACF\Fields\ButtonGroup;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\Layout;
use Extended\ACF\Fields\Repeater;

/**
 * Class FarmerEpisodes
 *
 * @package CN\App\Fields\Layouts
 */
class FarmerEpisodes extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'cn/layout/farmer-episodes',
            Layout::make(__('Farmer Episodes', 'kmag'), 'farmer-episodes')
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                    Text::make(__('Headline', 'kmag'), 'headline'),
                    ButtonGroup::make(__('Show Episodes', 'kmag'), 'show-episodes')
                        ->choices([
                            'yes' => __('Yes', 'kmag'),
                            'no' => __('No', 'kmag')
                        ])
                        ->defaultValue('yes'),
                    $this->styleTab(),
                    Common::paddingGroup(DEFAULT_EPISODE_FILTERING_PADDING)
                ])
        );
    }
}
