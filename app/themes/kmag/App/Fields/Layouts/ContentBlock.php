<?php

namespace CN\App\Fields\Layouts;

use CN\App\Fields\Common;
use Extended\ACF\ConditionalLogic;
use Extended\ACF\Fields\ColorPicker;
use Extended\ACF\Fields\ButtonGroup;
use Extended\ACF\Fields\Group;
use Extended\ACF\Fields\Layout;
use Extended\ACF\Fields\Link;
use Extended\ACF\Fields\RadioButton;
use Extended\ACF\Fields\Select;
use Extended\ACF\Fields\Textarea;
use Extended\ACF\Fields\WysiwygEditor;

/**
 * Class ContentBlock
 *
 * @package CN\App\Fields\Layouts
 */
class ContentBlock extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'cn/layout/content-block',
            Layout::make(__('Content Block', 'kmag'), 'content-block')
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                  
                    ButtonGroup::make(__('Content Type', 'kmag'), 'content-type')
                        ->choices([
                            'headline'  => __('Headline', 'kmag'),
                            'headline-content' => __('Headline and Content', 'kmag')
                        ])
                        ->defaultValue('headline'),
                    ButtonGroup::make(__('Headline Type', 'kmag'), 'headline-type')
                        ->choices([
                            'h2'  => __('H2', 'kmag'),
                            'h3' => __('H3', 'kmag')
                        ])
                        ->defaultValue('h3')
                        ->conditionalLogic([
                            ConditionalLogic::where('content-type', '==', 'headline-content')
                        ]),
                    Textarea::make(__('Headline', 'kmag'), 'headline')
                        ->rows(2)
                        ->instructions('If necessary wrap the text with: <br/> &lt;b>&lt;/b> for bold text <br/> &lt;i>&lt;/i> for italics <br/> &lt;sup>&lt;/sup> for superscripts <br/> &lt;sub>&lt;/sub> for subscripts', 'kmag')
                        ->required(),
                    Link::make(__('Link', 'kmag'), 'headline-link')
                        ->conditionalLogic([
                            ConditionalLogic::where('content-type', '==', 'headline')
                        ]),
                    WysiwygEditor::make(__('Content', 'kmag'), 'content')
                        ->mediaUpload(false)
                        ->conditionalLogic([
                            ConditionalLogic::where('content-type', '==', 'headline-content')
                        ]),
                    Link::make(__('Link', 'kmag'), 'link')
                        ->conditionalLogic([
                            ConditionalLogic::where('content-type', '==', 'headline-content')
                        ]),
                    $this->optionsTab(),
                    Select::make(__('Button Color', 'kmag'), 'button-color')
                        ->choices([
                            'primary' => __('Primary', 'kmag'),
                            'secondary' => __('Secondary', 'kmag'),
                            'tertiary' => __('Tertiary', 'kmag'),
                             'frontier-fields' => __('Frontier Fields', 'kmag'),
                        ])
                        ->defaultValue('primary')
                        ->returnFormat('value'),
                    Group::make(__('Button Icons', 'kmag'), 'button-icons')
                        ->layout('block')
                        ->fields([
                            Common::iconOptions('Left Icon')
                                ->wrapper([
                                    'width' => '50'
                                ]),
                            Common::iconOptions('Right Icon')
                                ->wrapper([
                                    'width' => '50'
                                ])
                        ]),
                    RadioButton::make(__('Dynamic Display', 'kmag'), 'dynamic-display')
                        ->choices([
                            'none' => __('None', 'kmag'),
                            'show-with-region-crop' => __('Show With Region Crop', 'kmag'),
                            'hide-with-region-crop' => __('Hide With Region Crop', 'kmag'),
                        ])
                        ->defaultValue('none')
                        ->instructions('Make the section dynamic based on whether the Region Crop have been selected. Show With Region Crop will show the section when Region Crop is selected and hide it otherwise.', 'kmag'),
                    $this->styleTab(),
                    Common::paddingGroup(DEFAULT_CONTENT_BLOCK_PADDING)
                ])
        );
    }
}