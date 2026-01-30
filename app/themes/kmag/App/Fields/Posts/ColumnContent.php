<?php

namespace CN\App\Fields\Posts;

use Extended\ACF\Fields\File;
use Extended\ACF\Fields\Image;
use Extended\ACF\Fields\TextArea;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\Repeater;

/**
 * Class ColumnContent
 *
 * @package CN\App\Fields\Posts
 */
class ColumnContent
{
    /**
     * Defines fields used within ColumnContent post type.
     *
     * @return array
     */
    public function fields()
    {
        return apply_filters(
            'cn/posts/column-content',
            [
                Text::make(__('Heading', 'kmag')),
                Text::make(__('Sub Heading', 'kmag')),
                TextArea::make(__('Description', 'kmag')),
                Image::make(__('Image', 'kmag')),
                Repeater::make(__('Contents', 'kmag'))
                    ->fields([
                        Text::make(__('Content Title', 'kmag')),
                        Repeater::make(__('Document', 'kmag'))
                            ->fields([
                                Text::make(__('Label', 'kmag')),
                                File::make(__('File', 'kmag'))
                                    ->library('all'),
                            ])
                            ->buttonLabel(__('Add More', 'kmag'))
                            ->layout('table')
                    ])
                    ->buttonLabel(__('Add More', 'kmag'))
                    ->layout('table')
            ]
        );
    }
}
