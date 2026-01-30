<?php

namespace CN\App\Fields\Posts;

use CN\App\Fields\Common;
use Extended\ACF\Fields\Text;

/**
 * Class FarmerProfiles
 *
 * @package CN\App\Fields\Posts
 */
class FarmerProfiles
{
    /**
     * Defines fields used within StandardArticles post type.
     *
     * @return array
     */
    public function fields()
    {
        return apply_filters(
            'cn/posts/farmer-profiles',
            [
                Text::make(__('Location', 'kmag'), 'location'),
                Common::moduleList(),
            ]
            );
    }
}