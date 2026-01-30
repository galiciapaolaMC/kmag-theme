<?php

namespace CN\App;

use CN\App\Interfaces\WordPressHooks;

/**
 * Class Setup
 *
 * @package CN\App
 */
class Setup implements WordPressHooks
{

    /**
     * Add class hooks.
     */
    public function addHooks()
    {
        add_action('init', [$this, 'registerMenus']);
        add_action('widgets_init', [$this, 'registerSidebars'], 5);
        add_action('cn/styles/icons', [$this, 'outputInlineIcons']);
        add_filter( 'posts_search', [$this, 'advanced_custom_search'], 500, 2 );
    }

    /**
     * Registers nav menu locations.
     */
    public function registerMenus()
    {
        register_nav_menu('primary', __('Primary', 'kmag'));
    }

    /**
     * Registers sidebars.
     */
    public function registerSidebars()
    {
        register_sidebar(
            [
                'id'            => 'primary',
                'name'          => __('Sidebar', 'kmag'),
                'description'   => __('Main sidebar area displayed on right side of page via trigger.', 'kmag'),
                'before_widget' => '<div id="%1$s" class="widget %2$s">',
                'after_widget'  => '</div>',
            ]
        );
    }

    /**
     * Output inline svg icons
     */
    public function outputInlineIcons()
    {
        include(locate_template('/assets/images/icons/global.svg'));
        include(locate_template('/assets/images/icons/social.svg'));
    }

    /**
     * Advanced Custom Search
     */
    public function advanced_custom_search( $where, $wp_query ) {
        global $wpdb;
    
        if ( empty( $where ))
            return $where;
    
        $terms = $wp_query->query_vars['s'];
    
        // explode search expression to get search terms
        $exploded = explode( ' ', $terms );
        if( $exploded === FALSE || count( $exploded ) == 0 )
            $exploded = array( 0 => $terms );
    
        $where = '';
        $exploded = array_map('rtrim',$exploded,array_fill(0,sizeof($exploded),'s'));
    
        foreach( $exploded as $tag ) :
            $where .= " 
              AND (
                (wp_posts.post_title LIKE '%$tag%')
                OR (wp_posts.post_content LIKE '%$tag%')
                OR EXISTS (
                  SELECT * FROM wp_postmeta
                      WHERE post_id = wp_posts.ID
                        AND (meta_value LIKE '%$tag%')
                )
                OR EXISTS (
                  SELECT * FROM wp_terms
                  INNER JOIN wp_term_taxonomy
                    ON wp_term_taxonomy.term_id = wp_terms.term_id
                  INNER JOIN wp_term_relationships
                    ON wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id
                  WHERE (
                    taxonomy = 'article-tag'
                        OR taxonomy = 'crop'                
                        OR taxonomy = 'performance-product'
                    )
                    AND object_id = wp_posts.ID
                    AND wp_terms.name LIKE '%$tag%'
                )
            )";
        endforeach;
        return $where;
    }
}
