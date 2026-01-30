<?php

namespace CN\App\Fields\Layouts;

use CN\App\Fields\Common;
use Extended\ACF\Fields\Group;
use Extended\ACF\Fields\Layout;
use Extended\ACF\Fields\Select;
use Extended\ACF\Fields\TextArea;

/**
 * Class DealerLocator
 *
 * @package CN\App\Fields\Layouts
 */
class DealerLocator extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'cn/layout/dealer-locator',
            Layout::make(__('Dealer Locator', 'kmag'))
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                    Textarea::make(__('Headline', 'kmag'), 'headline')
                        ->rows(2)
                        ->instructions(__('If necessary wrap the text with: <br/> &lt;b>&lt;/b> for bold text <br/> &lt;i>&lt;/i> for italics <br/> &lt;sup>&lt;/sup> for superscripts <br/> &lt;sub>&lt;/sub> for subscripts', 'kmag'))
                        ->required(),
                    $this->styleTab(),
                    Common::paddingGroup(DEFAULT_CALCULATOR_PADDING),
                    Group::make(__('Color Theme', 'kmag'), 'color-theme')
                    ->layout('block')
                    ->fields([
                        Select::make(__('Accent Color', 'kmag'), 'accent-color')
                            ->choices([
                                'green' => __('Green', 'kmag'),
                                'orange' => __('Orange', 'kmag'),
                            ])
                            ->defaultValue('green')
                    ])
                ])
        );
    }
}
