<?php

namespace CN\App\Fields\Posts;

use CN\App\Fields\Common;
use Extended\ACF\Fields\File;
use Extended\ACF\Fields\Image;
use Extended\ACF\Fields\Taxonomy;
use Extended\ACF\Fields\TextArea;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\WysiwygEditor;

/**
 * Class BlogArticles
 *
 * @package CN\App\Fields\Posts
 */
class SuccessStory
{
    /**
     * Defines fields used within BlogArticles post type.
     *
     * @return array
     */
    public function fields()
    {
        return apply_filters(
            'cn/posts/success-story',
            [
                Text::make(__('Contentful Import ID', 'kmag'))
                    ->instructions(__('This field is only used for importing from contentful data', 'kmag')),
                Text::make(__('Article Title', 'kmag'), 'article_title'),
                WysiwygEditor::make(__('Article Body', 'kmag'), 'article_body'),
                Common::gatedContentFields(),
                Common::scoredContentFields()
            ]
        );
    }
}
