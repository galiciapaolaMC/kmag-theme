<?php

namespace CN\App\Fields\Posts;

use Extended\ACF\Fields\File;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\WysiwygEditor;

/**
 * Class Products
 *
 * @package CN\App\Fields\Posts
 */
class Products
{
    /**
     * Defines fields used within Products post type.
     *
     * @return array
     */
    public function fields()
    {
        return apply_filters(
            'cn/posts/products',
            [
                Text::make(__('Name', 'kmag')),
                Text::make(__('Chemical Composition', 'kmag')),
                WysiwygEditor::make(__('Description', 'kmag'))
                    ->mediaUpload(false),
                File::make(__('Safety Data Sheet', 'kmag')),
                File::make(__('Product Labels', 'kmag')),
                File::make(__('Data Sheet', 'kmag'))
            ]
        );
    }
}
