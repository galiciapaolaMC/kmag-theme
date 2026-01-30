<?php
/**
 * ACF Module: Episode Filtering
 *
 * @global $data
 */

use CN\App\Fields\ACF;
use CN\App\Media;

$agronomy_topics = get_terms([
    'taxonomy' => 'agronomy-topics',
    'hide_empty' => true,
]); 

$show_season = get_terms([
    'taxonomy' => 'season-option',
    'hide_empty' => true,
]); 

$show_filters = ACF::getField('show-filters', $data, 'false');
$headline = ACF::getField('headline', $data); ?>

<?php if ($show_filters === 'true') { ?>
    <div class="filter-container">
        <p class="filter-text"><?php _e('Filter:', 'kmag'); ?></p>
        <?php if (!empty($show_season)) { ?>
            <div class="filter episode-season-filter grid-filter">
                <label for="episode-season" class="dropdown-label form-control toggle-next ellipsis">
                    <?php _e('Growing Season', 'kmag'); ?>                                
                    <svg class="icon icon-filter-select-dropdown">
                        <use xlink:href="#icon-filter-select-dropdown"></use>
                    </svg>
                </label>
                <div class="dropdown-wrapper hidden">
                    <div class="apply-wrapper apply-wrapper-grid"><input type="submit" name="submit" value="Apply"></div>

                    <?php foreach ($show_season as $season) { ?>
                        <div class="options-wrapper">
                            <div class="select-option-wrapper">
                                <input class="<?php echo esc_attr($season->slug); ?>" type="checkbox" id="<?php echo esc_attr($season->slug); ?>" value="<?php echo esc_attr($season->slug); ?>" name="episode-season">
                                <label for="<?php echo esc_attr($season->slug); ?>"><?php echo esc_html($season->name); ?></label>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php } 
    
        if (!empty($agronomy_topics)) { ?>
            <div class="filter agronomy-topic-filter grid-filter">
                <label for="agronomy-topic" class="dropdown-label form-control toggle-next ellipsis">
                    <?php _e('Agronomy Topic', 'kmag'); ?>                                
                    <svg class="icon icon-filter-select-dropdown">
                        <use xlink:href="#icon-filter-select-dropdown"></use>
                    </svg>
                </label>
                <div class="dropdown-wrapper hidden">
                    <div class="apply-wrapper apply-wrapper-grid"><input type="submit" name="submit" value="Apply"></div>

                    <?php foreach ($agronomy_topics as $topic) { ?>
                        <div class="options-wrapper">
                            <div class="select-option-wrapper">
                                <input class="<?php echo esc_attr($topic->slug); ?>" type="checkbox" id="<?php echo esc_attr($topic->slug); ?>" value="<?php echo esc_attr($topic->slug); ?>" name="agronomy-topic">
                                <label for="<?php echo esc_attr($topic->slug); ?>"><?php echo esc_html($topic->name); ?></label>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    </div>
<?php } ?>

<?php if ($headline) { ?>
    <h2 class="episode-filtering__headline hdg hdg--3"><?php echo esc_html($headline); ?></h2>
<?php } ?>

<div class="uk-grid uk-grid-medium uk-grid-match uk-child-width-1-4@m uk-child-width-1-2 grid-filter-container" uk-grid>
    <?php 
    $show_season = get_terms([
        'taxonomy' => 'show-season',
        'hide_empty' => true,
        'orderby' => 'name',
        'order' => 'DESC'
    ]);

    $post_ids = array();
    
    foreach ($show_season as $season) {
        $args = array(
            'post_type' => 'sherry-show-episodes',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'tax_query' => array(
                array(
                    'taxonomy' => 'show-season',
                    'field' => 'slug',
                    'terms' => $season->slug,
                ),
            ),
        );

        $query = new \WP_Query($args);
        
        $order_episodes = array();

        while ($query->have_posts()) :
            $query->the_post();
            $post_id = get_the_ID();
            $meta = ACF::getPostMeta($post_id);
            $episode_number = ACF::getField('episode-number', $meta);

            $order_episodes[$episode_number] = $post_id;

            if (!empty($episode_number)) {
                $post_ids[] = $post_id;
            }
        endwhile;

        krsort($order_episodes);

        foreach ($order_episodes as $episode) {
            $meta = ACF::getPostMeta($episode);
            $episode_link = get_permalink($episode);
            $episode_title = ACF::getField('episode-title', $meta);  
            $episode_number = ACF::getField('episode-number', $meta);
            $episode_thumbnail_id = ACF::getField('episode-thumbnail', $meta);
            $episode_image = Media::getAttachmentByID($episode_thumbnail_id);
            
            ?>

            <div class="episode-filtering__grid-card-wrapper">
                <a href="<?php echo esc_url($episode_link); ?>" class="episode-filtering__grid-card">
                    <div class="image" style="background-image: url(<?php echo esc_url($episode_image->url); ?>)"></div>
                    <p class="title"><?php echo esc_html($episode_title); ?></p>
                    <p class="episode-number"><?php _e('Episode', 'kmag'); ?> <?php echo esc_html($episode_number); ?></p>
                </a>
            </div>
    <?php }
    } 

    $args = array(
        'post_type' => 'sherry-show-episodes',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'post__not_in' => $post_ids
    );

    $query = new \WP_Query($args);

    while ($query->have_posts()) :
        $query->the_post();
        $post_id = get_the_ID();
        $meta = ACF::getPostMeta($post_id);
        $episode_link = get_permalink($post_id);
        $episode_title = ACF::getField('episode-title', $meta);  
        $episode_number = ACF::getField('episode-number', $meta);
        $episode_thumbnail_id = ACF::getField('episode-thumbnail', $meta);
        $episode_image = Media::getAttachmentByID($episode_thumbnail_id);
        
        ?>

        <div class="episode-filtering__grid-card-wrapper">
            <a href="<?php echo esc_url($episode_link); ?>" class="episode-filtering__grid-card">
                <div class="image" style="background-image: url(<?php echo esc_url($episode_image->url); ?>)"></div>
                <p class="title"><?php echo esc_html($episode_title); ?></p>
                <p class="episode-number"><?php _e('Episode', 'kmag'); ?> <?php echo esc_html($episode_number); ?></p>
            </a>
        </div>
    <?php endwhile; ?>
</div>