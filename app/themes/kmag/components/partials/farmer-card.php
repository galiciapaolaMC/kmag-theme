<?php
/**
 * ACF Module Partial: Farmer Card
 *
 * @global WP_Post $card
 */

use CN\App\Fields\ACF;
use CN\App\Media;

$meta = ACF::getPostMeta($card);
$farmer_link = get_permalink($card);
$farmer_name = get_the_title($card);
$farmer_location = ACF::getField('location', $meta);  
$farmer_thumbnail_id = get_post_thumbnail_id($card);
$farmer_image = Media::getAttachmentByID($farmer_thumbnail_id);
$hidden = 'uk-hidden';

?>

<div class="farmer-container">
    <a href="<?php echo esc_url($farmer_link); ?>" class="episode-filtering__farmer-card">
        <div class="image" style="background-image: url(<?php echo esc_url($farmer_image->url); ?>)"></div>
        <p class="name"><?php echo esc_html($farmer_name); ?></p>
        <p class="location"><?php echo esc_html($farmer_location); ?></p>
    </a>
</div>