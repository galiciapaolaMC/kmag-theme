<?php

namespace CN\App\Fields\Options;

use Extended\ACF\Fields\Tab;
use Extended\ACF\Fields\Group;
use Extended\ACF\Fields\Image;
use Extended\ACF\Fields\Link;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\Textarea;

/**
 * Class TrialData
 *
 * @package CN\App\Fields\Options
 */
class TrialData
{
    /**
     * Defines fields used within Options tab.
     *
     * @return array
     */
    public function fields()
    {
        return apply_filters(
            'cn/options/trial-data',
            [
                Tab::make(__('Trial Data', 'kmag'), 'trial-data')
                    ->placement('left'),
                Group::make(__('Trial Data Banner', 'kmag'), 'trial-data-banner')
                    ->fields([
                        Image::make(__('Image (Mobile)', 'kmag'), 'image-mobile-id')
                            ->returnFormat('id'),
                        Image::make(__('Image (Desktop)', 'kmag'), 'image-desktop-id')
                            ->returnFormat('id'),
                        Text::make(__('Headline', 'kmag'), 'headline'),
                        Textarea::make(__('Content', 'kmag'), 'content')
                            ->rows(2),
                        Link::make(__('CTA Link', 'kmag'), 'cta-link'),
                    ]),
            ]
        );
    }
}
