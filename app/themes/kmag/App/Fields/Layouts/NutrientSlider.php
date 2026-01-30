<?php

namespace CN\App\Fields\Layouts;

use CN\App\Fields\Common;
use Extended\ACF\Fields\Layout;
use Extended\ACF\Fields\PostObject;

/**
 * Class NutrientSlider
 *
 * @package CN\App\Fields\Layouts
 */
class NutrientSlider extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'cn/layout/nutrient-slider',
            Layout::make(__('Nutrient Slider', 'kmag'))
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                    PostObject::make(__('Nutrients', 'kmag'))
                        ->postTypes(['nutrients'])
                        ->allowMultiple()
                        ->wrapper([
                            'width' => '100'
                        ]),
                    $this->styleTab(),
                    Common::paddingGroup(DEFAULT_NUTRIENT_SLIDER_PADDING)
                ])
        );
    }
}
