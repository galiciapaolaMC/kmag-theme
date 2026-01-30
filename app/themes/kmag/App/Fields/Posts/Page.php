<?php

namespace CN\App\Fields\Posts;

use CN\App\Fields\Common;
use Extended\ACF\Fields\TextArea;

/**
 * Class Page
 *
 * @package CN\App\Fields\Posts
 */
class Page
{
    /**
     * Defines fields used within Page post type.
     *
     * @return array
     */
    public function fields()
    {
        return apply_filters(
            'cn/posts/page',
            [
                TextArea::make(__('Article Excerpt', 'kmag'))
                    ->wrapper([
                        'width' => '100'
                    ])
                    ->instructions(__('This text will display on the search results page.', 'kmag')),
            ]
        );
    }
}
