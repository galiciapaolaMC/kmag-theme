<?php

namespace CN\App\Fields\Posts;

use CN\App\Fields\Layouts\Layouts;
use Extended\ACF\Fields\Group;
use Extended\ACF\Fields\Image;
use Extended\ACF\Fields\Repeater;
use Extended\ACF\Fields\Textarea;

/**
 * Class Crops
 *
 * @package CN\App\Fields\Posts
 */
class Crops extends Layouts
{
    /**
     * Defines fields used within Crop post type.
     *
     * @return array
     */
    public function fields()
    {
        return apply_filters(
            'cn/posts/crops',
            [
                $this->contentTab(),
                Image::make(__('Image 1 Mobile', 'kmag')),
                Image::make(__('Image 1 Desktop', 'kmag')),
                Image::make(__('Image 2 Mobile', 'kmag')),
                Image::make(__('Image 2 Desktop', 'kmag')),
                Image::make(__('Image 3 Mobile', 'kmag')),
                Image::make(__('Image 3 Desktop', 'kmag')),
                Image::make(__('Image 4 Mobile', 'kmag')),
                Image::make(__('Image 4 Desktop', 'kmag')),
                Image::make(__('Image 5 Mobile', 'kmag')),
                Image::make(__('Image 5 Desktop', 'kmag')),
                Group::make(__('Banner Images', 'kmag'), 'banner-images')
                    ->layout('block')
                    ->fields([
                        Repeater::make(__('Mobile', 'kmag'), 'mobile')
                            ->min(1)
                            ->layout('block')
                            ->fields([
                                Image::make(__('Image', 'kmag'), 'image-id'),
                            ]),
                        Repeater::make(__('Desktop', 'kmag'), 'desktop')
                            ->min(1)
                            ->layout('block')
                            ->fields([
                                Image::make(__('Image', 'kmag'), 'image-id'),
                            ])
                    ]),
                $this->relationshipsTab(),
                Textarea::make(__('Relationships JSON', 'kmag'))
                    ->characterLimit(50000)
                    ->rows(5)
                    ->defaultValue('{}'),
            ]
        );
    }
}
