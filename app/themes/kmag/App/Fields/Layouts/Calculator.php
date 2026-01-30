<?php

namespace CN\App\Fields\Layouts;

use CN\App\Fields\Common;
use Extended\ACF\Fields\Layout;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\TextArea;
use Extended\ACF\Fields\TrueFalse;

/**
 * Class Calculator
 *
 * @package CN\App\Fields\Layouts
 */
class Calculator extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'cn/layout/calculator',
            Layout::make(__('Calculator', 'kmag'))
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                    Text::make(__('Page', 'kmag')),
                    $this->optionsTab(),
                    TrueFalse::make(__('Gate This Content', 'kmag'), 'gate-this-content')
                        ->defaultValue('0')
                        ->instructions(__('This will add a Form Gate to the page that must be completed in order to view the content.', 'kmag')),
                    TextArea::make(__('Gate Headline', 'kmag'), 'gate-headline')
                        ->defaultValue(__('A free Mosaic subscription is required to view this resource. Please complete the form below.', 'kmag'))
                        ->rows(2),
                    $this->styleTab(),
                    Common::paddingGroup(DEFAULT_CALCULATOR_PADDING)
                ])
        );
    }
}
