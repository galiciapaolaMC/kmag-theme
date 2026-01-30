<?php

namespace CN\App\Fields\Posts;

use CN\App\Fields\Common;
use Extended\ACF\Fields\File;
use Extended\ACF\Fields\Repeater;
use Extended\ACF\Fields\Taxonomy;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\Textarea;
use Extended\ACF\Fields\TrueFalse;
use Extended\ACF\Fields\WysiwygEditor;

/**
 * Class Agrisights
 *
 * @package CN\App\Fields\Posts
 */
class Agrisights
{
    /**
     * Defines fields used within Products post type.
     *
     * @return array
     */
    public function fields()
    {
        return apply_filters(
            'cn/posts/agrisights',
            [
                Text::make(__('Issue number', 'kmag'), 'issue-number'),
                File::make(__('Agrisights PDF', 'kmag'), 'agrisights-pdf')
                    ->mimeTypes(['pdf'])
                    ->library('all'),
                Repeater::make(__('Fact List', 'kmag'), 'fact-list')
                    ->layout('block')
                    ->fields([
                        Textarea::make(__('Fact', 'kmag'), 'fact')
                            ->rows(2)
                    ]),
                WysiwygEditor::make(__('Article Introduction', 'kmag'), 'article-introduction'),
                WysiwygEditor::make(__('Article Body', 'kmag'), 'article-body'),
            ]
        );
    }
}
