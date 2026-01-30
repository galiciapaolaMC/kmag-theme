<?php

namespace CN\App\Fields\Posts;

use CN\App\Fields\Common;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\WysiwygEditor;
use Extended\ACF\Fields\Repeater;
use Extended\ACF\Fields\File;

/**
 * Class DirectionsForUse
 *
 * @package CN\App\Fields\Directions
 */
class DirectionsForUse
{
    /**
     * Defines fields used within DirectionsForUse post type.
     *
     * @return array
     */
    public function fields()
    {
        return apply_filters(
            'cn/posts/directions-for-use',
            [
                Text::make(__('Contentful Import ID', 'kmag'))
                    ->instructions(__('This field is only used for importing from contentful data', 'kmag')),
                Text::make(__('Product Name', 'kmag'), 'product_name'),
                Text::make(__('Issue Date/Code', 'kmag'), 'issue_date')->wrapper(['width' => '50']),
                Text::make(__('Revision', 'kmag'), 'revision')->wrapper(['width' => '50']),
                File::make(__('Upload PDF', 'kmag'), 'file_url')
                    ->mimeTypes(['pdf']),
                Repeater::make(__('Details', 'kmag'), 'details')
                    ->fields([
                        Text::make(__('Crop', 'kmag')),
                        Text::make(__('Product Application Rate (Ibs/ac)', 'kmag'), 'product_application'),
                        Text::make(__('B Rate (Ibs/ac)', 'kmag'), 'b_rate'),
                        Text::make(__('Maximum B Application for Season (Ibs/ac)', 'kmag'), 'max_b_app'),
                        Text::make(__('Method', 'kmag'), 'method')
                    ])
                    ->buttonLabel(__('Add more', 'kmag'))
                    ->layout('table'),
                WysiwygEditor::make(__('Warning', 'kmag'))->mediaUpload(false),
            ]
        );
    }
}
