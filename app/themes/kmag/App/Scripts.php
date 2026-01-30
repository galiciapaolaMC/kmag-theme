<?php

namespace CN\App;

use CN\App\Interfaces\WordPressHooks;

/**
 * Class Scripts
 *
 * @package CN\App
 */
class Scripts implements WordPressHooks
{

    /**
     * Add class hooks.
     */
    public function addHooks()
    {
        add_action('wp_enqueue_scripts', [$this, 'enqueueScripts']);
        add_action('wp_enqueue_scripts', [$this, 'enqueueStyles']);
    }

    /**
     * Load scripts for the front end.
     */
    public function enqueueScripts()
    {
        wp_enqueue_script(
            'cn-theme',
            get_stylesheet_directory_uri() . "/build/js/theme.min.js",
            ['jquery'],
            THEME_VERSION,
            true
        );

        if (is_singular() && comments_open() && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply');
        }
    }

    /**
     * Load stylesheets for the front end.
     */
    public function enqueueStyles()
    {

        wp_enqueue_style(
            'cn-styles',
            get_stylesheet_directory_uri() . "/build/css/theme.min.css",
            [],
            THEME_VERSION
        );

        wp_enqueue_style(
            'typekit',
            "https://use.typekit.net/fgw1gzg.css",
            [],
            THEME_VERSION
        );
    }
}
