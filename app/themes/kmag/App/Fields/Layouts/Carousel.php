<?php

namespace CN\App\Fields\Layouts;

use CN\App\Fields\Common;
use Extended\ACF\Fields\ButtonGroup;
use Extended\ACF\Fields\Image as WPImage;
use Extended\ACF\Fields\Layout;
use Extended\ACF\Fields\Repeater;
use Extended\ACF\Fields\Select;

/**
 * Class Carousel
 *
 * @package CN\App\Fields\Layouts
 */
class Carousel extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'cn/layout/carousel',
            Layout::make(__('Carousel'), 'carousel')
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                    Repeater::make(__('Carousel Items'))
                        ->layout('block')
                        ->min(1)
                        ->buttonLabel(__('Add Item'))
                        ->fields([
                            WPImage::make('Image')
                                ->returnFormat('array'),
                        ]),
                    $this->optionsTab(),
                    Select::make(__('Animation Type', 'kmag'), 'carousel-animation-type')
                        ->choices([
                            'fade'  => __('Fade', 'kmag'),
                            'pull'  => __('Pull', 'kmag'),
                            'push'  => __('Push', 'kmag'),
                            'scale' => __('Scale', 'kmag'),
                            'slide' => __('Slide', 'kmag'),
                        ])
                        ->defaultValue('slide')
                        ->returnFormat('value')
                        ->wrapper([
                            'width' => '33.33'
                        ]),
                    ButtonGroup::make(__('Enable Arrow Navigation', 'kmag'), 'show-carousel-arrows-nav')
                        ->choices([
                            'true'  => __('Enable', 'kmag'),
                            'false' => __('Disable', 'kmag'),
                        ])
                        ->instructions(__('Enabling will show a previous and next navigation arrow overlayed on the carousel.', 'kmag'))
                        ->defaultValue('true')
                        ->wrapper([
                            'width' => '33.33'
                        ]),
                    ButtonGroup::make(__('Enable Indicators', 'kmag'), 'show-carousel-indicators')
                        ->choices([
                            'true'  => __('Enable', 'kmag'),
                            'false' => __('Disable', 'kmag'),
                        ])
                        ->instructions(__('Enabling will show a dot navigation button group.', 'kmag'))
                        ->defaultValue('false')
                        ->wrapper([
                            'width' => '33.33'
                        ]),
                    $this->styleTab(),
                    Common::paddingGroup(DEFAULT_CAROUSEL_PADDING)
                ])
        );
    }
}
