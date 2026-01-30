<?php

namespace CN\App\Fields\Layouts;

use CN\App\Fields\Common;
use Extended\ACF\Fields\ColorPicker;
use Extended\ACF\Fields\File;
use Extended\ACF\Fields\Group;
use Extended\ACF\Fields\Layout;
use Extended\ACF\Fields\Text;

/**
 * Class ColumnContent
 *
 * @package CN\App\Fields\Layouts
 */
class FrontierFieldTrialDataBlock extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'cn/layout/frontier-field-trial-block',
            Layout::make(__('Frontier Field Trial Block', 'kmag'), 'frontier-field-trial-block')
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                    Text::make(__('Section Class', 'kmag'), 'section_class'),
                    Group::make(__('Trial Data', 'kmag'), 'trial_data')
                        ->layout('block')
                        ->fields([
                            File::make(__('Image', 'kmag'), 'image')->mimeTypes(['jpeg', 'jpg', 'png'])->library('all')->wrapper(['width' => '50']),
                            File::make(__('Mobile Image', 'kmag'), 'mobile_image')->mimeTypes(['jpeg', 'jpg', 'png'])->library('all')->wrapper(['width' => '50']),
                            Text::make(__('Crop', 'kmag'), 'crop')->wrapper(['width' => '50']),
                            Text::make(__('Fertility Timing', 'kmag'), 'fertility_timing')->wrapper(['width' => '50']),
                            Text::make(__('Organic Matter', 'kmag'), 'organic_matter')->wrapper(['width' => '50']),
                            Text::make(__('Trial Objective', 'kmag'), 'trial_objective')->wrapper(['width' => '50']),
                            Text::make(__('Solid Type Mix', 'kmag'), 'solid_type_mix')->wrapper(['width' => '50']),
                            Text::make(__('Yield Comparison', 'kmag'), 'yield_comparison')->wrapper(['width' => '50']),
                            Text::make(__('Biopath Application', 'kmag'), 'biopath_application')->wrapper(['width' => '50']),
                        ]),
                    $this->styleTab(),
                    Common::paddingGroup(DEFAULT_FRONTIER_FIELD_PADDING)
                ])
        );
    }
}
