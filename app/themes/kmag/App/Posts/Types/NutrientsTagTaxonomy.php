<?php

namespace CN\App\Posts\Types;

use CN\App\Interfaces\WordPressHooks;
use CN\App\Posts\PostTypes;
use CN\App\Posts\Taxonomies;

/**
 * Class NutrientsTagTaxonomy
 *
 * @package CN\App\Posts\Types
 */
class NutrientsTagTaxonomy implements WordPressHooks
{
    /**
     * Add class hooks.
     */
    public function addHooks()
    {
        add_action('init', [ $this, 'registerTaxonomy' ]);
    }

    /**
     * Register Taxonomy.
     */
    public function registerTaxonomy()
    {
        Taxonomies::registerTaxonomy(
            'nutrients-tag',
            __('Nutrient Tag', 'kmag'),
            __('Nutrient Tags', 'kmag'),
            ['video-articles', 'robust-articles', 'standard-articles', 'success-story', 'agrifacts', 'agrisights'],
            [
              'hierarchical' => false
            ]
        );
    } 
}
