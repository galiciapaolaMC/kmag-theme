<?php
/**
 * ACF Module: Anchor Link
 *
 * @global $data
 */

use CN\App\Fields\ACF;

$anchor_title = ACF::getField('anchor-title', $data);

?>

<div class="module anchor-link" data-anchor="<?php echo esc_attr($anchor_title); ?>">
</div>