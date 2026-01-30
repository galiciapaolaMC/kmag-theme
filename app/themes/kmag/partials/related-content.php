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
    <div class="uk-width-2-3@m uk-width-1-1@s related-topics-container">
      <h3 class="related-content-list__title"><?php _e('RELATED TOPICS:'); ?></h3>

      <ul role="list" class="related-content-list__related-tags-list">
          <?php foreach ($article_tags as $tag) {
              $tag_name = $tag->name;
              $tag_slug = $tag->slug; ?>

              <li role="listitem"><a href="/resource-library?tags=<?php echo esc_attr($tag_slug); ?>" class="tag-link"><?php echo esc_html($tag_name); ?></a></li>

          <?php } ?>
      </ul>
    </div>
  <?php } ?>
</div>
<div class="related-content-partial">
<?php if (!empty($performance_products) && count($linked_performance_products)) { ?>
  <div class="related-content-list">
    <div class="related-content-list__title-container">
      <h3 class="related-content-list__title"><?php _e('MENTIONED ON THIS PAGE'); ?></h3>
      <div class="related-content-list__controls">
        <button class="related-content-list__previous-button">
          <?php echo Util::getIconHTML('arrow-left')?>
        </button>
        <button class="related-content-list__next-button">
          <?php echo Util::getIconHTML('arrow-right')?>
        </button>
      </div>
    </div>
    <div class="related-performance-products">
        <?php
        foreach ($linked_performance_products as $key => $pp) {
            $logo_id = $pp['logo_id'];
            $logo_attachment = ! empty($logo_id) ? Media::getAttachmentByID($logo_id) : false;
            $logo_args = array('class' => 'related-performance-product__logo');
            $logo_html = ! empty($logo_attachment) ? Util::getImageHTML($logo_attachment, 'medium', $logo_args) : '';
            $slug = $pp['slug'];
            $class_name = "related-performance-product--" . $pp['name'];
            $data_visible = true;
            $text_color_class = $pp['text_color'] === 'light' ? 'related-performance-product--light-text' : 'related-performance-product--dark-text';
            $style = $pp['bg_color'] ? 'style="background-color: ' . $pp['bg_color'] . ';"' : '';
            // only show the first three products on page load
            if ($key >= 3) {
              $data_visible = false;
            }
        ?>
        <div
          class="related-performance-product <?php echo esc_attr($text_color_class)?>"
          data-pp-index="<?php echo esc_attr($key) ?>"
          <?php if ($data_visible) {
            echo 'data-pp-visible';
          } ?>
          <?php 
            echo $style;
          ?>     
        >
            <?php echo $logo_html ?>
                <p class="related-performance-product__tagline">
            <?php echo esc_html($pp['tagline']); ?>
            </p>
                <a class="related-performance-product__link" href="<?php echo esc_url($slug); ?>">
                <?php echo __('Go to ', 'kmag') . esc_html($pp['formatted_name'])?>
            </a>
        </div>
        <?php } ?>
    </div>
  </div>
<?php } ?>
</div>
