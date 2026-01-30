<?php
/**
 * ACF Module: Full Width Graphic
 *
 * @global $data
 */

use CN\App\Fields\ACF;
use CN\App\Media;
use CN\App\Fields\Util;

$graphic_id = ACF::getField('graphic', $data);
$width = ACF::getField('width', $data, '100');
$dynamic_display = ACF::getField('dynamic-display', $data);

if (! $graphic_id) {
    return;
}

$dynamic_display_class = '';
if ($dynamic_display !== 'none') {
    $dynamic_display_class = " $dynamic_display";
}

$image = Media::getAttachmentByID($graphic_id);

do_action('cn/modules/styles', $row_id, $data);
?>

<div class="module full-width-graphic<?php echo esc_attr($dynamic_display_class); ?>" id="<?php echo esc_attr($row_id); ?>">
    <div class="uk-container">
        <div class="module__image">
            <img src="<?php echo esc_url($image->url); ?>" style="width: <?php echo esc_attr($width); ?>%;" alt="<?php echo esc_attr($image->alt); ?>" />
        </div>
    </div>
</div>
