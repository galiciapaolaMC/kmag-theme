<?php

namespace CN\App\Fields\Layouts;

use CN\App\Fields\Common;
use Extended\ACF\Fields\Image as WPImage;
use Extended\ACF\Fields\Range;
use Extended\ACF\Fields\Layout;
use Extended\ACF\Fields\RadioButton;

/**
 * Class Image
 *
 * @package CN\App\Fields\Layouts
 */
class FullWidthGraphic extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'cn/layout/full-width-graphic',
            Layout::make(__('Full Width Graphic', 'kmag'), 'full-width-graphic')
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                    WPImage::make(__('Graphic', 'kmag'), 'graphic')
                        ->returnFormat('array'),
                    Range::make(__('Width', 'kmag'), 'width')
                        ->min(0)
                        ->max(100)
                        ->step(10)
                        ->DefaultValue(100)
                        ->append('%'),
                    $this->optionsTab(),
                    RadioButton::make(__('Dynamic Display', 'kmag'), 'dynamic-display')
                        ->choices([
                            'none' => __('None', 'kmag'),
                            'show-with-region-crop' => __('Show With Region Crop', 'kmag'),
                            'hide-with-region-crop' => __('Hide With Region Crop', 'kmag'),
                        ])
                        ->defaultValue('none')
                        ->instructions('Make the section dynamic based on whether the Region Crop have been selected. Show With Region Crop will show the section when Region Crop is selected and hide it otherwise.', 'kmag'),
                    $this->styleTab(),
                    Common::paddingGroup(DEFAULT_FULLWIDTHGRAPHIC_PADDING)
                ])
        );
    }
}
