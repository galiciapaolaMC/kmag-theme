<?php

namespace CN\App\Fields\Posts;

use CN\App\Fields\Common;
use Extended\ACF\Fields\File;
use Extended\ACF\Fields\Image;
use Extended\ACF\Fields\Taxonomy;
use Extended\ACF\Fields\TextArea;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\TrueFalse;
use Extended\ACF\Fields\Select;
use Extended\ACF\Fields\WysiwygEditor;
use Extended\ACF\Fields\Repeater;
use Extended\ACF\Fields\Group;

/**
 * Class StandardArticles
 *
 * @package CN\App\Fields\Posts
 */
class StandardArticles
{
    /**
     * Defines fields used within StandardArticles post type.
     *
     * @return array
     */
    public function fields()
    {
        return apply_filters(
            'cn/posts/standard-articles',
            [
                Text::make(__('Contentful Import ID', 'kmag'))
                    ->instructions(__('This field is only used for importing from contentful data', 'kmag')),
                TextArea::make(__('Article Excerpt', 'kmag'))->instructions(__('This text will display on the search results page.', 'kmag')),
                Text::make(__('Article Title', 'kmag'), 'article_title'),
                Text::make(__('Author ID', 'kmag'), 'author_id')
                    ->instructions(__('The ID from contentful exports (optional)', 'kmag')),
                WysiwygEditor::make(__('Article Body', 'kmag'), 'article_body'),
                Repeater::make(__('Inline Images', 'kmag'), 'inline_images')
                    ->fields([
                        Image::make(__('Image', 'kmag')),
                        Text::make(__('Caption', 'kmag'))
                    ]),
                Text::make(__('Author Name', 'kmag'), 'author_name')->wrapper([
                    'width' => '50'
                ]),
                Text::make(__('Author Title', 'kmag'), 'author_title')->wrapper([
                    'width' => '50'
                ]),
                Common::gatedContentFields(),
                Common::scoredContentFields()
            ]
        );
    }
}
