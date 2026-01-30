<?php

namespace CN\App\Posts\Types;
use CN\App\Interfaces\WordPressHooks;
use CN\App\Posts\PostTypes;
use CN\App\Posts\Taxonomies;
/**
 * Class Video Details
 *
 * @package CN\App\Posts\Types
 */
class VideoArticles implements WordPressHooks
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
            'video-articles',
            __('Video Articles', 'kmag'),
            __('Video Articles', 'kmag'),
            [
                'menu_icon' => 'dashicons-admin-multisite',
                'supports' => ['title', 'thumbnail'],
                'menu_position' => 29,
                'has_archive' => false,
                'rewrite' => array('slug' => 'resource-library')
            ]
        );
    }
}

