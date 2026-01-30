<?php
/**
 * ACF Module: Wysiwyg
 *
 * @global $data
 */

use CN\App\Fields\ACF;

$content  = ACF::getField('content', $data);

do_action('cn/modules/styles', $row_id, $data);
?>

<div class="module wysiwyg" id="<?php echo esc_attr($row_id); ?>">
    <div class="uk-container uk-container-large">
        <?php echo apply_filters('the_content', $content); ?>
    </div>
</div>