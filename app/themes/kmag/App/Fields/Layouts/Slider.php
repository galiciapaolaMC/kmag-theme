<?php

namespace CN\App\Fields\Layouts;

use CN\App\Fields\Common;
use Extended\ACF\ConditionalLogic;
use Extended\ACF\Fields\ButtonGroup;
use Extended\ACF\Fields\File;
use Extended\ACF\Fields\Image;
use Extended\ACF\Fields\Layout;
use Extended\ACF\Fields\Oembed;
use Extended\ACF\Fields\Repeater;
use Extended\ACF\Fields\Textarea;

/**
 * Class Slider
 *
 * @package CN\App\Fields\Layouts
 */
class Slider extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'cn/layout/slider',
            Layout::make(__('Slider', 'kmag'), 'slider')
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                    Repeater::make(__('Items', 'kmag'), 'items')
                        ->min(1)
                        ->layout('block')
                        ->fields([
                            ButtonGroup::make(__('Media Type', 'kmag'), 'media-type')
                                ->choices([
                                    'image' => __('Image', 'kmag'),
                                    'video' => __('Video', 'kmag'),
                                ])
                                ->defaultValue('image'),
                            Image::make(__('Image', 'kmag'), 'image')
                                ->returnFormat('array')
                                ->conditionalLogic([
                                    ConditionalLogic::where('media-type', '==', 'image')
                                ]),
                            Oembed::make(__('Video Link', 'kmag'), 'video-link')
                                ->wrapper([
                                    'width' => '50'
                                ])
                                ->conditionalLogic([
                                    ConditionalLogic::where('media-type', '==', 'video')
                                ]),
                            Image::make(__('Preview Image', 'kmag'), 'preview-image')
                                ->returnFormat('array')
                                ->wrapper([
                                    'width' => '50'
                                ])
                                ->conditionalLogic([
                                    ConditionalLogic::where('media-type', '==', 'video')
                                ]),
                            Textarea::make(__('Description', 'kmag'), 'description')
                                ->rows(2)
                        ]),
                    $this->styleTab(),
                    Common::paddingGroup(DEFAULT_SLIDER_PADDING)
                ])
        );
    }
}