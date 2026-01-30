<?php

namespace CN\App\Fields\Layouts;

use CN\App\Fields\Common;
use Extended\ACF\ConditionalLogic;
use CN\App\Fields\Layouts\Partials\BoxContent;
use CN\App\Fields\Layouts\Partials\Card;
use CN\App\Fields\Layouts\Partials\ImageFiftyFifty;
use CN\App\Fields\Layouts\Partials\LinkableCard;
use CN\App\Fields\Layouts\Partials\TextFiftyFifty;
use CN\App\Fields\Layouts\Partials\VideoFiftyFifty;
use CN\App\Fields\Layouts\DiDAgent;

use Extended\ACF\Fields\ButtonGroup;
use Extended\ACF\Fields\ColorPicker;
use Extended\ACF\Fields\FlexibleContent;
use Extended\ACF\Fields\Layout;
use Extended\ACF\Fields\Repeater;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\TrueFalse;

/**
 * Class ColumnContent
 *
 * @package CN\App\Fields\Layouts
 */
class ColumnContent extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'cn/layout/column-content',
            Layout::make(__('Column Content', 'kmag'))
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                    Text::make(__('Section Class', 'kmag')),
                    Repeater::make(__('Columns', 'kmag'))
                        ->min(1)
                        ->max(4)
                        ->fields([
                            FlexibleContent::make(__('Modules', 'kmag'))
                                ->buttonLabel(__('Add Element', 'kmag'))
                                ->layouts([
                                    (new BoxContent())->fields(),
                                    (new Card())->fields(),
                                    (new ImageFiftyFifty())->fields(),
                                    (new LinkableCard())->fields(),
                                    (new TextFiftyFifty())->fields(),
                                    (new VideoFiftyFifty())->fields(),
                                    (new DiDAgent())->fields(),
                                ])
                                ->wrapper([
                                    'width' => '100'
                                ])
                        ])
                        ->buttonLabel(__('Add Column', 'kmag')),
                    $this->optionsTab(),
                    ButtonGroup::make(__('Gap Size', 'kmag'))
                        ->choices([
                            'collapse'  => __('None', 'kmag'),
                            'small' => __('Small', 'kmag'),
                            'medium' => __('Medium', 'kmag'),
                            'large' => __('Large', 'kmag'),
                            'xlarge' => __('XLarge', 'kmag')
                        ])
                        ->instructions(__('Default value is none', 'kmag'))
                        ->defaultValue('none')
                        ->wrapper([
                            'width' => '100'
                        ]),
                    ButtonGroup::make(__('Module Vertical Alignment', 'kmag'), 'module-vertical-alignment')
                        ->choices([
                            'top'  => __('Top', 'kmag'),
                            'middle' => __('Middle', 'kmag'),
                            'bottom' => __('Bottom', 'kmag'),
                        ])
                        ->defaultValue('middle')
                        ->wrapper([
                            'width' => '50'
                        ]),
                    ButtonGroup::make(__('Module Width', 'kmag'), 'module-width')
                        ->choices([
                            'normal'  => __('Normal', 'kmag'),
                            'full-width' => __('Full Width', 'kmag')
                        ])
                        ->defaultValue('normal')
                        ->wrapper([
                            'width' => '50'
                        ]),
                    TrueFalse::make(__('Reverse Mobile', 'kmag'))
                        ->defaultValue(0)
                        ->instructions(__('This will only work if there are exactly 2 columns.', 'kmag'))
                        ->wrapper([
                            'width' => '50'
                        ]),
                    $this->styleTab(),
                    Common::paddingGroup(DEFAULT_COLUMN_CONTENT_PADDING)
                ])
        );
    }
}