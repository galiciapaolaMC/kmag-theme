<?php

namespace CN\App\Fields\Layouts;

use CN\App\Fields\Common;
use Extended\ACF\Fields\Image as WPImage;
use Extended\ACF\Fields\Layout;
use Extended\ACF\Fields\Link;
use Extended\ACF\Fields\Repeater;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\Textarea;

/**
 * Class AdvancedCNPlant
 *
 * @package CN\App\Fields\Layouts
 */
class AdvancedCNPlant extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'cn/layout/advanced-cn-plant',
            Layout::make(__('Advanced CN Plant', 'kmag'), 'advanced-cn-plant')
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                    Text::make(__('Main Headline', 'kmag'), 'main-headline'),
                    Textarea::make(__('Main Content', 'kmag'), 'main-content')
                        ->rows(3),
                    WPImage::make(__('Main Image', 'kmag'), 'main-image')
                        ->returnFormat('array'),
                    Textarea::make(__('K-Mag Content', 'kmag'), 'kmag-content')
                        ->rows(3),
                    WPImage::make(__('K-Mag Image', 'kmag'), 'kmag-image')
                        ->returnFormat('array')
                        ->wrapper([
                            'width' => '50'
                        ]),
                    Link::make(__('K-Mag Link', 'kmag'), 'kmag-link')
                        ->wrapper([
                            'width' => '50'
                        ]),
                    Textarea::make(__('Biosciences Content', 'kmag'), 'biosciences-content')
                        ->rows(3),
                    WPImage::make(__('Biosciences Image', 'kmag'), 'biosciences-image')
                        ->returnFormat('array')
                        ->wrapper([
                            'width' => '50'
                        ]),
                    Link::make(__('Biosciences Link', 'kmag'), 'biosciences-link')
                        ->wrapper([
                            'width' => '50'
                        ]),
                    $this->styleTab(),
                    Common::paddingGroup(DEFAULT_ADVANCED_CN_PLANT_PADDING)
                ])
        );
    }
}
