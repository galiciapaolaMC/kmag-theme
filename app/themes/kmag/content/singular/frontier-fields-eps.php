<?php
/**
 * The template used for displaying th Frontier Fields Episode
 *
 * @package CN
 */

use CN\App\Media;
use CN\App\Fields\ACF;
use CN\App\Fields\Util;
 
$post_id = get_the_ID();
$data = ACF::getPostMeta($post_id);
$episode_title = ACF::getField('episode-title', $data);
$episode_description = ACF::getField('episode-description', $data);
$episode_link = ACF::getField('episode-link', $data);
$associated_farmers = ACF::getField('associated-farmers', $data);
$episode_number = ACF::getField('episode-number', $data);
$season = get_the_terms($post_id, 'show-season')[0]->slug;
$episode_type = get_the_terms($post_id, 'episode-type')[0]->slug;

$next_episode = intval($episode_number) + 1;
$prev_episode = intval($episode_number) - 1;
$next_id = null;
$prev_id = null;

$args = array(
    'post_type' => 'frontier-fields-eps',
    'episode-type' => $episode_type,
    'show-season' => $season,
    'post_status' => 'publish',
    'posts_per_page' => 1,
    'meta_query' => array(
        array(
            'key' => 'episode-number',
            'value' => $prev_episode,
            'compare' => '=',
        ),
    ),
);

$prev_query = new \WP_Query($args);

if ($prev_query->have_posts()) {
    $prev_query->the_post();
    $prev_id = get_the_ID();
}

$args = array(
    'post_type' => 'frontier-fields-eps',
    'episode-type' => $episode_type,
    'show-season' => $season,
    'post_status' => 'publish',
    'posts_per_page' => 1,
    'meta_query' => array(
        array(
            'key' => 'episode-number',
            'value' => $next_episode,
            'compare' => '=',
        ),
    ),
);

$next_query = new \WP_Query($args);

if ($next_query->have_posts()) {
    $next_query->the_post();
    $next_id = get_the_ID();
}

if ($prev_id == null) {
    $season_int = str_replace('s', '', $season);
    if (intval($season_int) > 1) {
        $season_int = intval($season_int) - 1;

        if ($season_int < 10) {
            $season = 's0' . $season_int;
        } else {
            $season = 's' . $season_int;
        }

        $args = array(
            'post_type' => 'frontier-fields-eps',
            'episode-type' => $episode_type,
            'show-season' => $season,
            'post_status' => 'publish',
            'posts_per_page' => 1,
            'meta_key' => 'episode-number',
            'orderby' => 'meta_value_num',
            'order' => 'DESC',
            'post__not_in' => array($post_id),
        );

        $prev_query = new \WP_Query($args);

        if ($prev_query->have_posts()) {
            $prev_query->the_post();
            $prev_id = get_the_ID();
        }
    }
}

if ($next_id == null) {
    $season_int = str_replace('s', '', $season);
    
    if (intval($season_int) >= 1) {
        $season_int = intval($season_int) + 1;

        if ($season_int < 10) {
            $season = 's0' . $season_int;
        } else {
            $season = 's' . $season_int;
        }

        $args = array(
            'post_type' => 'frontier-fields-eps',
            'episode-type' => $episode_type,
            'show-season' => $season,
            'post_status' => 'publish',
            'posts_per_page' => 1,
            'meta_key' => 'episode-number',
            'orderby' => 'meta_value_num',
            'order' => 'ASC',
            'post__not_in' => array($post_id),
        );

        $next_query = new \WP_Query($args);

        if ($next_query->have_posts()) {
            $next_query->the_post();
            $next_id = get_the_ID();
        }
    }
}

?>

