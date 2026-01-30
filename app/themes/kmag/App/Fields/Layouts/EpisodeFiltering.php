<?php

namespace CN\App\Fields\Layouts;

use CN\App\Fields\Common;
use Extended\ACF\ConditionalLogic;
use Extended\ACF\Fields\ButtonGroup;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\TrueFalse;
use Extended\ACF\Fields\Layout;
use Extended\ACF\Fields\Repeater;

/**
 * Class EpisodeFiltering
 *
 * @package CN\App\Fields\Layouts
 */
class EpisodeFiltering extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'cn/layout/episode-filtering',
            Layout::make(__('Episode Filtering', 'kmag'), 'episode-filtering')
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                    ButtonGroup::make(__('Filter Type', 'kmag'), 'filter-type')
                        ->choices([
                            'slider' => __('Slider', 'kmag'),
                            'grid' => __('Grid', 'kmag')
                        ])
                        ->defaultValue('slider'),
                    ButtonGroup::make(__('Show Filters', 'kmag'), 'show-filters')
                        ->choices([
                            'true' => __('True', 'kmag'),
                            'false' => __('False', 'kmag')
                        ])
                        ->defaultValue('false')
                        ->conditionalLogic([
                            ConditionalLogic::where('filter-type', '==', 'grid')
                        ]),
                    Repeater::make(__('Episode Listings & Farmers', 'kmag'), 'episode-listings')
                        ->fields([
                            Text::make(__('Headline', 'kmag'), 'headline'),
                            ButtonGroup::make(__('Episode Type', 'kmag'), 'episode-type')
                                ->choices([
                                    'video' => __('Video', 'kmag'),
                                    'audio' => __('Audio', 'kmag'),
                                    'farmer' => __('Farmer', 'kmag'),
                                ])
                                ->defaultValue('video'),
                        ])
                        ->conditionalLogic([
                            ConditionalLogic::where('filter-type', '==', 'slider')
                        ]),
                    Text::make(__('Headline', 'kmag'), 'headline')
                        ->conditionalLogic([
                            ConditionalLogic::where('filter-type', '==', 'grid')
                        ]),
                    $this->styleTab(),
                    Common::paddingGroup(DEFAULT_EPISODE_FILTERING_PADDING)
                ])
        );
    }
}
