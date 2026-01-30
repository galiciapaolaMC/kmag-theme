<?php

namespace CN\App\Fields\Layouts;

use CN\App\Fields\Common;
use Extended\ACF\Fields\Number;
use Extended\ACF\Fields\Layout;
use Extended\ACF\Fields\Repeater;
use Extended\ACF\Fields\Text;

/**
 * Class Jump To Navigation
 *
 * @package CN\App\Fields\Layouts
 */
class JumpToNavigation extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'cn/layout/jump-to-navigation',
            Layout::make(__('Jump To Navigation', 'kmag'), 'jump-to-navigation')
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                    Repeater::make(__('Navigation Items', 'kmag'), 'navigation-items')
                        ->layout('block')
                        ->min(1)
                        ->buttonLabel(__('Add Item', 'kmag'), 'add-item')
                        ->fields([
                            Text::make(__('Name', 'kmag'), 'name')
                                ->required()
                                ->wrapper([
                                    'width' => '50'
                                ]),
                            Number::make(__('Module Number', 'kmag'), 'module-number')
                                ->min(1)
                                ->required()
                                ->wrapper([
                                    'width' => '50'
                                ])
                        ]),

                    $this->styleTab(),
                    Common::paddingGroup(DEFAULT_JUMP_TO_NAVIGATION_PADDING)
                ])
        );
    }
}
