<?php

namespace CN\App\Posts\Types;

use CN\App\Interfaces\WordPressHooks;
use CN\App\Posts\PostTypes;
use CN\App\Posts\Taxonomies;

/**
 * Class CropsTaxonomy
 *
 * @package CN\App\Posts\Types
 */
class CropsTaxonomy implements WordPressHooks
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
            'crop',
            __('Crop', 'kmag'),
            __('Crops', 'kmag'),
            RESOURCE_POST_TYPES,
            [
              'hierarchical' => false
            ]
        );
    } 
}