<article id="post-<?php the_ID(); ?>" class="frontier-fields-episode" data-post-type="frontier-fields-episode">
    <div class="frontier-fields-episode__container">
        <div class="uk-container uk-container-large">
            <h1 class="frontier-fields-episode__title"><?php echo esc_html($episode_title); ?></h1>

            <?php if (!empty($episode_description)) { ?>
                <div class="frontier-fields-episode__description">
                    <?php echo wpautop($episode_description); ?>
                </div>
            <?php } ?>
        
            <?php if (!empty($episode_link)) { ?> 
                <div class="frontier-fields-episode__video">
                    <iframe src="<?php echo esc_url($episode_link); ?>" width="1920" height="1080" allowfullscreen uk-responsive uk-video="automute: false; autoplay: false;"></iframe>
                </div>
            <?php } ?>

            <?php if (!empty($prev_id) || !empty($next_id)) { ?>
                <div class="module split-banner">
                    <div class="split-banner__short-content-banner">
                        <div class="uk-grid uk-grid-large uk-child-width-1-2@m uk-child-width-1-1@s uk-grid-match image-left">
                            <?php if (!empty($prev_id)) { 
                                $previous_data = ACF::getPostMeta($prev_id);
                                $episode_link = get_permalink($prev_id);
                                $episode_title = ACF::getField('episode-title', $previous_data);  
                                $episode_number = ACF::getField('episode-number', $previous_data);
                                $episode_thumbnail_id = ACF::getField('episode-thumbnail', $previous_data);
                                $episode_image = Media::getAttachmentByID($episode_thumbnail_id);
                                $season = get_the_terms($prev_id, 'show-season')[0]->name;
                                
                                ?> 
                                <div class="split-banner__content uk-inline image-left">
                                    <div class="split-banner__color-block">
                                        <div class="uk-grid uk-grid-medium uk-grid-match" uk-grid>
                                            <div class="uk-width-1-2@s uk-width-1-1">
                                                <div class="image-container">
                                                    <div class="split-banner__image" style="background-image: url(<?php echo esc_url($episode_image->url); ?>)"></div>
                                                </div>
                                            </div>

                                            <div class="uk-width-1-2@s uk-width-1-1">
                                                <div class="split-banner__content-container font-color-black">
                                                    <p><?php echo esc_html($season); ?> <?php _e('| Update ', 'kmag'); ?> <?php echo esc_html($episode_number); ?></p>
                                                    <h2 class="headline"><?php echo esc_html($episode_title ); ?></h2>
                                                    <a href="<?php echo esc_url($episode_link); ?>" class="btn btn--small btn--secondary"><?php _e('< Play Previous Update', 'kmag'); ?></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>    
                            <?php } ?>

                            <?php if (!empty($next_id)) { 
                                $next_data = ACF::getPostMeta($next_id);
                                $episode_link = get_permalink($next_id);
                                $episode_title = ACF::getField('episode-title', $next_data);  
                                $episode_number = ACF::getField('episode-number', $next_data);
                                $episode_thumbnail_id = ACF::getField('episode-thumbnail', $next_data);
                                $episode_image = Media::getAttachmentByID($episode_thumbnail_id);
                                $season = get_the_terms($next_id, 'show-season')[0]->name;
                                
                                ?> 
                                <div class="split-banner__content second-content-block uk-inline">
                                    <div class="split-banner__color-block">
                                        <div class="uk-grid uk-grid-medium uk-grid-match" uk-grid>
                                            <div class="uk-width-1-2@m uk-width-1-1@s">
                                                <div class="split-banner__content-container font-color-black">
                                                    <p><?php echo esc_html($season); ?> <?php _e('| Update ', 'kmag'); ?> <?php echo esc_html($episode_number); ?></p>
                                                    <h2 class="headline"><?php echo esc_html($episode_title ); ?></h2>
                                                    <a href="<?php echo esc_url($episode_link); ?>" class="btn btn--small btn--secondary"><?php _e('Play Next Update >', 'kmag'); ?></a>
                                                </div>
                                            </div>

                                            <div class="uk-width-1-2@m uk-width-1-1@s">
                                                <div class="image-container">
                                                    <div class="split-banner__image" style="background-image: url(<?php echo esc_url($episode_image->url); ?>)"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>    
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <?php if (!empty($associated_farmers)) { ?>
                <div class="frontier-fields-episode__farmers">
                    <h2 class="frontier-fields-episode__farmers-title"><?php _e('Meet the Frontier Fields Farmers in this Episode', 'kmag'); ?></h2>

                    <div class="uk-grid uk-grid-medium uk-child-width-1-3@m uk-widht-1-2" uk-grid>
                        <?php foreach ($associated_farmers as $farmer) {
                            $farmer_data = ACF::getPostMeta($farmer);
                            $name = get_the_title($farmer);
                            $farmer_link = get_permalink($farmer);
                            $location = ACF::getField('location', $farmer_data); 
                            $image_id = get_post_thumbnail_id($farmer);
                            $image = Media::getAttachmentByID($image_id)
                            ?>

                            <div>
                                <a href="<?php echo esc_url($farmer_link); ?>" class="farmer-card">
                                    <div class="farmer-card__image" style="background-image: url(<?php echo esc_url($image->url); ?>)"></div>
                                    <h3 class="farmer-card__name"><?php echo esc_html($name); ?></h3>
                                    <p class="farmer-card__location"><?php echo esc_html($location); ?></p>
                                </a>
                            </div>
                        <?php } ?> 
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</article>

<?php do_action('cn/modules/output', get_the_ID()); ?>