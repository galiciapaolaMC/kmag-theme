<?php

namespace CN\App\Fields\Posts;

use Extended\ACF\Fields\File;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\Image;
use Extended\ACF\Fields\Repeater;
use Extended\ACF\Fields\Textarea;

/**
 * Class MaterialCompatibility
 *
 * @package CN\App\Fields\Posts
 */
class Material
{
    /**
     * Defines fields used within Material Compatibility post type.
     *
     * @return array
     */
    public function fields()
    {
        return apply_filters(
            'cn/posts/material',
            [
                Image::make(__('Hero', 'kmag'), 'hero')
                    ->returnFormat('array')
                    ->wrapper(['width' => '50']),
                Image::make(__('Logo', 'kmag'), 'logo')
                    ->returnFormat('array')
                    ->wrapper(['width' => '50']),
                File::make(__('PDF', 'kmag'))
                    ->mimeTypes(['pdf'])
                    ->library('all'),
                Textarea::make(__('Introduction', 'kmag'), 'introduction')
                    ->rows(3),
                Text::make(__('Table Name', 'kmag'), 'table-name'),
                Repeater::make(__('Table Headers', 'kmag'), "table-headers")
                    ->min(3)
                    ->max(3)
                    ->required()
                    ->fields([
                        Text::make(__('Name', 'kmag'), 'name'),
                    ])
                    ->layout('block'),
                Repeater::make(__('Table Items', 'kmag'), 'table-items')
                    ->min(1)
                    ->fields([
                        Text::make(__('Section Name', 'kmag'), 'section-name'),

                        Repeater::make(__('Table Rows', 'kmag'), 'table-rows')
                            ->fields([
                                Text::make(__('Column 1', 'kmag'), 'column-1'),
                                Text::make(__('Column 2', 'kmag'), 'column-2'),
                                Text::make(__('Column 3', 'kmag'), 'column-3'),
                            ]),
                    ])
                    ->required()
                    ->layout('block'),
                
            ]
        );
    }
}
