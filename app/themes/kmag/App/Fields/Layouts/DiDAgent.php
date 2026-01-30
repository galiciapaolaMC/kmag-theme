<?php

namespace CN\App\Fields\Layouts;

use CN\App\Fields\Common;
use Extended\ACF\Fields\ButtonGroup;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\Textarea;
use Extended\ACF\Fields\Layout;
use Extended\ACF\Fields\Number;

/**
 * Class DiDAgent
 *
 * @package CN\App\Fields\Layouts
 */
class DiDAgent extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'cn/layout/did-agent',
            Layout::make(__('DiDAgent', 'kmag'), 'did-agent')
                ->layout('block')
                ->fields([
                    ButtonGroup::make(__('Agent Version', 'kmag'), 'agent-version')
                        ->choices([
                            'v1' => __('V1', 'kmag'),
                            'v2'  => __('V2', 'kmag')
                        ])
                        ->defaultValue('v2'),
                    Text::make(__('Agent ID', 'kmag'), 'agent-id')
                        ->required()
                        ->defaultValue('v2_agt_OK5Aa5nH')
                        ->instructions(__('The ID of the agent to be displayed.', 'kmag')),
                    Text::make(__('Div ID', 'kmag'), 'div-id')
                        ->required()
                        ->defaultValue('did-agent-v2_agt_OK5Aa5nH')
                        ->instructions(__('The ID of the div where the agent will be injected. This should be a unique id.', 'kmag')),
                    Textarea::make(__('GTM Script', 'kmag'), 'gtm-script')
                        ->rows(3),
                    Number::make(__('Desktop Height', 'kmag'), 'desktop-height')
                        ->defaultValue(675)
                        ->instructions(__('The height of the agent in pixels.', 'kmag'))
                        ->min(0)
                        ->max(2000)
                        ->step(1),
                    Number::make(__('Mobile Height', 'kmag'), 'mobile-height')
                        ->defaultValue(600)
                        ->instructions(__('The height of the agent in pixels on mobile devices.', 'kmag'))
                        ->min(0)
                        ->max(2000)
                        ->step(1),
                ])
        );
    }
}