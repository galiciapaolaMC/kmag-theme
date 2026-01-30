<?php

namespace CN\App\Fields\Layouts;

use CN\App\Fields\Common;
use Extended\ACF\Fields\Layout;

/**
 * Class BentoBox
 *
 * @package CN\App\Fields\Layouts
 */
class BentoBox extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'cn/layout/bento-box',
            Layout::make(__('Bento Box', 'kmag'))
                ->layout('block')
                ->fields([
                    $this->styleTab(),
                    Common::paddingGroup(DEFAULT_CALCULATOR_PADDING)
                ])
        );
    }
}
