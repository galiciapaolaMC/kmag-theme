<?php

namespace CN\App\Posts\Types;

use CN\App\Interfaces\WordPressHooks;
use CN\App\Posts\PostTypes;
use CN\App\Posts\Taxonomies;

/**
 * Class FarmerProfiles
 *
 * @package CN\App\Posts\Types
 */
class FarmerProfiles implements WordPressHooks
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
            'farmer-profiles',
            __('Farmer Profile', 'kmag'),
            __('Farmer Profiles', 'kmag'),
            [
                'menu_icon' => 'dashicons-admin-multisite',
                'supports' => ['title', 'thumbnail'],
                'menu_position' => 29,
                'has_archive' => false,
                'rewrite' => array('slug' => 'biosciences/frontier-fields')
            ]
        );

        Taxonomies::registerTaxonomy(
            'farmer-country',
            __('Country', 'kmag'),
            __('Countries', 'kmag'),
            ['farmer-profiles'],
            [
                'hierarchical' => false,
                'meta_box_cb' => [$this, 'customTaxonomyCheckboxes'],
                'capabilities' => [
                        'manage_terms' => 'manage_categories',
                        'edit_terms'   => 'manage_categories',
                        'delete_terms' => 'manage_categories',
                        'assign_terms' => 'edit_posts',
                    ],
                'query_var' => 'farmer-country',
            ]
        );
				
    }

    public function replaceH1TagsH3($content)
    {
        $content = preg_replace('/<h1\b[^>]*>(.*?)<\/h1>/i', '<h3>$1</h3>', $content);
        return $content;
    }

    public function customTaxonomyCheckboxes($post, $box)
    {
        $taxonomy = $box['args']['taxonomy'];
        $terms = get_terms([
            'taxonomy'   => $taxonomy,
            'hide_empty' => false,
        ]);

        // Get the terms currently assigned to the post
        $selected_terms = wp_get_post_terms($post->ID, $taxonomy, ['fields' => 'ids']);

        ?>
        <div class="taxonomy-box">
            <p><strong><?php esc_html_e('Select Country', 'kmag'); ?></strong></p>
            <?php foreach ($terms as $term) : ?>
                <label style="display: block; margin-bottom: 5px;">
                    <input type="checkbox" name="tax_input[<?php echo esc_attr($taxonomy); ?>][]" 
                        value="<?php echo esc_attr($term->slug); ?>" 
                        <?php checked(in_array($term->term_id, $selected_terms)); ?>>
                    <?php echo esc_html($term->name); ?>
                </label>
            <?php endforeach; ?>
        </div>
        <?php
    }
}