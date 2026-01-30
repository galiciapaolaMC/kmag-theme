<?php

namespace CN\App\Fields\Layouts;

use CN\App\Fields\Common;
use Extended\ACF\Fields\Layout;
use Extended\ACF\Fields\Relationship;

/**
 * Class NutrientKnowledge
 *
 * @package CN\App\Fields\Layouts
 */
class NutrientKnowledge extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'cn/layout/nutrient-knowledge',
            Layout::make(__('Nutrient Knowledge', 'kmag'), 'nutrient-knowledge')
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                    Relationship::make(__('Nutrient', 'kmag'), 'nutrient')
                        ->postTypes(['nutrients'])
                        ->filters([
                            'search',
                            'taxonomy'
                        ])
                        ->min(1)
                        ->max(1)
                        ->required(),
                    $this->styleTab(),
                    Common::paddingGroup(DEFAULT_NUTRIENT_KNOWLEDGE_PADDING)
                ])
        );
    }
}
