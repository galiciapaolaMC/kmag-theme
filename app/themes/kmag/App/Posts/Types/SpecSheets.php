<?php

namespace CN\App\Posts\Types;

use CN\App\Interfaces\WordPressHooks;
use CN\App\Posts\PostTypes;
use CN\App\Posts\Taxonomies;

/**
 * Class Spec Sheets
 *
 * @package CN\App\Posts\Types
 */
class SpecSheets implements WordPressHooks
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
            'spec-sheets',
            __('Spec Sheet', 'kmag'),
            __('Spec Sheets', 'kmag'),
            [
                'menu_icon' => 'dashicons-admin-multisite',
                'supports' => ['title', 'thumbnail'],
                'menu_position' => 31,
                'has_archive' => false,
            ]
        );
    }
}
