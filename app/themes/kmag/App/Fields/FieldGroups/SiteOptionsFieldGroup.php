<?php

namespace CN\App\Fields\FieldGroups;

use Extended\ACF\Location;
use CN\App\Fields\Options\Branding;
use CN\App\Fields\Options\Api;
use CN\App\Fields\Options\Cache;
use CN\App\Fields\Options\DealerLocator;
use CN\App\Fields\Options\Footer;
use CN\App\Fields\Options\CropList;
use CN\App\Fields\Options\ModuleSettings;
use CN\App\Fields\Options\Scripts;
use CN\App\Fields\Options\GatedContent;
use CN\App\Fields\Options\PerformanceMap;
use CN\App\Fields\Options\SuperBack;
use CN\App\Fields\Options\TrialData;

/**
 * Class SiteOptionsFieldGroup
 *
 * @package CN\App\Fields\SiteOptionsFieldGroup
 */
class SiteOptionsFieldGroup extends RegisterFieldGroups
{
    /**
     * Register Field Group via Wordplate
     */
    public function registerFieldGroup()
    {
        register_extended_field_group([
            'title'    => __('Site Options', 'kmag'),
            'fields'   => $this->getFields(),
            'location' => [
                Location::where('options_page', 'theme-general-options')
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
        return apply_filters(
            'cn/field-group/site-options/fields',
            array_merge(
                (new Branding())->fields(),
                (new Api())->fields(),
                (new Cache())->fields(),
                (new DealerLocator())->fields(),
                (new Footer())->fields(),
                (new CropList())->fields(),
                (new ModuleSettings())->fields(),
                (new Scripts())->fields(),
                (new GatedContent())->fields(),
                (new PerformanceMap())->fields(),
                (new SuperBack())->fields(),
                (new TrialData())->fields()
            )
        );
    }
}
