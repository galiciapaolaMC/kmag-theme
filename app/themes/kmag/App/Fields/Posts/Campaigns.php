<?php

namespace CN\App\Fields\Posts;

use CN\App\Fields\Common;
use Extended\ACF\Fields\DatePicker;
use Extended\ACF\Fields\File;
use Extended\ACF\Fields\Image;
use Extended\ACF\Fields\Taxonomy;
use Extended\ACF\Fields\TextArea;
use Extended\ACF\Fields\TrueFalse;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\WysiwygEditor;

/**
 * Class Campaigns
 *
 * @package CN\App\Fields\Posts
 */
class Campaigns
{
    /**
     * Defines fields used within Campaigns post type.
     *
     * @return array
     */
    public function fields()
    {
        return apply_filters(
            'cn/posts/campaigns',
            [
                Text::make(__('Campaign ID', 'kmag'), 'campaign-id')
                    ->instructions(__('The Campaign ID that is found in Salesforce', 'kmag')),
            ]
        );
    }
}
