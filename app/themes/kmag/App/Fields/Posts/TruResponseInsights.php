<?php

namespace CN\App\Fields\Posts;

use CN\App\Fields\Common;
use Extended\ACF\Fields\ButtonGroup;
use Extended\ACF\Fields\File;
use Extended\ACF\Fields\Repeater;
use Extended\ACF\Fields\TextArea;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\WysiwygEditor;

/**
 * Class TruResponseInsights
 *
 * @package CN\App\Fields\Posts
 */
class TruResponseInsights
{
    /**
     * Defines fields used within TruResponseInsights post type.
     *
     * @return array
     */
    public function fields()
    {
        return apply_filters(
            'cn/posts/trures-insights',
            [
                Text::make(__('Issue Number', 'kmag'), 'issue-number'),
                File::make(__('Insights PDF', 'kmag'), 'insights-pdf')
                    ->mimeTypes(['pdf'])
                    ->library('all'),
                WysiwygEditor::make(__('Article Intro', 'kmag'), 'article-intro'),
                Repeater::make(__('Bullet List', 'kmag'), 'bullet-list')
                    ->layout('block')
                    ->fields([
                        Textarea::make(__('Fact', 'kmag'), 'fact')
                            ->rows(2)
                    ]),
                WysiwygEditor::make(__('Article Body', 'kmag'), 'article-body'),
                ButtonGroup::make(__('Activate Trial Data', 'kmag'), 'activate-trial-data')
                    ->choices([
                        'active' => __('Active', 'kmag'), 
                        'inactive' => __('Inactive', 'kmag')
                    ]),
            ]
        );
    }
}
