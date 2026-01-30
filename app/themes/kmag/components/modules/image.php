<?php
/**
 * ACF Module: Image
 *
 * @global $data
 */

use CN\App\Fields\ACF;
use CN\App\Media;
use CN\App\Fields\Util;

$image = ACF::getField('image', $data);

if (! $image) {
    return;
}

do_action('cn/modules/styles', $row_id, $data);
?>

<div class="module image" id="<?php echo esc_attr($row_id); ?>">
    <div class="uk-container">
        <div class="module__image">
            <?php echo Util::getImageHTML(Media::getAttachmentByID($image)); ?>
        </div>
    </div>
</div>
