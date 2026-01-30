<?php

namespace CN\App\Fields\Layouts;

use CN\App\Fields\Common;
use Extended\ACF\Fields\Layout;
use Extended\ACF\Fields\TextArea;
use Extended\ACF\Fields\Group;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\Link;
use Extended\ACF\Fields\Image;
use Extended\ACF\Fields\Number;
use Extended\ACF\Fields\Select;

/**
 * Class ProductPanel
 *
 * @package CN\App\Fields\Layouts
 */
class ProductPanel extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'cn/layout/product-panel',
            Layout::make(__('Product Panel', 'kmag'), 'product-panel')
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                    Text::make(__('Name', 'kmag'))
                     ->wrapper([
                            'width' => '50'
                        ]),
                    Image::make(__('Logo', 'kmag'))
                        ->wrapper([
                            'width' => '50'
                        ]),
                    Textarea::make(__('Tagline', 'kmag'))
                        ->characterLimit(500)
                        ->rows(2),
                    Image::make(__('Product Image', 'kmag')),
                    Link::make(__('Button', 'kmag'), 'panel-source'),
                    $this->optionsTab(),
                    Select::make(__('Background Color', 'kmag'), 'background-color')
                        ->choices([
                            'biopath' => __('Biopath Blue', 'kmag'),
                            'microessentials' => __('Microessentials Yellow', 'kmag'),
                            'aspire' => __('Aspire Green', 'kmag'),
                             'k-mag' => __('K-Mag Red', 'kmag'),
                             'pegasus' => __('Pegasus  Blue', 'kmag'),
                        ])
                        ->defaultValue('primary')
                        ->returnFormat('value'),
                  
                    $this->styleTab(),
                    Common::paddingGroup(DEFAULT_PRODUCT_BANNER_PADDING)
                ])
        );
    }
}