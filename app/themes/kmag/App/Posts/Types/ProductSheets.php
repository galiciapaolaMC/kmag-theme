<?php

namespace CN\App\Posts\Types;

use CN\App\Interfaces\WordPressHooks;
use CN\App\Posts\PostTypes;
use CN\App\Posts\Taxonomies;

/**
 * Class Product Sheets
 *
 * @package CN\App\Posts\Types
 */
class ProductSheets implements WordPressHooks
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
            'product-sheets',
            __('Product Sheet', 'kmag'),
            __('Product Sheets', 'kmag'),
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