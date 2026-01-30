<?php

/**
 * ACF Module: Content Block
 *
 * @global $data
 */

use CN\App\Fields\ACF;
use CN\App\Fields\Util;

$quote_content = ACF::getField('quote-content', $data);
$author_name = ACF::getField('author-name', $data);

do_action('cn/modules/styles', $row_id, $data);
?>

<div class="module quote-block<?php echo esc_attr($dynamic_display_class); ?>" id="<?php echo esc_attr($row_id); ?>">
    <div class="uk-container">
        <div class="quote-container" style="max-width:750px;">
            <div class="quote">
                <?php if (!empty($quote_content)){
                    echo '<h3>"'.esc_html($quote_content).'"</h3>';
                }?>
            </div>
            <?php if (!empty($author_name)):?>
            <div class="author" style="margin-top:10px;">
                <span style="font-weight:700">
                    <?php 
                echo "- ".esc_html($author_name);
            ?>
                </span>
            </div>
            <?php endif;?>
        </div>
    </div>
</div>