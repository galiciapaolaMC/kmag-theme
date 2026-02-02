<?php

namespace CN\App\Fields\Layouts\Partials;

use CN\App\Fields\Common;
use CN\App\Fields\Layouts\Layouts;
use Extended\ACF\Fields\ButtonGroup;
use Extended\ACF\Fields\Layout;
use Extended\ACF\Fields\Link;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\Textarea;
use Extended\ACF\Fields\ColorPicker;

/**
 * Class TextFiftyFifty
 *
 * @package CN\App\Fields\Layouts\Partials
 */
class TextFiftyFifty extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'cn/layout/text-fifty-fifty',
            Layout::make(__('Text Fifty Fifty', 'kmag'))
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                    Textarea::make(__('Headline', 'kmag'))
                        ->instructions(__(FORMATTING_TAG_INSTRUCTIONS, 'kmag'))
                        ->rows(2),
                    Textarea::make(__('Paragraph', 'kmag'))
                        ->instructions(__(FORMATTING_TAG_INSTRUCTIONS, 'kmag'))
                        ->rows(3),
                    Link::make(__('Link', 'kmag')),
                    $this->optionsTab(),
                    ButtonGroup::make(__('Theme Color', 'kmag'))
                        ->choices([
                            'light' => __('Light', 'kmag'),
                            'dark'  => __('Dark', 'kmag')
                        ])
                        ->defaultValue('light')
                        ->wrapper([
                            'width' => '50'
                        ]),
                    Common::productColors(
                        array('default' => 'Default', 'tertiary' => 'Seed Green')
                    ),
                    ButtonGroup::make(__('Heading Tag', 'kmag'))
                        ->choices([
                            'h2' => __('H2', 'kmag'),
                            'h3'  => __('H3', 'kmag')
                        ])
                        ->defaultValue('h2')
                        ->wrapper([
                            'width' => '50'
                        ])
                ])
        );
    }
}