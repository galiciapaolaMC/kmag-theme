<?php
/**
 * ACF Module: Announcement Bar
 *
 * @global $data
 */

use CN\App\Fields\ACF;
use CN\App\Fields\Util;

$data = ACF::getPostMeta(get_the_ID());
$content = ACF::getField('announcement-bar_content', $data);
$background_color = ACF::getField('announcement-bar_background-color', $data);

if (empty($content)) {
    return;
}

?>

<div class="module announcement-bar <?php echo esc_attr($background_color); ?>">
    <div class="uk-container uk-container-large">
        <div class="announcement-bar__content">
            <?php echo apply_filters('the_content', $content); ?>
        </div>
    </div>
</div>