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
            'title'    => __('Nutrients', 'kmag'),
            'fields'   => $this->getFields('Nutrients'),
            'location' => [
                Location::where('post_type', 'nutrients')
            ],
            'style' => 'default'
        ]);

        register_extended_field_group([
            'title'    => __('Experts', 'kmag'),
            'fields'   => $this->getFields('Experts'),
            'location' => [
                Location::where('post_type', 'experts')
            ],
            'style' => 'default'
        ]);

        register_extended_field_group([
            'title'    => __('Pages', 'kmag'),
            'fields'   => $this->getFields('Page'),
            'location' => [
                Location::where('post_type', 'page')
            ],
            'style' => 'default'
        ]);

        register_extended_field_group([
            'title'    => __('Products', 'kmag'),
            'fields'   => $this->getFields('Products'),
            'location' => [
                Location::where('post_type', 'products')
            ],
            'style' => 'default'
        ]);

        register_extended_field_group([
            'title'    => __('Product Groups', 'kmag'),
            'fields'   => $this->getFields('ProductGroups'),
            'location' => [
                Location::where('post_type', 'product-groups')
            ],
            'style' => 'default'
        ]);

        register_extended_field_group([
            'title'    => __('Performance Products', 'kmag'),
            'fields'   => $this->getFields('PerformanceProducts'),
            'location' => [
                Location::where('post_type', 'performance-products')
            ],
            'style' => 'default'
        ]);

        register_extended_field_group([
            'title'    => __('Nutrient Deficits', 'kmag'),
            'fields'   => $this->getFields('NutrientDeficits'),
            'location' => [
                Location::where('post_type', 'nutrient-deficits')
            ],
            'style' => 'default'
        ]);

        register_extended_field_group([
            'title'    => __('Crops', 'kmag'),
            'fields'   => $this->getFields('Crops'),
            'location' => [
                Location::where('post_type', 'crops')
            ],
            'style' => 'default'
        ]);

        register_extended_field_group([
            'title'    => __('Regions', 'kmag'),
            'fields'   => $this->getFields('Regions'),
            'location' => [
                Location::where('post_type', 'regions')
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
            'title'    => __('Video Articles', 'kmag'),
            'fields'   => $this->getFields('VideoArticles'),
            'location' => [
                Location::where('post_type', 'video-articles')
            ],
            'style' => 'default'
        ]);

        register_extended_field_group([
            'title'    => __('Robust Articles', 'kmag'),
            'fields'   => $this->getFields('RobustArticles'),
            'location' => [
                Location::where('post_type', 'robust-articles')
            ],
            'style' => 'default'
        ]);

        register_extended_field_group([
            'title'    => __('Agrisights', 'kmag'),
            'fields'   => $this->getFields('Agrisights'),
            'location' => [
                Location::where('post_type', 'agrisights')
            ],
            'style' => 'default'
        ]);

        register_extended_field_group([
            'title'    => __('Frontier Fields Episodes', 'kmag'),
            'fields'   => $this->getFields('FrontierFieldsEpisodes'),
            'location' => [
                Location::where('post_type', 'frontier-fields-eps')
            ],
            'style' => 'default'
        ]);

        register_extended_field_group([
            'title'    => __('Sherry Show Episodes', 'kmag'),
            'fields'   => $this->getFields('SherryShowEpisodes'),
            'location' => [
                Location::where('post_type', 'sherry-show-episodes')
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
            'title'    => __('Application Rate Sheets', 'kmag'),
            'fields'   => $this->getFields('AppRateSheets'),
            'location' => [
                Location::where('post_type', 'app-rate-sheets')
            ],
            'style' => 'default'
        ]);

        register_extended_field_group([
            'title'    => __('Product Sheets', 'kmag'),
            'fields'   => $this->getFields('ProductSheets'),
            'location' => [
                Location::where('post_type', 'product-sheets')
            ],
            'style' => 'default'
        ]);

        register_extended_field_group([
            'title'    => __('Success Story', 'kmag'),
            'fields'   => $this->getFields('SuccessStory'),
            'location' => [
                Location::where('post_type', 'success-story')
            ],
            'style' => 'default'
        ]);

        register_extended_field_group([
            'title'    => __('Standard Articles', 'kmag'),
            'fields'   => $this->getFields('StandardArticles'),
            'location' => [
                Location::where('post_type', 'standard-articles')
            ],
            'style' => 'default'
        ]);

        register_extended_field_group([
            'title'    => __('Default Posts', 'kmag'),
            'fields'   => $this->getFields('DefaultPosts'),
            'location' => [
                Location::where('post_type', 'post')
            ],
            'style' => 'default'
        ]);

        register_extended_field_group([
            'title'    => __('Directions for use', 'kmag'),
            'fields'   => $this->getFields('DirectionsForUse'),
            'location' => [
                Location::where('post_type', 'directions-for-use')
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

        register_extended_field_group([
            'title' => __('Column Content', 'kmag'),
            'fields' => $this->getFields('ColumnContent'),
            'location' => [
                Location::where('post_type', 'column-content')
            ],
            'style' => 'default'
        ]);

        register_extended_field_group([
            'title' => __('Calculators', 'kmag'),
            'fields' => $this->getFields('Calculators'),
            'location' => [
                Location::where('post_type', 'calculators')
            ],
            'style' => 'default'
        ]);

        register_extended_field_group([
            'title' => __('Campaigns', 'kmag'),
            'fields' => $this->getFields('Campaigns'),
            'location' => [
                Location::where('post_type', 'campaigns')
            ],
            'style' => 'default'
        ]);

        register_extended_field_group([
            'title' => __('TruResponse Insights', 'kmag'),
            'fields' => $this->getFields('TruResponseInsights'),
            'location' => [
                Location::where('post_type', 'trures-insights')
            ],
            'style' => 'default'
        ]);

        register_extended_field_group([
            'title' => __('TruResponse Trial Data', 'kmag'),
            'fields' => $this->getFields('TruResTrialData'),
            'location' => [
                Location::where('post_type', 'trures-trial-data')
            ],
            'style' => 'default'
        ]);

        register_extended_field_group([
            'title'    => __('Farmer Profiles', 'kmag'),
            'fields'   => $this->getFields('FarmerProfiles'),
            'location' => [
                Location::where('post_type', 'farmer-profiles')
            ],
            'style' => 'default'
        ]);

        register_extended_field_group([
            'title'    => __('Material Compatibility', 'kmag'),
            'fields'   => $this->getFields('Material'),
            'location' => [
                Location::where('post_type', 'material')
            ],
            'style' => 'default'
        ]);

        register_extended_field_group([
            'title'    => __('Product Label', 'kmag'),
            'fields'   => $this->getFields('ProductLabel'),
            'location' => [
                Location::where('post_type', 'product-label')
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
