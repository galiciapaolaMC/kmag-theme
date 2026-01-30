<?php

namespace CN\App\Fields\Layouts;

use CN\App\Fields\Common;
use Extended\ACF\Fields\Layout;
use Extended\ACF\Fields\Link;
use Extended\ACF\Fields\Select;
use Extended\ACF\Fields\Text;

/**
 * Class ChilipiperForm
 *
 * @package CN\App\Fields\Layouts
 */
class ChilipiperForm extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'cn/layout/chilipiper-form',
            Layout::make(__('Chilipiper Form', 'kmag'), 'chilipiper-form')
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                    Text::make(__('Headline', 'kmag'), 'headline'),
                    Link::make(__('Chilipiper CTA', 'kmag'), 'chilipiper-cta'),
                    $this->optionsTab(),
                    Select::make(__('Button Color', 'kmag'), 'button-color')
                        ->choices([
                            'primary' => __('Primary', 'kmag'),
                            'secondary' => __('Secondary', 'kmag'),
                            'tertiary' => __('Tertiary', 'kmag'),
                            'white-outline' => __('White Outline', 'kmag')
                        ])
                        ->defaultValue('primary')
                        ->returnFormat('value'),
                    $this->styleTab(),
                    Common::paddingGroup(DEFAULT_CALCULATOR_PADDING)
                ])
        );
    }
}
