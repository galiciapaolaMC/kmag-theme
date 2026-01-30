<?php

namespace CN\App\Fields\Layouts;

use CN\App\Fields\Common;
use Extended\ACF\ConditionalLogic;
use Extended\ACF\Fields\ButtonGroup;
use Extended\ACF\Fields\Image;
use Extended\ACF\Fields\Layout;
use Extended\ACF\Fields\Select;
use Extended\ACF\Fields\WysiwygEditor;

/**
 * Class AgrifactFilter
 *
 * @package CN\App\Fields\Layouts
 */
class AgrifactFilter extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'cn/layout/agrifact-filter',
            Layout::make(__('Agrifact Filter', 'kmag'), 'agrifact-filter')
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                    Image::make(__('Logo', 'kmag'), 'logo'),
                    WysiwygEditor::make(__('Content', 'kmag'), 'content')
                        ->defaultValue('<p>Our global research ensures that we maintain the highest level of consistency and reliability, and provides the data you need to help your crops\' reach their highest potential. Choose a crop below and see the difference MicroEssentials can make.</p>'),
                    ButtonGroup::make(__('Module Filter Type', 'kmag'), 'module_filter_type')
                        ->choices([
                            'buttons' => __('Buttons', 'kmag'),
                            'combobox' => __('Combobox', 'kmag'),
                        ])
                        ->defaultValue('buttons'),
                    Select::make(__('Preselected Performance Product', 'kmag'), 'preselected_performance_product')
                        ->instructions(__('Select a performance product to preselect in the filter.', 'kmag'))
                        ->choices([
                            '' => __('None', 'kmag'),
                            'aspire'  => __('Aspire', 'kmag'),
                            'biopath' => __('BioPath', 'kmag'),
                            'k-mag' => __('K-Mag', 'kmag'),
                            'manage' => __('Manage', 'kmag'),
                            'microessentials' => __('MicroEssentials', 'kmag'),
                            'pegasus' => __('Pegasus', 'kmag'),
                            'powercoat'  => __('PowerCoat', 'kmag'),
                            'prb9' => __('PRB9', 'kmag'),
                            'root-honey-plus-1-0-1' => __('Root Honey Plus', 'kmag'),
                        ])
                        ->defaultValue(''),
                    $this->styleTab(),
                    Common::paddingGroup(DEFAULT_AGRIFACT_FILTER_PADDING)
                ])
        );
    }
}
