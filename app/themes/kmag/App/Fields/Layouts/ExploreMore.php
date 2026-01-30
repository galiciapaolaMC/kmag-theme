<?php

namespace CN\App\Fields\Layouts;

use CN\App\Fields\Common;
use Extended\ACF\ConditionalLogic;
use Extended\ACF\Fields\ButtonGroup;
use Extended\ACF\Fields\Layout;
use Extended\ACF\Fields\Repeater;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\Image;
use Extended\ACF\Fields\Link;
use Extended\ACF\Fields\TrueFalse;
use Extended\ACF\Fields\Url;

/**
 * Class ExploreMore
 *
 * @package CN\App\Fields\Layouts
 */
class ExploreMore extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'cn/layout/explore-more',
            Layout::make(__('Explore More', 'kmag'), 'explore-more')
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                    Text::make(__('Eyebrow', 'kmag'), 'eyebrow')
                      ->required(),
                    Image::make(__('Header Image', 'kmag'), 'header-image')
                      ->required(),
                    Image::make(__('Mobile Header Image', 'kmag'), 'mobile-header-image')
                      ->required(),
                    ButtonGroup::make(__('Internal/Extenal Links', 'kmag'), 'link-type')
                      ->choices([
                          'internal' => __('Internal', 'kmag'),
                          'external' => __('External', 'kmag')
                        ]),
                    Link::make(__('Header Image Link', 'kmag'), 'header-image-link-internal')
                      ->conditionalLogic([
                        ConditionalLogic::where('link-type', '==', 'internal')
                      ])
                      ->required(),
                    Url::make(__('Header Image Link', 'kmag'), 'header-image-link-external')
                      ->conditionalLogic([
                        ConditionalLogic::where('link-type', '==', 'external')
                      ])
                      ->required(),
                    Repeater::make(__('Explore More Links', 'kmag'), 'explore-more-links')
                        ->fields([
                            Image::make(__('Preview Image', 'kmag'), 'preview-image'),
                            Text::make(__('Title', 'kmag'), 'title'),
                            Link::make(__('Internal Link', 'kmag'), 'internal-link')
                              ->conditionalLogic([
                                ConditionalLogic::where('link-type', '==', 'internal')
                              ]),
                            Url::make(__('External Link', 'kmag'), 'external-link')
                              ->conditionalLogic([
                                ConditionalLogic::where('link-type', '==', 'external')
                            ]),
                        ])
                        ->min(1)
                        ->max(4),
                    $this->optionsTab(),
                    TrueFalse::make(__('Hide on desktop', 'kmag'), 'hide-desktop')
                        ->defaultValue(false),
                    $this->styleTab(),
                    Common::paddingGroup(DEFAULT_EXPLORE_MORE_PADDING)
                ])
        );
    }
}