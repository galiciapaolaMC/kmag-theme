<?php

namespace CN\App\Fields\Posts;

use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\Image;
use Extended\ACF\Fields\File;
use Extended\ACF\Fields\Repeater;
use Extended\ACF\Fields\Textarea;
use Extended\ACF\Fields\WysiwygEditor;

/**
 * Class ProductLabel
 *
 * @package CN\App\Fields\Posts
 */
class ProductLabel
{
    /**
     * Defines fields used within ProductLabel post type.
     *
     * @return array
     */
    public function fields()
    {
        return apply_filters(
            'cn/posts/ProductLabel',
            [
                Image::make(__('Logo', 'kmag'), 'logo'),
                File::make(__('PDF', 'kmag'))
                    ->mimeTypes(['pdf'])
                    ->library('all'),
                Text::make(__('Crop Type', 'kmag'), 'crop-type')
                    ->required(),
                Repeater::make(__('Application List', 'kmag'), 'application-list')
                    ->fields([
                        Text::make(__('Content', 'kmag'), 'content'),
                    ]),
                Repeater::make(__('Improvement List', 'kmag'), 'improvement-list')
                    ->fields([
                        Image::make(__('Icon', 'kmag'), 'icon')
                            ->wrapper([
                                'width' => '25%',
                            ]),
                        Text::make(__('Content', 'kmag'), 'content')
                            ->wrapper([
                                'width' => '75%',
                            ]),
                    ]),
                Text::make(__('Volume', 'kmag'), 'volume')
                    ->wrapper([
                        'width' => '30%',
                    ]),
                Text::make(__('Density', 'kmag'), 'density')
                    ->wrapper([
                        'width' => '30%',
                    ]),
                Text::make(__('Net Weight', 'kmag'), 'net-weight')
                    ->wrapper([
                        'width' => '30%',
                    ]),
                WysiwygEditor::make(__('Benefits', 'kmag'), 'benefits')
                    ->mediaUpload(false),
                Repeater::make(__('Analysis Items', 'kmag'), 'analysis-items')
                    ->fields([
                        Text::make(__('Column 1', 'kmag'), 'column-1')
                            ->wrapper([
                                'width' => '50%',
                            ]),
                        Text::make(__('Column 2', 'kmag'), 'column-2')
                            ->wrapper([
                                'width' => '50%',
                            ]),
                    ])
                    ->required()
                    ->layout('block'),
                Text::make(__('Analysis  Bold Column 1', 'kmag'), 'analysis-bold-column-1')
                    ->wrapper([
                        'width' => '50%',
                    ]),
                Text::make(__('Analysis  Column 2', 'kmag'), 'analysis-bold-column-2')
                    ->wrapper([
                        'width' => '50%',
                    ]),
                WysiwygEditor::make(__('Storage', 'kmag'), 'storage')
                    ->mediaUpload(false),
                WysiwygEditor::make(__('Direction of use', 'kmag'), 'direction-of-use')
                    ->mediaUpload(false),
                Textarea::make(__('Health and Safety Label', 'kmag'), 'health-and-safety-label')
                    ->rows(2),
                WysiwygEditor::make(__('Health and Safety Content', 'kmag'), 'health-and-safety-content')
                    ->mediaUpload(false),
                WysiwygEditor::make(__('Warranty', 'kmag'), 'warranty')
                    ->mediaUpload(false),
            ]
        );
    }
}
