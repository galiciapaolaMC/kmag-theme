<?php

namespace CN\App\Fields\FieldGroups;

use Extended\ACF\Location;
use CN\App\Fields\Options\Branding;
use CN\App\Fields\Options\Footer;
use CN\App\Fields\Options\Scripts;

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
                (new Footer())->fields(),
                (new Scripts())->fields(),
            )
        );
    }
}
