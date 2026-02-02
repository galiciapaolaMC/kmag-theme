<?php

namespace CN\App\Fields\FieldGroups;

use CN\App\Fields\FieldGroups\RegisterFieldGroups;
use Extended\ACF\Location;

/**
 * Class CustomPostTypeFieldGroups
 *
 * @package CN\App\Fields\CustomPostTypeFieldGroup
 */
class CustomPostTypeFieldGroups extends RegisterFieldGroups
{
    /**
     * Register Field Group via Wordplate
     */
    public function registerFieldGroup()
    {
    
        register_extended_field_group([
            'title'    => __('Performance Products', 'kmag'),
            'fields'   => $this->getFields('PerformanceProducts'),
            'location' => [
                Location::where('post_type', 'performance-products')
            ],
            'style' => 'default'
        ]);

        register_extended_field_group([
            'title'    => __('Agrifacts', 'kmag'),
            'fields'   => $this->getFields('Agrifacts'),
            'location' => [
                Location::where('post_type', 'agrifacts')
            ],
            'style' => 'default'
        ]);

        register_extended_field_group([
            'title'    => __('Spec Sheets', 'kmag'),
            'fields'   => $this->getFields('SpecSheets'),
            'location' => [
                Location::where('post_type', 'spec-sheets')
            ],
            'style' => 'default'
        ]);

        register_extended_field_group([
            'title'    => __('GHS Label', 'kmag'),
            'fields'   => $this->getFields('GHSLabel'),
            'location' => [
                Location::where('post_type', 'ghs-label')
            ],
            'style' => 'default'
        ]);

        register_extended_field_group([
            'title' => __('SDS Pages', 'kmag'),
            'fields' => $this->getFields('SDSPages'),
            'location' => [
                Location::where('post_type', 'sds-pages')
            ],
            'style' => 'default'
        ]);
    }

    /**
     * Register the fields that will be available to this Field Group.
     *
     * @return array
     */
    public function getFields($name = '')
    {
        $n = 'CN\App\Fields\Posts\\' . $name;
        $lower = strtolower($name);
        return apply_filters(
            'cn/field-group/{$lower}/fields',
            array_merge(
                (new $n())->fields()
            )
        );
    }
}
