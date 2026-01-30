<?php

namespace CN\App\Posts\Types;

use CN\App\Interfaces\WordPressHooks;
use CN\App\Posts\PostTypes;
use CN\App\Posts\Taxonomies;

/**
 * Class PerformanceProductsTaxonomy
 *
 * @package CN\App\Posts\Types
 */
class PerformanceProductsTaxonomy implements WordPressHooks
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
            'performance-product',
            __('Performance Product', 'kmag'),
            __('Performance Products', 'kmag'),
            RESOURCE_POST_TYPES,
            [
              'hierarchical' => false
            ]
        );
    } 
}
