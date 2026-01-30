<?php

namespace CN\App\Fields\Layouts;

use CN\App\Fields\Common;
use CN\App\Fields\Layouts\Partials\Card;
use CN\App\Fields\Layouts\Partials\ImageFiftyFifty;
use CN\App\Fields\Layouts\Partials\LinkableCard;
use CN\App\Fields\Layouts\Partials\TextFiftyFifty;
use CN\App\Fields\Layouts\Partials\VideoFiftyFifty;
use Extended\ACF\Fields\FlexibleContent;
use Extended\ACF\Fields\Layout;
use Extended\ACF\Fields\Relationship;
use Extended\ACF\Fields\Repeater;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\WysiwygEditor;


/**
 * Class AccordionPost
 *
 * @package CN\App\Fields\Layouts
 */
class AccordionPost extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'cn/layout/accordion-post',
            Layout::make(__('Accordion Posts', 'kmag'), 'accordion-post')
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                    Repeater::make(__('Accordion Posts Block', 'kmag'), 'accordion-post-block')
                        ->min(1)
                        ->layout('block')
                        ->fields([
                            Text::make(__('Sub Heading', 'kmag'), 'accordion-sub-heading'),
                            Text::make(__('Heading', 'kmag'), 'accordion-heading')->required(),
                            FlexibleContent::make(__('Modules', 'kmag'))
                                ->buttonLabel(__('Add Element', 'kmag'))
                                ->layouts([
                                    (new ContentBlock())->fields(),
                                    (new Wysiwyg())->fields(),
                                    (new MediaAssetBanner())->fields(),
                                    (new Slider())->fields(),
                                    (new Quote())->fields(),
                                    (new ColumnContent())->fields(),
                                    (new Video())->fields(),
                                    (new SplitBanner())->fields(),
                                ])
                                ->wrapper([
                                    'width' => '100'
                                ])
                        ])
                        ->buttonLabel(__('Add Drawer', 'kmag')),
                    $this->styleTab(),
                    Common::paddingGroup(DEFAULT_ACCORDION_PADDING)
                ])
        );
    }
}
