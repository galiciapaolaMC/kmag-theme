<?php

namespace CN\App\Fields\Layouts;

use CN\App\Fields\Common;
use Extended\ACF\Fields\Layout;
use Extended\ACF\Fields\RadioButton;
use Extended\ACF\Fields\Repeater;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\WysiwygEditor;


/**
 * Class ContentArea
 *
 * @package CN\App\Fields\Layouts
 */
class ContentArea extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'cn/layout/content-area',
            Layout::make(__('Content Area', 'kmag'))
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                    Repeater::make(__('Content Area Block', 'kmag'), 'content-area-block')
                        ->min(1)
                        ->layout('block')
                        ->fields([
                            Text::make(__('Section Name', 'kmag'), 'section-name'),
                            WysiwygEditor::make(__('Section Content', 'kmag'), 'section-content')
                                ->mediaUpload(false)
                        ]),
                    $this->optionsTab(),
                    RadioButton::make(__('Dynamic Display', 'kmag'), 'dynamic-display')
                        ->choices([
                            'none' => __('None', 'kmag'),
                            'show-with-region-crop' => __('Show With Region Crop', 'kmag'),
                            'hide-with-region-crop' => __('Hide With Region Crop', 'kmag'),
                        ])
                        ->defaultValue('none')
                        ->instructions('Make the section dynamic based on whether the Region Crop have been selected. Show With Region Crop will show the section when Region Crop is selected and hide it otherwise.', 'kmag'),
                    $this->styleTab(),
                    Common::paddingGroup(DEFAULT_CONTENT_AREA_PADDING)
                ])
        );
    }
}
