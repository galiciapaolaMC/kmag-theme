<?php

namespace CN\App\Fields\Layouts;

use CN\App\Fields\Common;
use Extended\ACF\Fields\ButtonGroup;
use Extended\ACF\Fields\File;
use Extended\ACF\Fields\Image as WPImage;
use Extended\ACF\Fields\Oembed;
use Extended\ACF\Fields\Layout;
use Extended\ACF\ConditionalLogic;

/**
 * Class Video
 *
 * @package CN\App\Fields\Layouts
 */
class Video extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'cn/layout/video',
            Layout::make(__('Video', 'kmag'), 'video')
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                    ButtonGroup::make(__('Type', 'kmag'), 'type')
                        ->choices([
                            'link' => __('Link', 'kmag'),
                            'file' => __('File', 'kmag')
                        ])
                        ->defaultValue('link'),
                    Oembed::make(__('Video Link', 'kmag'), 'video-link')
                        ->conditionalLogic([
                            ConditionalLogic::where('type', '==', 'link')
                        ]),
                    File::make(__('Video File', 'kmag'), 'video-file')
                        ->wrapper([
                            'width' => '50'
                        ])
                        ->conditionalLogic([
                            ConditionalLogic::where('type', '==', 'file')
                        ]),
                    WPImage::make(__('Preview Image', 'kmag'), 'preview-image')
                        ->returnFormat('array')
                        ->wrapper([
                            'width' => '50'
                        ])
                        ->conditionalLogic([
                            ConditionalLogic::where('type', '==', 'file')
                        ]),
                    $this->styleTab(),
                    Common::paddingGroup(DEFAULT_VIDEO_PADDING)
                ])
        );
    }
}
