<?php

namespace CN\App\Fields\Layouts;

use CN\App\Fields\Common;
use Extended\ACF\Fields\Layout;
use Extended\ACF\Fields\PostObject;
use Extended\ACF\Fields\Text;

/**
 * Class NutrientTable
 *
 * @package CN\App\Fields\Layouts
 */
class NutrientTable extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'cn/layout/nutrient-table',
            Layout::make(__('Nutrient Table', 'kmag'))
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                    Text::make(__('Macronutrient Name', 'kmag'))
                        ->wrapper([
                            'width' => '50'
                        ]),
                    PostObject::make(__('Macro Nutrients', 'kmag'))
                        ->postTypes(['nutrients'])
                        ->allowMultiple()
                        ->wrapper([
                            'width' => '50'
                        ]),
                    Text::make(__('Secondary Nutrient Name', 'kmag'))
                        ->wrapper([
                            'width' => '50'
                        ]),
                    PostObject::make(__('Secondary Nutrients', 'kmag'))
                        ->postTypes(['nutrients'])
                        ->allowMultiple()
                        ->wrapper([
                            'width' => '50'
                        ]),
                    Text::make(__('Micronutrient Name', 'kmag'))
                        ->wrapper([
                            'width' => '50'
                        ]),
                    PostObject::make(__('Micro Nutrients', 'kmag'))
                        ->postTypes(['nutrients'])
                        ->allowMultiple()
                        ->wrapper([
                            'width' => '50'
                        ]),
                    Text::make(__('Non Fertilizer Name', 'kmag'))
                        ->wrapper([
                            'width' => '50'
                        ]),
                    PostObject::make(__('Non Fertilizer Nutrients', 'kmag'))
                        ->postTypes(['nutrients'])
                        ->allowMultiple()
                        ->wrapper([
                            'width' => '50'
                        ]),
                    $this->styleTab(),
                    Common::paddingGroup(DEFAULT_NUTRIENT_TABLE_PADDING)
                ])
        );
    }
}
