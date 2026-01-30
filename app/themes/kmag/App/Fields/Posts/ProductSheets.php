<?php

namespace CN\App\Fields\Posts;

use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\Image;
use Extended\ACF\Fields\File;
use Extended\ACF\Fields\Repeater;
use Extended\ACF\Fields\Textarea;
use Extended\ACF\Fields\WysiwygEditor;

/**
 * Class ProductSheets
 *
 * @package CN\App\Fields\Posts
 */
class ProductSheets
{
    /**
     * Defines fields used within ProductSheets post type.
     *
     * @return array
     */
    public function fields()
    {
        return apply_filters(
            'cn/posts/ProductSheets',
            [
                Text::make(__('Contentful Import ID', 'kmag'))
                    ->instructions(__('This field is only used for importing from contentful data', 'kmag')),
                File::make(__('PDF File', 'kmag'), 'pdf_file')->wrapper([
                    'width' => '50'
                ])->mimeTypes(['pdf']),
                Image::make(__('Sheet Banner', 'kmag'), 'sheet_banner'),
                Text::make(__('Product Name', 'kmag'), 'product_name'),
                Text::make(__('Cited Date/Issue Code', 'kmag'), 'cited_date')->wrapper([
                    'width' => '50'
                ]),
                Text::make(__('Cited Revision', 'kmag'), 'cited_revision')->wrapper([
                    'width' => '50'
                ]),
                WysiwygEditor::make(__('Product Description', 'kmag'), 'product_description'),
                Repeater::make(__('FEATURES & BENEFITS', 'kmag'), "features_benefits")
                    ->fields([
                        Text::make(__('Point', 'kmag'), 'point'),
                    ])->layout('block'),
                Repeater::make(__('TECHNOLOGY AT WORK', 'kmag'), "technology_at_work")
                    ->fields([
                        Text::make(__('Point', 'kmag'), 'point'),
                    ])->layout('block'),
                Repeater::make(__('PRODUCT PROFILE', 'kmag'), "product_profile")
                    ->fields([
                        Textarea::make(__('Title', 'kmag'), 'title'),
                        Textarea::make(__('Content', 'kmag'), 'content'),
                    ])->layout('block'),
                Repeater::make(__('APPLICATION', 'kmag'), 'application')
                    ->fields([
                        Textarea::make(__('Title', 'kmag'), 'title'),
                        Textarea::make(__('Content', 'kmag'), 'content'),
                    ])->layout('block'),
                Textarea::make(__('Notice', 'kmag'))->rows(2),
                Textarea::make(__('Disclaimer', 'kmag'))->rows(5),
            ]
        );
    }
}