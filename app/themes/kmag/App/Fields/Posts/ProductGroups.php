<?php

namespace CN\App\Fields\Posts;

use Extended\ACF\Fields\Image;
use Extended\ACF\Fields\Number;
use Extended\ACF\Fields\PostObject;
use Extended\ACF\Fields\RadioButton;
use Extended\ACF\Fields\Textarea;
use Extended\ACF\Fields\WysiwygEditor;

/**
 * Class ProductGroups
 *
 * @package CN\App\Fields\Posts
 */
class ProductGroups
{
    /**
     * Defines fields used within Products post type.
     *
     * @return array
     */
    public function fields()
    {
        return apply_filters(
            'cn/posts/product-groups',
            [
                Number::make(__('Order', 'kmag')),
                RadioButton::make(__('Commodity Fertilizer', 'kmag'))
                    ->choices([
                        '0' => __('Yes', 'kmag'),
                        '1' => __('No', 'kmag')
                    ])
                    ->defaultValue('0')
                    ->returnFormat('value')
                    ->required(),
                Textarea::make(__('Excerpt', 'kmag'))
                    ->characterLimit(50000)
                    ->rows(2),
                Image::make(__('Product Image', 'kmag')),
                Textarea::make(__('Intro', 'kmag'))
                    ->characterLimit(50000)
                    ->rows(2)
                    ->required(),
                WysiwygEditor::make(__('Description', 'kmag'))
                    ->mediaUpload(false)
                    ->required(),
                PostObject::make(__('Products', 'kmag'))
                    ->postTypes(['products'])
                    ->allowMultiple()
            ]
        );
    }
}
