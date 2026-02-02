<?php

namespace CN\App\Fields\FieldGroups;

use CN\App\Fields\Common;
use CN\App\Fields\FieldGroups\RegisterFieldGroups;
use CN\App\Fields\Layouts\Accordion;
use CN\App\Fields\Layouts\AgrifactFilter;
use CN\App\Fields\Layouts\BackgroundGradient;
use CN\App\Fields\Layouts\BentoBox;
use CN\App\Fields\Layouts\ColumnContent;
use CN\App\Fields\Layouts\ContentArea;
use CN\App\Fields\Layouts\ContentBlock;
use CN\App\Fields\Layouts\Hero;
use CN\App\Fields\Layouts\SplitBanner;
use CN\App\Fields\Layouts\Wysiwyg;
use Extended\ACF\Location;
use Extended\ACF\Fields\FlexibleContent;

/**
 * Class PageBuilderFieldGroup
 *
 * @package CN\App\Fields\PageBuilderFieldGroup
 */
class PageBuilderFieldGroup extends RegisterFieldGroups
{
    /**
     * Register Field Group via Wordplate
     */
    public function registerFieldGroup()
    {
        register_extended_field_group([
            'title'    => __('Page Builder', 'kmag'),
            'fields'   => $this->getFields(),
            'location' => [
                Location::where('page_template', 'templates/page-builder.php'),
            ],
            'style' => 'default'
        ]);
    }

    /**
     * Register the fields that will be available to this Field Group.
     *
     * @return array
     */
    public function getFields()
    {
        return apply_filters('cn/field-group/page-builder/fields', [
            FlexibleContent::make(__('Modules', 'kmag'))
                ->buttonLabel(__('Add Module', 'kmag'))
                ->layouts([
                    (new Accordion())->fields(),
                    (new AgrifactFilter())->fields(),
                    (new BackgroundGradient())->fields(),
                    (new BentoBox())->fields(),
                    (new ColumnContent())->fields(),
                    (new ContentArea())->fields(),
                    (new ContentBlock())->fields(),
                    (new Hero())->fields(),
                    (new SplitBanner())->fields(),
                    (new Wysiwyg())->fields()
                ]),
        ]);
    }
}
