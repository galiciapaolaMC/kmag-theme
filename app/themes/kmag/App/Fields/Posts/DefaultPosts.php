<?php

namespace CN\App\Fields\Posts;

use CN\App\Fields\Common;
use Extended\ACF\Fields\TrueFalse;
use Extended\ACF\Fields\TextArea;

/**
 * Class Default Posts
 *
 * @package CN\App\Fields\Posts
 */
class DefaultPosts
{
    /**
     * Defines fields used within Default post type.
     *
     * @return array
     */
    public function fields()
    {
        return apply_filters(
            'cn/posts/default-posts',
            [
                Common::gatedContentFields(),
                Common::scoredContentFields()
            ]
        );
    }
}
