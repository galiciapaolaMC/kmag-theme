<?php

namespace CN\App\Fields\Layouts;

use Extended\ACF\Fields\Layout;
use Extended\ACF\Fields\Text;


/**
 * Class AnchorLink
 *
 * @package CN\App\Fields\Layouts
 */
class AnchorLink extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'cn/layout/anchor-link',
            Layout::make(__('Anchor Link', 'kmag'), 'anchor-link')
                ->layout('block')
                ->fields([
                    Text::make(__('Anchor Title', 'kmag'), 'anchor-title')
                        ->instructions(__('Write the fragment without the # as it appears in the url. Ex: /#product-soil-facts Write: product-soil-facts', 'kmag'))
                ])
        );
    }
}
