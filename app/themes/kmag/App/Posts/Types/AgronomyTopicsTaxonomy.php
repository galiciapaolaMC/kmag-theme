<?php

namespace CN\App\Posts\Types;

use CN\App\Interfaces\WordPressHooks;
use CN\App\Posts\PostTypes;
use CN\App\Posts\Taxonomies;

/**
 * Class AgronomyTopicsTaxonomy
 *
 * @package CN\App\Posts\Types
 */
class AgronomyTopicsTaxonomy implements WordPressHooks
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
            'agronomy-topics',
            __('Agronomy Topic', 'kmag'),
            __('Agronomy Topics', 'kmag'),
            EPISODE_POST_TYPES,
            [
              'hierarchical' => false,
              'meta_box_cb' => [$this, 'customTaxonomyCheckboxes'],
              'capabilities' => [
                    'manage_terms' => 'manage_categories',
                    'edit_terms'   => 'manage_categories',
                    'delete_terms' => 'manage_categories',
                    'assign_terms' => 'edit_posts',
                ],
            ]
        );
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
            <p><strong><?php esc_html_e('Select Agronomy Topics', 'kmag'); ?></strong></p>
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