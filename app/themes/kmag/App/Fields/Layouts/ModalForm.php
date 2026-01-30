<?php

namespace CN\App\Fields\Layouts;

use Extended\ACF\Fields\Layout;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\Textarea;

/**
 * Class ModalForm
 *
 * @package CN\App\Fields\Layouts
 */
class ModalForm extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'cn/layout/modal-form',
            Layout::make(__('Modal Form', 'kmag'), 'modal-form')
                ->layout('block')
                ->fields([
                    Text::make(__('Title', 'kmag'), 'title'),
                    Textarea::make(__('Embedded Content', 'kmag'), 'embedded-content')
                        ->rows(3)
                ])
        );
    }
}
