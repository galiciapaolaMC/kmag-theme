<?php
/**
 * ACF Module Partial: Episode Card
 *
 * @global WP_Post $card
 */

use CN\App\Fields\ACF;
use CN\App\Media;

$meta = ACF::getPostMeta($card);
$episode_link = get_permalink($card);
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