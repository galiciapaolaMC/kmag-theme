<?php

namespace CN\App\Fields\Layouts;

use CN\App\Fields\Common;
use Extended\ACF\Fields\Layout;
use Extended\ACF\Fields\Repeater;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\TextArea;
use Extended\ACF\Fields\Link;
use Extended\ACF\Fields\Image;
use Extended\ACF\Fields\Select;

/**
 * Class NutrientDeficiencies
 * 
 * @package CN\App\Fields\Layouts
 */
class NutrientDeficiencies extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'cn/layout/NutrientDeficiencies',
            Layout::make(__('Nutrient Deficiencies', 'kmag'), 'nutrient-deficiencies')
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                    Common::nutrientChoice('nutrient', 'select')
                        ->required(),
                    TextArea::make(__('Crop Images Credit', 'kmag'), 'image-credit')
                        ->defaultValue(__('All photos are provided courtesy of the The Fertilizer Institute (TFI) and its TFI Crop Nutrient Deficiency Image Collection. The photos above are a sample of a greater collection, which provides a comprehensive sampling of hundreds of classic cases of crop deficiency from research plots and farm fields located around the world. For access to the full collection, you can visit TFI\'s website.', 'kmag')),
                    $this->styleTab(),
                    Common::paddingGroup(DEFAULT_NUTRIENT_DEFICIENCY_PADDING)
                ])
        );
    }
}
