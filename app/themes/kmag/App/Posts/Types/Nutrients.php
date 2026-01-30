<?php

namespace CN\App\Posts\Types;

use CN\App\Interfaces\WordPressHooks;
use CN\App\Posts\PostTypes;
use CN\App\Posts\Taxonomies;

/**
 * Class Nutrients
 *
 * @package CN\App\Posts\Types
 */
class Nutrients implements WordPressHooks
{
    /**
     * Add class hooks.
     */
    public function addHooks()
    {
        add_action('init', [$this, 'registerPost']);
        add_action('init', [ $this, 'registerTaxonomy' ]);
    }

    /**
     * Register Post Type.
     */
    public function registerPost()
    {
        PostTypes::registerPostType(
            'nutrients',
            __('Nutrient', 'kmag'),
            __('Nutrients', 'kmag'),
            [
                'menu_icon' => 'dashicons-admin-multisite',
                'supports' => ['title', 'thumbnail'],
                'menu_position' => 29,
                'has_archive' => false
            ]
        );
    }

    /**
     * Register Taxonomy.
     */
    public function registerTaxonomy()
    {
        Taxonomies::registerTaxonomy(
            'nutrient-group',
            __('Nutrient Group', 'kmag'),
            __('Nutrient Groups', 'kmag'),
            ['nutrients']
        );
    }
}
