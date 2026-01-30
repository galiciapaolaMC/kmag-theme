<?php

namespace CN\App\Fields\Layouts;

use Extended\ACF\ConditionalLogic;
use CN\App\Fields\Common;
use Extended\ACF\Fields\Layout;
use Extended\ACF\Fields\Relationship;
use Extended\ACF\Fields\Select;

/**
 * Class BackgroundGradient
 *
 * @package CN\App\Fields\Layouts
 */
class BackgroundGradient extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'cn/layout/background-gradient',
            Layout::make(__('Background Gradient', 'kmag'), 'background-gradient')
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                    Select::make(__('Page Type', 'kmag'), 'page-type')
                        ->choices([
                            'core-page' => __('Core Page', 'kmag'),
                            'cn-page' => __('CN Page', 'kmag'),
                            'bioscience-page' => __('Bioscience Page', 'kmag'),
                            'biostimulant-page' => __('Bio Crop Stimulants Page', 'kmag'),
                            'nutrient-enhancer-page' => __('Bio K-Mag Page', 'kmag'),
                            'highlight-blue' => __('Highlight Blue', 'kmag'),
                            'product-page' => __('Product Page', 'kmag')
                        ])
                        ->defaultValue('core-page')
                        ->returnFormat('value')
                        ->wrapper([
                            'width' => '50'
                        ]),
                    Select::make(__('Gradient Position', 'kmag'), 'gradient-position')
                        ->choices([
                            'top' => __('Top', 'kmag'),
                            'middle' => __('Middle', 'kmag'),
                            'bottom' => __('Bottom', 'kmag')
                        ])
                        ->defaultValue('top')
                        ->returnFormat('value')
                        ->wrapper([
                            'width' => '50'
                        ]),
                    Relationship::make(__('Performance Products', 'kmag'), 'perfomance-products-option')
                        ->postTypes(['performance-products'])
                        ->filters([
                            'search',
                            'taxonomy'
                        ])
                        ->min(1)
                        ->max(1)
                        ->required()
                        ->conditionalLogic([
                            ConditionalLogic::where('page-type', '==', 'product-page')
                        ]),
                ])
        );
    }
}
