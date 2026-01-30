<?php

namespace CN\App\Fields\Layouts;

use CN\App\Fields\Common;
use Extended\ACF\ConditionalLogic;
use Extended\ACF\Fields\ButtonGroup;
use Extended\ACF\Fields\Image;
use Extended\ACF\Fields\Layout;
use Extended\ACF\Fields\Link;
use Extended\ACF\Fields\Relationship;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\WysiwygEditor;

/**
 * Class ProductBanner
 *
 * @package CN\App\Fields\Layouts
 */
class ProductBanner extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'cn/layout/product-banner',
            Layout::make(__('Product Banner', 'kmag'), 'product-banner')
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                    ButtonGroup::make(__('Type', 'kmag'), 'type')
                        ->choices([
                            'full-width-text' => __('Full Width Text', 'kmag'),
                            'campaign-asset' => __('Campaign Asset', 'kmag')
                        ])
                        ->defaultValue('full-width-text')
                        ->wrapper([
                            'width' => '50'
                        ]),
                    ButtonGroup::make(__('Text Color', 'kmag'), 'text-color')
                        ->choices([
                            'white' => __('White', 'kmag'),
                            'black' => __('Black', 'kmag')
                        ])
                        ->defaultValue('black')
                        ->wrapper([
                            'width' => '50'
                        ]),
                    Image::make(__('Image', 'kmag'), 'image')
                        ->previewSize('thumbnail')
                        ->wrapper([
                            'width' => '50'
                        ])
                        ->conditionalLogic([
                            ConditionalLogic::where('type', '==', 'campaign-asset')
                        ]),
                    Image::make(__('Mobile Image', 'kmag'), 'mobile-image')
                        ->previewSize('thumbnail')
                        ->wrapper([
                            'width' => '50'
                        ])
                        ->conditionalLogic([
                            ConditionalLogic::where('type', '==', 'campaign-asset')
                        ]),
                    Text::make(__('Subtitle', 'kmag'), 'subtitle')
                        ->conditionalLogic([
                            ConditionalLogic::where('type', '==', 'campaign-asset')
                        ]),
                    WysiwygEditor::make(__('Content', 'kmag'), 'content')
                        ->mediaUpload(false),
                    Link::make(__('Source', 'kmag'), 'source'),
                    Relationship::make(__('Performance Products', 'kmag'), 'perfomance-product-banner')
                        ->postTypes(['performance-products'])
                        ->filters([
                            'search',
                            'taxonomy'
                        ])
                        ->min(1)
                        ->max(1)
                        ->required(),
                    $this->styleTab(),
                    Common::paddingGroup(DEFAULT_PRODUCT_BANNER_PADDING)
                ])
        );
    }
}
