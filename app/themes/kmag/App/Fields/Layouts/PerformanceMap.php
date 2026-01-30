<?php

namespace CN\App\Fields\Layouts;

use CN\App\Fields\Common;
use Extended\ACF\Fields\Layout;
use Extended\ACF\Fields\TextArea;
use Extended\ACF\Fields\Group;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\Link;
/**
 * Class PerformanceMap
 *
 * @package CN\App\Fields\Layouts
 */
class PerformanceMap extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'cn/layout/performance-map',
            Layout::make(__('Performance Map', 'kmag'))
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                    Textarea::make(__('Headline', 'kmag'), 'headline')
                        ->rows(2)
                        ->instructions(__('If necessary wrap the text with: <br/> &lt;b>&lt;/b> for bold text <br/> &lt;i>&lt;/i> for italics <br/> &lt;sup>&lt;/sup> for superscripts <br/> &lt;sub>&lt;/sub> for subscripts', 'kmag'))
                        ->required(),
                    Textarea::make(__('Mobile Headline', 'kmag'), 'mobile-headline')
                        ->rows(2)
                        ->instructions(__('If necessary wrap the text with: <br/> &lt;b>&lt;/b> for bold text <br/> &lt;i>&lt;/i> for italics <br/> &lt;sup>&lt;/sup> for superscripts <br/> &lt;sub>&lt;/sub> for subscripts', 'kmag'))
                        ->required(),
                        $this->optionsTab(),
                        Group::make(__('Google Storage URL', 'kmag'), 'google-storage')
                            ->layout('block')
                            ->fields([
                                Text::make(__('Map JSON URL', 'kmag'), 'map-json'),
                            ]),
                        Group::make(__('Map Popup URL', 'kmag'), 'map-popup')
                            ->layout('block')
                            ->fields([
                                Link::make(__('Field Study Data URL', 'kmag'), 'field-study-url')
                            ]),  
                    $this->styleTab(),
                    Common::paddingGroup(DEFAULT_PERFORMANCE_MAP_PADDING),
                ])
        );
    }
}
