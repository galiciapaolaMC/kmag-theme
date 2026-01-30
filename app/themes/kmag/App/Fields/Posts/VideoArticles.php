<?php

namespace CN\App\Fields\Posts;

use CN\App\Fields\Common;
use Extended\ACF\ConditionalLogic;
use Extended\ACF\Fields\File;
use Extended\ACF\Fields\PostObject;
use Extended\ACF\Fields\RadioButton;
use Extended\ACF\Fields\Repeater;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\TextArea;
use Extended\ACF\Fields\TrueFalse;
use Extended\ACF\Fields\WysiwygEditor;

/**
 * Class VideoDetails
 *
 * @package CN\App\Fields\Posts
 */
class VideoArticles
{
    /**
     * Defines fields used within VideoDetail post type.
     *
     * @return array
     */
    public function fields()
    {
        return apply_filters(
            'cn/posts/video-articles',
            [
                Text::make(__('Contentful Import ID', 'kmag'))
                    ->instructions(__('This field is only used for importing from contentful data', 'kmag')),
                Text::make(__('Article Header', 'kmag'), 'article_header')
                    ->wrapper([
                        'width' => '50'
                    ]),
                RadioButton::make(__('Article Type', 'kmag'), 'article_type')
                    ->choices([
                        'video' => 'Video',
                        'audio' => 'Audio'
                    ])
                    ->wrapper([
                        'width' => '50'
                    ])
                    ->defaultValue('video')
                    ->layout('horizontal'),
                RadioButton::make(__('Video Platform', 'kmag'), 'video-platform')
                    ->choices([
                        'youtube' => 'Youtube',
                        'vimeo' => 'Vimeo'
                    ])
                    ->defaultValue('vimeo'),
                Text::make(__('Article Video Id', 'kmag'), 'video_id')
                    ->wrapper([
                        'width' => '50'
                    ])
                    ->instructions(__("Youtube or Vimeo embed ID", 'kmag')),
                File::make(__('Trending Preview', 'kmag'), 'video_preview')
                    ->mimeTypes(['png', 'jpg', 'jpeg'])
                    ->wrapper([
                        'width' => '50'
                    ])
                    ->instructions(__("Resource page feature image", 'kmag')),
                WysiwygEditor::make(__('Article Body', 'kmag'), 'article_body'),
            ]
        );
    }
}
