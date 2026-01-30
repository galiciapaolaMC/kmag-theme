<?php

namespace CN\App\Fields\Layouts;

use CN\App\Fields\Common;
use Extended\ACF\Fields\Layout;
use Extended\ACF\Fields\Repeater;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\Link;
use Extended\ACF\Fields\WysiwygEditor;
/**
 * Class Accordion
 *
 * @package CN\App\Fields\Layouts
 */
class Accordion extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'cn/layout/accordion',
            Layout::make(__('Accordion', 'kmag'), 'accordion')
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                    Repeater::make(__('Accordion Block', 'kmag'), 'accordion-block')
                        ->min(1)
                        ->layout('block')
                        ->fields([
                            Text::make(__('Headline', 'kmag'), 'headline'),
                            WysiwygEditor::make(__('Content', 'kmag'), 'content')
                                        ->mediaUpload(false),
                            Repeater::make(__('List', 'kmag'), 'list')
                                ->min(0)
                                ->layout('block')
                                ->fields([
                                    Text::make(__('Title', 'kmag'), 'title')
                                        ->required(),
                                    Link::make(__('Link', 'kmag'), 'link')
                                        ->wrapper([
                                            'width' => '50'
                                        ]),
                                    Link::make(__('File Download', 'kmag'), 'file-download')
                                        ->wrapper([
                                            'width' => '50'
                                        ])
                                ]),
                        ]),
                    $this->styleTab(),
                    Common::paddingGroup(DEFAULT_ACCORDION_PADDING)
                ])
        );
    }
}