<?php

namespace CN\App\Fields\Layouts;

use CN\App\Fields\Common;
use Extended\ACF\Fields\Layout;
use Extended\ACF\Fields\TextArea;
use Extended\ACF\Fields\Group;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\Link;
/**
 * Class FieldStudyPage
 *
 * @package CN\App\Fields\Layouts
 */
class FieldStudyPage extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'cn/layout/field-study-page',
            Layout::make(__('Field Study Page', 'kmag'))
                ->layout('block')
                ->fields([
                    $this->optionsTab(),
                    Group::make(__('Google Storage URL', 'kmag'), 'google-storage')
                        ->layout('block')
                        ->fields([
                            Text::make(__('Field Data JSON URL', 'kmag'), 'field-data-json'),
                        ]),
                    $this->styleTab(),
                    Common::paddingGroup(DEFAULT_FIELD_STUDY_PADDING)
                ])
        );
    }
}
