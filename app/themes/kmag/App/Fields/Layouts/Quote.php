<?php

namespace CN\App\Fields\Layouts;

use CN\App\Fields\Common;
use Extended\ACF\Fields\Layout;
use Extended\ACF\Fields\Repeater;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\Textarea;
/**
 * Class Accordion
 *
 * @package CN\App\Fields\Layouts
 */
class Quote extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'cn/layout/quote',
            Layout::make(__('Quote', 'kmag'), 'quote')
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                     Textarea::make(__('Quote Content', 'kmag'), 'quote-content')
                        ->rows(7),
                    Text::make(__('Author Name', 'kmag'), 'author-name'),
                    $this->styleTab(),
                    Common::paddingGroup(DEFAULT_ACCORDION_PADDING)
                ])
        );
    }
}