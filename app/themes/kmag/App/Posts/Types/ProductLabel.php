<?php

namespace CN\App\Posts\Types;

use CN\App\Interfaces\WordPressHooks;
use CN\App\Posts\PostTypes;
use CN\App\Posts\Taxonomies;

/**
 * Class Product Label
 *
 * @package CN\App\Posts\Types
 */
class ProductLabel implements WordPressHooks
{
    /**
     * Add class hooks.
     */
    public function addHooks()
    {
        add_action('init', [$this, 'registerPost']);
    }

    /**
     * Register Post Type.
     */
    public function registerPost()
    {
        PostTypes::registerPostType(
            'product-label',
            __('Product Label', 'kmag'),
            __('Product Labels', 'kmag'),
            [
                'menu_icon' => 'dashicons-admin-multisite',
                'supports' => ['title', 'thumbnail'],
                'menu_position' => 32,
                'has_archive' => false,
                'rewrite' => array('slug' => 'resource-library')
            ]
        );
    }
}
