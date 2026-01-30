<?php

namespace CN\App\Fields\Layouts;

use Extended\ACF\Fields\WysiwygEditor;
use Extended\ACF\Fields\Layout;
use CN\App\Fields\Common;

/**
 * Class Wysiwyg
 *
 * @package CN\App\Fields\Layouts
 */
class Wysiwyg extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'cn/layout/wysiwyg',
            Layout::make(__('Wysiwyg', 'kmag'))
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                    WysiwygEditor::make(__('Content', 'kmag'), 'content')
                        ->mediaUpload(false),
                    $this->styleTab(),
                    Common::paddingGroup(DEFAULT_WYSIWYG_PADDING)
                ])
        );
    }
}
