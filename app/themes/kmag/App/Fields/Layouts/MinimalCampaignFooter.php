<?php
namespace CN\App\Fields\Layouts;

use CN\App\Fields\Common;
use Extended\ACF\Fields\Layout;
use Extended\ACF\Fields\Image;

/**
 * Class MinimalCampaignFooter
 *
 * @package CN\App\Fields\Layouts
 */
class MinimalCampaignFooter extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'cn/layout/minimal-campaign-footer',
            Layout::make(__('Minimal Campaign Footer', 'kmag'), 'minimal-campaign-footer')
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                    Image::make(__('Logo', 'kmag'), 'logo')
                      ->required(),    
                ]),
                $this->styleTab(),
                Common::paddingGroup(DEFAULT_MINIMAL_CAPAIGN_FOOTER_PADDING)
        );
    }
}


?>