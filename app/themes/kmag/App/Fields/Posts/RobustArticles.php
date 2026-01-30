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
 * Class RobustArticles
 *
 * @package CN\App\Fields\Posts
 */
class RobustArticles
{
    /**
     * Defines fields used within RobustArticles post type.
     *
     * @return array
     */
    public function fields()
    {
        return apply_filters(
            'cn/posts/RobustArticles',
            [
                Image::make(__('Preview Image', 'kmag')),
                Image::make(__('Hero Image', 'kmag'))
                    ->wrapper([
                        'width' => '50'
                    ]),
                Image::make(__('Hero Image Mobile', 'kmag'))
                    ->wrapper([
                        'width' => '50'
                    ]),
                Text::make(__('Contentful Import ID', 'kmag'))
                    ->instructions(__('This field is only used for importing from contentful data', 'kmag')),
                TextArea::make(__('Article Intro', 'kmag'))
                    ->wrapper([
                        'width' => '50'
                    ]),
                TextArea::make(__('Article Excerpt', 'kmag'))
                    ->wrapper([
                        'width' => '50'
                    ])
                    ->instructions(__('This text will display on the search results page.', 'kmag')),
                WysiwygEditor::make(__('Article Body', 'kmag')),
                Common::authorFields(),
            ]
        );
    }
}
