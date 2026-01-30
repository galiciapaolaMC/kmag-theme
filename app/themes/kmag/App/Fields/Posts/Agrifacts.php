<?php

namespace CN\App\Fields\Posts;

use CN\App\Fields\Common;
use Extended\ACF\Fields\DatePicker;
use Extended\ACF\Fields\File;
use Extended\ACF\Fields\Image;
use Extended\ACF\Fields\Taxonomy;
use Extended\ACF\Fields\TextArea;
use Extended\ACF\Fields\TrueFalse;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\WysiwygEditor;

/**
 * Class Agrifacts
 *
 * @package CN\App\Fields\Posts
 */
class Agrifacts
{
    /**
     * Defines fields used within Agrifacts post type.
     *
     * @return array
     */
    public function fields()
    {
        return apply_filters(
            'cn/posts/agrifacts',
            [
                Text::make(__('Contentful Import ID', 'kmag'))
                    ->instructions(__('This field is only used for importing from contentful data', 'kmag')),
                TextArea::make(__('Article Intro', 'kmag'))
                    ->wrapper([
                        'width' => '50'
                    ])
                    ->instructions(__('Enter the objective of the agrifact', 'kmag')),
                TextArea::make(__('Article Excerpt', 'kmag'))
                    ->wrapper([
                        'width' => '50'
                    ])
                    ->instructions(__('This text will display on the search results page.', 'kmag')),
                DatePicker::make(__('Study Date', 'kmag'))->wrapper([
                    'width' => '25'
                ]),
                Text::make(__('Study Code', 'kmag'))->wrapper([
                    'width' => '25'
                ])->placeholder(__('Eg: 30 CWT/AC', 'kmag')),
                Text::make(__('Study Topic', 'kmag'))->wrapper([
                    'width' => '50'
                ])->placeholder(__('Eg: Increased yield with MicroEssentials SZ over MAP', 'kmag')),
                WysiwygEditor::make(__('Article Body', 'kmag')),
                Text::make(__('Trial Years', 'kmag'))
                    ->wrapper([
                        'width' => '50'
                    ]),
                Text::make(__('Number of Trials', 'kmag'))
                    ->wrapper([
                        'width' => '50'
                    ]),
                Text::make(__('Fertilizer Comparison', 'kmag')),
                TextArea::make(__('Yield Stats', 'kmag')),
                File::make(__('Agrifact PDF', 'kmag'))
                    ->instructions(__('Add the menu <strong>pdf</strong> file.', 'kmag'))
                    ->mimeTypes(['pdf'])
                    ->library('all'),
                TextArea::make(__('Disclaimer', 'kmag'))
                    ->wrapper([
                        'width' => '50'
                    ]),
                    Common::gatedContentFields(),
                    Common::scoredContentFields()
            ]
        );
    }
}
