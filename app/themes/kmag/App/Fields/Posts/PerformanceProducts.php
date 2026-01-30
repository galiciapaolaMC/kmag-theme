<?php

namespace CN\App\Fields\Posts;

use CN\App\Fields\Layouts\Layouts;
use Extended\ACF\ConditionalLogic;
use Extended\ACF\Fields\ButtonGroup;
use Extended\ACF\Fields\ColorPicker;
use Extended\ACF\Fields\Group;
use Extended\ACF\Fields\Image;
use Extended\ACF\Fields\Number;
use Extended\ACF\Fields\Relationship;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\Textarea;

/**
 * Class PerformanceProducts
 *
 * @package CN\App\Fields\Posts
 */
class PerformanceProducts extends Layouts
{
    /**
     * Defines fields used within Products post type.
     *
     * @return array
     */
    public function fields()
    {
        return apply_filters(
            'cn/posts/performance-products',
            [
                Text::make(__('Name', 'kmag')),
                Number::make(__('Order', 'kmag')),
                Image::make(__('Logo', 'kmag'))
                    ->wrapper([
                        'width' => '50'
                    ]),
                Image::make(__('Black Logo', 'kmag'), 'black-logo')
                    ->wrapper([
                        'width' => '50'
                    ]),
                Image::make(__('Card Logo', 'kmag'), 'card-logo')
                    ->wrapper([
                        'width' => '50'
                    ]),
                Image::make(__('Additional Hero Logo', 'kmag'), 'additional-hero-logo')
                    ->wrapper([
                        'width' => '50'
                    ]),
                Textarea::make(__('Tagline', 'kmag'))
                    ->characterLimit(500)
                    ->rows(2),
                Textarea::make(__('Description', 'kmag'))
                    ->characterLimit(50000)
                    ->rows(2),
                ButtonGroup::make(__('Product Category', 'kmag'), 'product-fertilizer-category')
                    ->choices([
                        'performance-fertilizer' => __('Performance Fertilizer', 'kmag'),
                        'biological-fertilizer-compliment' => __('Biological Fertilizer Compliment', 'kmag'),
                        'suplemental-fertilizer' => __('Suplemental Fertilizer', 'kmag'),
                    ])
                    ->returnFormat('value'),
                ButtonGroup::make(__('Icon Section Variant', 'kmag'), 'icon-section-variant')
                    ->choices([
                        'nutrient-list' => __('Nutrient List', 'kmag'), // formerly "element"
                        'product-type' => __('Product Type', 'kmag'), // formerly "badge"
                    ])
                    ->returnFormat('value')
                    ->instructions(__('Determines what is displayed in the icon section of the card', 'kmag')),
                ButtonGroup::make(__('Product Type', 'kmag'), 'product-type')
                    ->choices([
                        'nutrient-enhancer' => __('Nutrient Enhancer', 'kmag'),
                        'beneficial-input' => __('Beneficial Input', 'kmag'),
                    ])
                    ->conditionalLogic([ConditionalLogic::where('icon-section-variant', '==', 'product-type')])
                    ->returnFormat('value'),
                Relationship::make(__('Associated Nutrients', 'cropnutrition'), 'nutrients')
                    ->postTypes(['nutrients'])
                    ->conditionalLogic([ConditionalLogic::where('icon-section-variant', '==', 'nutrient-list')])
                    ->filters([
                        'search',
                    ]),
                Image::make(__('Product Image', 'kmag')),
                Text::make(__('Performance Product Slug', 'kmag')),
                ColorPicker::make(__('Background Color', 'kmag'), 'color'),
                ButtonGroup::make(__('Text Color', 'kmag'), 'text-color')
                    ->choices([
                        'light' => __('Light', 'kmag'),
                        'dark' => __('Dark', 'kmag'),
                    ])
                    ->defaultValue('dark'),
            ]
        );
    }
}
