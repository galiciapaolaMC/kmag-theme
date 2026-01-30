<?php

namespace CN\App\Fields\Posts;

use CN\App\Fields\Common;
use Extended\ACF\Fields\ButtonGroup;
use Extended\ACF\Fields\File;
use Extended\ACF\Fields\Repeater;
use Extended\ACF\Fields\TextArea;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\WysiwygEditor;

/**
 * Class TruResTrialData
 *
 * @package CN\App\Fields\Posts
 */
class TruResTrialData
{
    /**
     * Defines fields used within TruResTrialData post type.
     *
     * @return array
     */
    public function fields()
    {
        return apply_filters(
            'cn/posts/trures-trial-data',
            [
                Text::make(__('Trial Data Year', 'kmag'), 'trial-data-year')
                    ->wrapper([
                        'width' => '33'
                    ]),
                Text::make(__('Trial Data Code', 'kmag'), 'trial-data-code')
                    ->wrapper([
                        'width' => '33'
                    ]),
                Text::make(__('Trial Data Topic', 'kmag'), 'trial-data-topic')
                    ->wrapper([
                        'width' => '33'
                    ]),
                Repeater::make(__('Additional Statistics', 'kmag'), 'additional-statistics')
                    ->layout('block')
                    ->fields([
                        Text::make(__('Trial Data Number', 'kmag'), 'additional-trial-data-number')
                            ->required()
                            ->wrapper([
                                'width' => '50'
                            ]),
                        Text::make(__('Trial Data Description', 'kmag'), 'additional-trial-data-description')
                            ->required()
                            ->wrapper([
                                'width' => '50'
                            ]),
                    ]),
                File::make(__('Trial Data PDF', 'kmag'), 'trial-data-pdf')
                    ->mimeTypes(['pdf'])
                    ->library('all'),
                WysiwygEditor::make(__('Objective', 'kmag'), 'objective'),
                Repeater::make(__('Overview List', 'kmag'), 'overview-list')
                    ->layout('block')
                    ->fields([
                        Textarea::make(__('Overview Item', 'kmag'), 'overview-item')
                            ->rows(2)
                    ]),
                WysiwygEditor::make(__('Trial Details', 'kmag'), 'trial-details'),
                Repeater::make(__('Summary', 'kmag'), 'summary')
                    ->layout('block')
                    ->fields([
                        Textarea::make(__('Summary Item', 'kmag'), 'summary-item')
                            ->rows(2)
                    ]),
                ButtonGroup::make(__('Activate Trial Data', 'kmag'), 'activate-trial-data')
                    ->choices([
                        'active' => __('Active', 'kmag'), 
                        'inactive' => __('Inactive', 'kmag')
                    ]),
                Common::gatedContentFields(),
                Common::scoredContentFields()
            ]
        );
    }
}
