<?php

namespace CN\App\Fields\Layouts;

use CN\App\Fields\Common;
use Extended\ACF\Fields\Image as WPImage;
use Extended\ACF\Fields\Layout;
use Extended\ACF\Fields\Textarea;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\Image;
use Extended\ACF\Fields\Repeater;

/**
 * Class Bios
 *
 * @package CN\App\Fields\Layouts
 */
class Bios extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'cn/layout/bios',
            Layout::make(__('Bios', 'kmag'), 'bios')
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                    Repeater::make(__('Bio Items', 'kmag'), 'bio-items')
                        ->layout('block')
                        ->min(1)
                        ->buttonLabel(__('Add Bio'))
                        ->fields([
                            WPImage::make(__('Image', 'kmag'), 'image')
                                ->returnFormat('array'),
                            Text::make(__('Name', 'kmag'), 'name'),
                            Text::make(__('Title', 'kmag'), 'title'),
                            Textarea::make(__('Bio text', 'kmag'), 'bio-text'),
                        ]),
                    $this->styleTab(),
                    Common::paddingGroup(DEFAULT_BIOS_PADDING)
                ])
        );
    }
}
