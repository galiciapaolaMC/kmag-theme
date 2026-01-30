<?php

namespace CN\App\Fields\Posts;

use CN\App\Fields\Common;
use Extended\ACF\Fields\File;
use Extended\ACF\Fields\Image;
use Extended\ACF\Fields\Taxonomy;
use Extended\ACF\Fields\TextArea;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\TrueFalse;
use Extended\ACF\Fields\DatePicker;
use Extended\ACF\Fields\WysiwygEditor;
use Extended\ACF\Fields\Link;
use Extended\ACF\Fields\Repeater;

/**
 * Class BlogArticles
 *
 * @package CN\App\Fields\Posts
 */
class GHSLabel
{
    /**
     * Defines fields used within BlogArticles post type.
     *
     * @return array
     */
    public function fields()
    {
        return apply_filters(
            'cn/posts/ghs-label',
            [
                Text::make(__('Chemical/ Compound Name', 'kmag'), 'compound_name'),
                Text::make(__('Product Name', 'kmag'), 'product_name'),
                Text::make(__('Issue Date', 'kmag'), 'issue_date')->wrapper([
                    'width' => '50'
                ]),
                Text::make(__('Revision', 'kmag'), 'revision')->wrapper([
                    'width' => '50'
                ]),
                File::make(__('Upload PDF', 'kmag'), 'file_url')
                    ->mimeTypes(['pdf'])->wrapper([
                        'width' => '50'
                    ]),
                File::make(__('Warning Logo', 'kmag'), 'warning_logo')
                    ->mimeTypes(['jpeg', 'jpg', 'png'])->wrapper([
                        'width' => '50'
                    ]),
                Repeater::make(__('Statements', 'kmag'))
                    ->fields([
                        Text::make(__('Statement Title', 'kmag'), 'statement_title'),
                        WysiwygEditor::make(__('Statement Body', 'kmag'), 'statement_body')
                            ->mediaUpload(false)
                    ])->buttonLabel(__('Add Statements', 'kmag'))
                    ->layout('table'),
                WysiwygEditor::make(__('Company Address', 'kmag')),
                Common::gatedContentFields(),
                Common::scoredContentFields()
            ]
        );
    }
}
