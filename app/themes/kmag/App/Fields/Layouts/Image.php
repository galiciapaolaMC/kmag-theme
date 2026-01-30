<?php

namespace CN\App\Fields\Layouts;

use CN\App\Fields\Common;
use Extended\ACF\Fields\Image as WPImage;
use Extended\ACF\Fields\Layout;

/**
 * Class Image
 *
 * @package CN\App\Fields\Layouts
 */
class Image extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'cn/layout/image',
            Layout::make('Image')
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                    WPImage::make('Image')
                        ->returnFormat('array'),
                    $this->styleTab(),
                    Common::paddingGroup(DEFAULT_IMAGE_PADDING)
                ])
        );
    }
}
