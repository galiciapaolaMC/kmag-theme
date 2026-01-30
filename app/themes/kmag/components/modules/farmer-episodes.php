<?php
/**
 * ACF Module: Farmer Episodes
 *
 * @global $data
 */

use CN\App\Fields\ACF;
use CN\App\Media;

$show_episodes = ACF::getField('show-episodes', $data);
$headline = ACF::getField('headline', $data);
$farmer_id = get_the_ID();
$episode_ids = array();

if ($show_episodes === 'no') {
    return;
}

$args = array(
    'post_type' => ['sherry-show-episodes', 'frontier-fields-eps'],
    'post_status' => 'publish',
    'posts_per_page' => -1
);

$query = new \WP_Query($args);

while ($query->have_posts()) :
    $query->the_post();
    $post_id = get_the_ID();
    $meta = ACF::getPostMeta($post_id);
    $associated_farmers = ACF::getField('associated-farmers', $meta);
    
    if (empty($associated_farmers)) {
        return;
    } else {
        foreach ($associated_farmers as $farmer) {
            if (intval($farmer) === $farmer_id) {
                $episode_ids[] = $post_id;
            }
        }
    }
endwhile; 

array_unique($episode_ids);

if (empty($episode_ids)) {
    return;
}

do_action('cn/modules/styles', $row_id, $data);
?>

<div class="module farmer-episodes" id="<?php echo esc_attr($row_id); ?>">
    <div class="uk-container uk-container-large">
        <?php if (!empty($headline)) { ?>
            <h2 class="farmer-episodes__headline hdg hdg--3"><?php echo esc_html($headline); ?></h2>
        <?php } ?>

        <div class="farmer-episodes__container">
            <div class="uk-grid uk-grid-medium uk-grid-match uk-child-width-1-4@m uk-child-width-1-2" uk-grid>
                <?php $args = array(
                    'post_type' => ['sherry-show-episodes', 'frontier-fields-eps'],
                    'post__in' => $episode_ids,
                    'post_status' => 'publish',
                    'posts_per_page' => -1
                );

                $query = new \WP_Query($args);

                while ($query->have_posts()) :
                    $query->the_post();
                    $post_id = get_the_ID();
                    $meta = ACF::getPostMeta($post_id);
                    $episode_link = get_permalink($post_id);
                    $episode_title = ACF::getField('episode-title', $meta);  
                    $episode_thumbnail_id = ACF::getField('episode-thumbnail', $meta);
                    $episode_image = Media::getAttachmentByID($episode_thumbnail_id);
                    
                    ?>
            
                    <div class="farmer-episodes__card-wrapper">
                        <a href="<?php echo esc_url($episode_link); ?>" class="farmer-episodes__card">
                            <div class="image" style="background-image: url(<?php echo esc_url($episode_image->url); ?>)"></div>
                            <p class="title"><?php echo esc_html($episode_title); ?></p>
                        </a>
                    </div> 
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</div>
