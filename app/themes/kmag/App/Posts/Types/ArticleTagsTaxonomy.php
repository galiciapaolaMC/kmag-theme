<?php

namespace CN\App\Posts\Types;

use CN\App\Interfaces\WordPressHooks;
use CN\App\Posts\PostTypes;
use CN\App\Posts\Taxonomies;

/**
 * Class ArticleTags
 *
 * @package CN\App\Posts\Types
 */
class ArticleTagsTaxonomy implements WordPressHooks
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
            'article-tag',
            __('Article Tag', 'kmag'),
            __('Article Tags', 'kmag'),
            RESOURCE_POST_TYPES,
            [
              'hierarchical' => false
            ]
        );
    } 
}
