<?php

namespace CN\App\Posts\Types;

use CN\App\Interfaces\WordPressHooks;
use CN\App\Posts\PostTypes;
use CN\App\Posts\Taxonomies;

/**
 * Class SherryShowEpisodes
 *
 * @package CN\App\Posts\Types
 */
class SherryShowEpisodes implements WordPressHooks
{
    /**
     * Add class hooks.
     */
    public function addHooks()
    {
        add_action('init', [$this, 'registerPost']);
        add_filter('the_content', [$this, 'replaceH1TagsH3']);
    }

    /**
     * Register Post Type.
     */
    public function registerPost()
    {
        PostTypes::registerPostType(
            'sherry-show-episodes',
            __('Sherry Show Episode', 'kmag'),
            __('Sherry Show Episodes', 'kmag'),
            [
                'menu_icon' => 'dashicons-admin-multisite',
                'supports' => ['title', 'thumbnail'],
                'menu_position' => 29,
                'has_archive' => false,
                'rewrite' => array('slug' => 'advanced-kmag-with-sherry')
            ]
        );
    }

    public function replaceH1TagsH3($content)
    {
        $content = preg_replace('/<h1\b[^>]*>(.*?)<\/h1>/i', '<h3>$1</h3>', $content);
        return $content;
    }
}