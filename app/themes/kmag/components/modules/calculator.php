<?php

/**
 * ACF Module: Calculator
 *
 * @global $data
 */

use CN\App\Fields\ACF;
use CN\App\Fields\Util;

do_action('cn/modules/styles', $row_id, $data);
if ($data["page"] != "") {
    $acfData = ACF::getPostMeta($data["page"]);
    $calculatorSource = ACF::getField('calculator-source', $acfData);
} else {
    $calculatorSource = "vue-plugin";
}
?>

<div class="module calculator" id="<?php echo esc_attr($row_id); ?>">
    <?php
    if ($calculatorSource == "vue-plugin") { ?>
        <div id="app">Stuff Goes Here</div>
    <?php echo do_shortcode('[mos_cn_vue_wp_plugin]');
    } else if ($calculatorSource == "wordpress") {
        $file = locate_template("partials/bio-science-calculator.php");
        if (file_exists($file)) {
            include $file;
        }
    }

    ?>
</div>