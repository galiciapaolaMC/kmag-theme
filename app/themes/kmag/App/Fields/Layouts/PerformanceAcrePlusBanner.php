<?php

namespace CN\App\Fields\Layouts;

use CN\App\Fields\Common;
use Extended\ACF\Fields\Layout;
use Extended\ACF\Fields\Message;

/**
 * Class PerformanceAcrePlusBanner
 *
 * @package CN\App\Fields\Layouts
 */
class PerformanceAcrePlusBanner extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'cn/layout/performance-acre-plus-banner',
            Layout::make(__('Performance Acre+ Banner', 'kmag'), 'performance-acre-plus-banner')
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                    Message::make(__('Information', 'kmag'), 'information')
                        ->message(__("Edit this module's content on the options page.", 'kmag')),
                    $this->optionsTab(),
                    Common::productColors(
                        array('default' => 'Default', 'tertiary' => 'Seed Green')
                    ),
                    $this->styleTab(),
                    Common::paddingGroup(DEFAULT_PERFORMANCE_ACRE_PLUS_BANNER_PADDING)
                ])
        );
    }
}
