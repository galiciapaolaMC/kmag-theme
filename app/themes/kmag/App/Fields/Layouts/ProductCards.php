<?php

namespace CN\App\Fields\Layouts;

use CN\App\Fields\Common;
use Extended\ACF\ConditionalLogic;
use Extended\ACF\Fields\ButtonGroup;
use Extended\ACF\Fields\Layout;
use Extended\ACF\Fields\Relationship;
use Extended\ACF\Fields\TrueFalse;

/**
 * Class ProductCards
 *
 * @package CN\App\Fields\Layouts
 */
class ProductCards extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'cn/layout/product-cards',
            Layout::make(__('Product Cards', 'kmag'), 'product_cards')
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                    Relationship::make(__('Products', 'kmag'), 'products')
                        ->postTypes(['performance-products'])
                        ->filters([
                            'search',
                        ]),
                    ButtonGroup::make(__('Card Variant', 'kmag'), 'card-variant')
                        ->choices([
                            'tagline-and-description' => __('Tagline and Description', 'kmag'),
                            'classification' => __('Classification', 'kmag'),
                        ]),
                    TrueFalse::make(__('Secondary', 'kmag'), 'secondary')
                        ->defaultValue('0')
                        ->conditionalLogic([
                            ConditionalLogic::where('product_page', '==', 'performance')
                        ])
                        ->instructions(__('Is this a secondary product display?', 'kmag')),
                    $this->styleTab(),
                    Common::paddingGroup(DEFAULT_MEDIA_ASSET_BANNER_PADDING)
                ])
        );
    }
}
