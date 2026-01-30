<?php

namespace CN\App\Posts\Types;

use CN\App\Interfaces\WordPressHooks;
use CN\App\Posts\PostTypes;
use CN\App\Posts\Taxonomies;

/**
 * Class ShowSeasonTaxonomy
 *
 * @package CN\App\Posts\Types
 */
class ShowSeasonsTaxonomy implements WordPressHooks
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
            'show-season',
            __('Show Season', 'kmag'),
            __('Show Seasons', 'kmag'),
            EPISODE_POST_TYPES,
            [
              'hierarchical' => false,
              'meta_box_cb' => [$this, 'customTaxonomyDropdown'],
              'capabilities' => [
                    'manage_terms' => 'manage_categories',
                    'edit_terms'   => 'manage_categories',
                    'delete_terms' => 'manage_categories',
                    'assign_terms' => 'edit_posts',
                ],
            ]
        );
    }

    /**
     * Custom taxonomy dropdown to prevent adding new terms in post editor.
     */
    public function customTaxonomyDropdown($post, $box)
    {
        $taxonomy = $box['args']['taxonomy'];
        $terms = get_terms([
            'taxonomy'   => $taxonomy,
            'hide_empty' => false,
        ]);

        // Get the current terms assigned to the post
        $selected_terms = wp_get_post_terms($post->ID, $taxonomy, ['fields' => 'slugs']);
        $selected_value = !empty($selected_terms) ? $selected_terms[0] : ''; // Single selection

        ?>
        <div class="taxonomy-box">
            <label for="<?php echo esc_attr($taxonomy); ?>"><?php esc_html_e('Select a Season', 'kmag'); ?></label>
            <select name="tax_input[<?php echo esc_attr($taxonomy); ?>]" id="<?php echo esc_attr($taxonomy); ?>">
                <option value=""><?php esc_html_e('Select a season', 'kmag'); ?></option>
                <?php foreach ($terms as $term) : ?>
                    <option value="<?php echo esc_attr($term->slug); ?>" 
                        <?php selected($selected_value, $term->slug); ?>>
                        <?php echo esc_html($term->name); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <?php
    }
}