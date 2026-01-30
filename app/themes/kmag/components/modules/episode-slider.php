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

$countries = get_terms([
    'taxonomy' => 'episode-country',
    'hide_empty' => true,
]); 

$farmers = array();
$args = array(
    'post_type' => 'farmer-profiles',
    'post_status' => 'publish',
    'posts_per_page' => -1
);

$query = new \WP_Query($args);

while ($query->have_posts()) :
    $query->the_post();
    $post_id = get_the_ID();
    $meta = ACF::getPostMeta($post_id);
    $farmer_name = get_the_title($post_id);
    $farmer_post = get_post($post_id);
    $farmer_slug = $farmer_post->post_name;
    
    $farmers[] = array(
        'name' => $farmer_name,
        'slug' => $farmer_slug,
        'farmer_id' => $post_id
    );
endwhile;

$episode_listings = ACF::getRowsLayout('episode-listings', $data); 
?>

<div class="filter-container">
    <p class="filter-text"><?php _e('Filter:', 'kmag'); ?></p>

    <?php if (!empty($farmers)) { ?>
        <div class="filter farmer-filter slider-filter">
            <label for="farmer" class="dropdown-label form-control toggle-next ellipsis">
                <?php _e('Farmer', 'kmag'); ?>                                
                <svg class="icon icon-filter-select-dropdown">
                    <use xlink:href="#icon-filter-select-dropdown"></use>
                </svg>
            </label>
            <div class="dropdown-wrapper hidden">
                <div class="apply-wrapper apply-wrapper-slider"><input type="submit" name="submit" value="Apply"></div>

                <?php foreach ($farmers as $farmer) { ?>
                    <div class="options-wrapper">
                        <div class="select-option-wrapper">
                            <input class="<?php echo esc_attr($farmer['slug']); ?>" type="checkbox" id="<?php echo esc_attr($farmer['slug']); ?>" value="<?php echo esc_attr($farmer['farmer_id']); ?>" name="farmer">
                            <label for="<?php echo esc_attr($farmer['slug']); ?>"><?php echo esc_html($farmer['name']); ?></label>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php } ?>

    <?php if (!empty($show_season)) { ?>
        <div class="filter episode-season-filter slider-filter">
            <label for="episode-season" class="dropdown-label form-control toggle-next ellipsis">
                <?php _e('Growing Season', 'kmag'); ?>                                
                <svg class="icon icon-filter-select-dropdown">
                    <use xlink:href="#icon-filter-select-dropdown"></use>
                </svg>
            </label>
            <div class="dropdown-wrapper hidden">
                <div class="apply-wrapper apply-wrapper-slider"><input type="submit" name="submit" value="Apply"></div>

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
    <?php } ?>

    <?php if (!empty($agronomy_topics)) { ?>
        <div class="filter agronomy-topic-filter slider-filter">
            <label for="agronomy-topic" class="dropdown-label form-control toggle-next ellipsis">
                <?php _e('Agronomy Topic', 'kmag'); ?>                                
                <svg class="icon icon-filter-select-dropdown">
                    <use xlink:href="#icon-filter-select-dropdown"></use>
                </svg>
            </label>
            <div class="dropdown-wrapper hidden">
                <div class="apply-wrapper apply-wrapper-slider"><input type="submit" name="submit" value="Apply"></div>

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

    <?php if (!empty($countries)) { ?>
        <div class="filter episode-country-filter slider-filter">
            <label for="episode-country" class="dropdown-label form-control toggle-next ellipsis">
                <?php _e('Country', 'kmag'); ?>                                
                <svg class="icon icon-filter-select-dropdown">
                    <use xlink:href="#icon-filter-select-dropdown"></use>
                </svg>
            </label>
            <div class="dropdown-wrapper hidden">
                <div class="apply-wrapper apply-wrapper-slider"><input type="submit" name="submit" value="Apply"></div>

                <?php foreach ($countries as $country) { ?>
                    <div class="options-wrapper">
                        <div class="select-option-wrapper">
                            <input class="<?php echo esc_attr($country->slug); ?>" type="checkbox" id="<?php echo esc_attr($country->slug); ?>" value="<?php echo esc_attr($country->slug); ?>" name="episode-country">
                            <label for="<?php echo esc_attr($country->slug); ?>"><?php echo esc_html($country->name); ?></label>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
</div>

<?php foreach ($episode_listings as $episodes) {
    $headline = ACF::getField('headline', $episodes); 
    $episode_type = ACF::getField('episode-type', $episodes); ?>
    
    <div class="episode-slider">
        <?php if ($headline) { ?>
            <h2 class="episode-filtering__headline hdg hdg--3"><?php echo esc_html($headline); ?></h2>
        <?php } ?>

        <?php if ($episode_type === 'video') { ?>
            <div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1" uk-slider>
                <div class="uk-slider-items uk-grid uk-grid-match uk-child-width-1-4@m uk-child-width-1-2@s uk-child-width-1-1 video-filter-container">
                    <?php
                    if (isset($_GET['country'])) {
                        $args = array(
                            'post_type' => 'frontier-fields-eps',
                            'episode-type' => 'video',
                            'post_status' => 'publish',
                            'posts_per_page' => -1,
                            'tax_query' => array(
                                    array(
                                        'taxonomy' => 'episode-country',
                                        'field' => 'slug',
                                        'terms' => $_GET['country'],
                                    ),
                                ),
                        );
                    } else {
                        $args = array(
                            'post_type' => 'frontier-fields-eps',
                            'episode-type' => 'video',
                            'post_status' => 'publish',
                            'posts_per_page' => -1,
                            
                        );
                    }

                    $query = new \WP_Query($args);

                    while ($query->have_posts()) :
                        $query->the_post();
                        $post_id = get_the_ID();
                        // get the post type
                        $post_type = get_post_type($post_id);
                        $meta = ACF::getPostMeta($post_id);
                        $episode_number = ACF::getField('episode-number', $meta);
                        $episode_link = get_permalink($post_id);
                        $episode_title = ACF::getField('episode-title', $meta);  
                        $episode_thumbnail_id = ACF::getField('episode-thumbnail', $meta);
                        $episode_image = Media::getAttachmentByID($episode_thumbnail_id);
                        $season = get_the_terms($post_id, 'show-season')[0]->name;
                        
                        ?>
    
                        <div>
                            <a href="<?php echo esc_url($episode_link); ?>" class="episode-filtering__grid-card">
                                <div class="image" style="background-image: url(<?php echo esc_url($episode_image->url); ?>)"></div>
                                <p class="title"><?php echo esc_html($episode_title); ?></p>
                                <p class="episode-number"><?php echo esc_html($season); ?>  <?php _e('| Episode', 'kmag'); ?> <?php echo esc_html($episode_number); ?></p>
                            </a>
                        </div>
                    
                    <?php endwhile; ?>
                </div>

                <div class="button-container">
                    <button class="uk-position-small" uk-slidenav-previous uk-slider-item="previous"></button>
                    <button class="uk-position-small next-button" uk-slidenav-next uk-slider-item="next"></button>
                </div>
            </div>
        <?php } ?>

        <?php if ($episode_type === 'audio') { ?>
            <div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1" uk-slider>
                <div class="uk-slider-items uk-grid uk-grid-match uk-child-width-1-4@m uk-child-width-1-2@s uk-child-width-1-1 audio-filter-container">
                    <?php $show_season = get_terms([
                        'taxonomy' => 'show-season',
                        'hide_empty' => true,
                        'orderby' => 'name',
                        'order' => 'DESC'
                    ]);

                    $audio_post_ids = array();
                    
                    foreach ($show_season as $season) {
                        if (isset($_GET['country'])) {
                            $args = array(
                                'post_type' => 'frontier-fields-eps',
                                'episode-type' => 'audio',
                                'post_status' => 'publish',
                                'posts_per_page' => -1,
                                'tax_query' => array(
                                    array(
                                        'taxonomy' => 'show-season',
                                        'field' => 'slug',
                                        'terms' => $season->slug,
                                    ),
                                    array(
                                        'taxonomy' => 'episode-country',
                                        'field' => 'slug',
                                        'terms' => $_GET['country'],
                                    ),
                                ),
                            );
                        } else {
                            $args = array(
                                'post_type' => 'frontier-fields-eps',
                                'episode-type' => 'audio',
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
                        }

                        $query = new \WP_Query($args);
                        
                        $order_episodes = array();

                        while ($query->have_posts()) :
                            $query->the_post();
                            $post_id = get_the_ID();
                            $meta = ACF::getPostMeta($post_id);
                            $episode_number = ACF::getField('episode-number', $meta);

                            $order_episodes[$episode_number] = $post_id;

                            if (!empty($episode_number)) {
                                $audio_post_ids[] = $post_id;
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
                            $season = get_the_terms($episode, 'show-season')[0]->name;
                            
                            ?>
    
                            <div>
                                <a href="<?php echo esc_url($episode_link); ?>" class="episode-filtering__grid-card">
                                    <div class="image" style="background-image: url(<?php echo esc_url($episode_image->url); ?>)"></div>
                                    <p class="title"><?php echo esc_html($episode_title); ?></p>
                                    <p class="episode-number"><?php echo esc_html($season); ?>  <?php _e('| Update', 'kmag'); ?> <?php echo esc_html($episode_number); ?></p>
                                </a>
                            </div>
                        
                        <?php 
                        }
                    } ?>

                    <?php 
                    if (isset($_GET['country'])) {
                        $args = array(
                            'post_type' => 'frontier-fields-eps',
                            'episode-type' => 'audio',
                            'post_status' => 'publish',
                            'posts_per_page' => -1,
                            'post__not_in' => $audio_post_ids,
                            'tax_query' => array(
                                    array(
                                        'taxonomy' => 'episode-country',
                                        'field' => 'slug',
                                        'terms' => $_GET['country'],
                                    ),
                                ),
                        );
                    } else {
                        $args = array(
                            'post_type' => 'frontier-fields-eps',
                            'episode-type' => 'audio',
                            'post_status' => 'publish',
                            'posts_per_page' => -1,
                            'post__not_in' => $audio_post_ids
                        );
                    }

                    $query = new \WP_Query($args);

                    while ($query->have_posts()) :
                        $query->the_post();
                        $post_id = get_the_ID();
                        $meta = ACF::getPostMeta($post_id);
                        $episode_number = ACF::getField('episode-number', $meta);
                        $episode_link = get_permalink($post_id);
                        $episode_title = ACF::getField('episode-title', $meta);  
                        $episode_thumbnail_id = ACF::getField('episode-thumbnail', $meta);
                        $episode_image = Media::getAttachmentByID($episode_thumbnail_id);
                        $season = get_the_terms($post_id, 'show-season')[0]->name;
                        
                        ?>
    
                        <div>
                            <a href="<?php echo esc_url($episode_link); ?>" class="episode-filtering__grid-card">
                                <div class="image" style="background-image: url(<?php echo esc_url($episode_image->url); ?>)"></div>
                                <p class="title"><?php echo esc_html($episode_title); ?></p>
                                <p class="episode-number"><?php echo esc_html($season); ?>  <?php _e('| Episode', 'kmag'); ?> <?php echo esc_html($episode_number); ?></p>
                            </a>
                        </div>
                    <?php endwhile; ?>
                </div>

                <div class="button-container">
                    <button class="uk-position-small" uk-slidenav-previous uk-slider-item="previous"></button>
                    <button class="uk-position-small next-button" uk-slidenav-next uk-slider-item="next"></button>
                </div>
            </div>
        <?php } ?>

        <?php if ($episode_type === 'farmer') { ?>
            <div class="uk-grid uk-grid-medium uk-grid-match uk-child-width-1-3@m uk-child-width-1-1 farmer-filter-container" uk-grid>
                <?php
                if (isset($_GET['country'])) {
                    $args = array(
                        'post_type' => 'farmer-profiles',
                        'post_status' => 'publish',
                        'posts_per_page' => -1,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'farmer-country',
                                'field' => 'slug',
                                'terms' => $_GET['country'],
                            ),
                        ),
                    );
                } else {
                    $args = array(
                        'post_type' => 'farmer-profiles',
                        'post_status' => 'publish',
                        'posts_per_page' => -1
                    );
                }

                $query = new \WP_Query($args);
                $farmers = 0;
                while ($query->have_posts()) :
                    $query->the_post();
                    $post_id = get_the_ID();
                    $meta = ACF::getPostMeta($post_id);
                    $farmer_link = get_permalink($post_id);
                    $farmer_name = get_the_title($post_id);
                    $farmer_location = ACF::getField('location', $meta);  
                    $farmer_thumbnail_id = get_post_thumbnail_id($post_id);
                    $farmer_image = Media::getAttachmentByID($farmer_thumbnail_id);
                    $hidden = 'uk-hidden';

                    if ($farmers <= 5) {
                        $hidden = '';
                    }
                    
                    ?>

                    <div class="farmer-container <?php echo $hidden; ?>">
                        <a href="<?php echo esc_url($farmer_link); ?>" class="episode-filtering__farmer-card">
                            <div class="image" style="background-image: url(<?php echo esc_url($farmer_image->url); ?>)"></div>
                            <p class="name"><?php echo esc_html($farmer_name); ?></p>
                            <p class="location"><?php echo esc_html($farmer_location); ?></p>
                        </a>
                    </div>

                <?php $farmers++;
                endwhile; ?>
            </div>

            <?php if ($farmers > 9) { ?>
                <button id="view-more-farmers"><?php _e('View more', 'kmag'); ?></button>
            <?php } ?>
        <?php } ?>
    </div>
<?php } ?>