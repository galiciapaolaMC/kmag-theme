<?php
/**
 * Related Content partial template
 */
use CN\App\Fields\ACF;
use CN\App\Fields\Util;
use CN\App\Media;

// this template partial requires the post_id and post type to be set in order to function correctly
$post_id = $args['data']['post_id'];
$post_type = $args['data']['post_type'];
$has_post_id = isset( $post_id ) && ! empty( $post_id );
$has_post_type = isset( $post_type ) && ! empty( $post_type );

if ( !$has_post_id || !$has_post_type ) {
  return;
}

// Related content
$article_tags = get_the_terms($post_id, 'article-tag');
$performance_products = get_the_terms($post_id, 'performance-product');
// if there are no tags, this section is not needed. Return early.
if ( empty($article_tags) ) {
  return;
}

$tag_array = array();
$tag_filter = '';

foreach ($article_tags as $tag) {
  array_push($tag_array, $tag->slug);
  $tag_filter .= $tag->slug . ',';
}
$args = array(
    'post_type' => $post_type,
    'post__not_in' => array($post_id),
    'posts_per_page' => 6,
    'tax_query' => array(
        array(
            'taxonomy' => 'article-tag',
            'field'    => 'slug',
            'terms'    => $tag_array
        ),
    )
);

$post_count = 1;
$related_posts = get_posts( $args );

$mentioned_performance_products = [];
if ( !empty($performance_products) ) {
  foreach ($performance_products as $performance_product) {
    array_push($mentioned_performance_products, $performance_product->slug);
  }


  $fetched_performance_products = new \WP_Query([
    'post_type' => 'performance-products',
    'posts_per_page' => -1,
    'order' => 'ASC'
  ]);
  $linked_performance_products = array();

  if ($fetched_performance_products->have_posts()) {
    foreach ($fetched_performance_products->posts as $fetched_performance_product) {
        $name = $fetched_performance_product->post_name;
        if (in_array($name, $mentioned_performance_products)) {
            $pp_data = ACF::getPostMeta($fetched_performance_product->ID);
            $slug = ACF::getField('performance_product_slug', $pp_data);
            $tagline = ACF::getField('tagline', $pp_data);
            $logo_id = ACF::getField('card-logo', $pp_data);
            $bg_color = ACF::getField('color', $pp_data);
            $text_color = ACF::getField('text-color', $pp_data);
            $formatted_name = ACF::getField('name', $pp_data);

            $pp_definition = array(
                'name' => $name,
                'slug' => $slug,
                'tagline' => $tagline,
                'logo_id' => $logo_id,
                'formatted_name' => $formatted_name,
                'bg_color' => $bg_color,
                'text_color' => $text_color,
            );

            $linked_performance_products[] = $pp_definition;
        }
    }
  }
}

?>

<div class="related-content-partial uk-grid uk-grid-large" uk-grid>
  <?php if (!empty($related_posts)) { ?>
    <div class="uk-width-1-3@m uk-width-1-1@s related-content-partial__related-content">
      <div class="related-content-list">
        <h3 class="related-content-list__title"><?php _e('RELATED CONTENT:'); ?></h3>
        <ul role="list">
          <?php foreach($related_posts as $related_post) {
            // TODO: this loop should be refactored, possibly with a while loop
              $post_name = $related_post->post_title;
              $post_slug = $related_post->post_name;

              if ($post_count <= 5 ) { ?>
                  <li role="listitem"><a href="/resource-library/<?php echo esc_attr($post_slug); ?>" class="related-content-list__post-link"><?php echo esc_html($post_name); ?></a></li>
              <?php }

              if ($post_count === 6) { ?>
                  <li role="listitem"><a href="/resource-library?tags=<?php echo esc_attr($tag_filter); ?>" class="related-content-list__post-link"><?php _e('Show All', 'kmag'); ?></a></li>
              <?php }

              $post_count++;
          } ?>
        </ul>
      </div>
    </div>
  <?php } ?>
</div>