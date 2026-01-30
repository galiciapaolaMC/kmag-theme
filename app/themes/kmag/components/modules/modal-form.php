<?php
/**
 *  Gated Content partial template
 */

use CN\App\Fields\ACF;
use CN\App\Fields\Options;

$title = ACF::getField('title', $data);
$embedded_content = ACF::getField('embedded-content', $data);

?>

<div class="module modal-form" id="<?php echo esc_attr($row_id); ?>">
    <div class="uk-container uk-container-large">
        <?php echo do_shortcode('[mc_modal trigger_type="event" event_name="gated-content-event" modal_height="sm"]<div class="gated-content__form"><button class="uk-modal-close-default" id="close-modal-form" type="button" uk-close></button><h3>' . esc_html($title) . '</h3>' . $embedded_content . '</div>[/mc_modal]'); ?>
    </div>
</div>
