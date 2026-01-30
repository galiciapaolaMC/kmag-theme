<?php
/**
 * ACF Module: Content Area
 *
 * @global $data
 */

use CN\App\Fields\ACF;
use CN\App\Fields\Util;

$headline = ACF::getField('headline', $data);
$content  = ACF::getField('content', $data);
$dynamic_display = ACF::getField('dynamic-display', $data);

$content_blocks = ACF::getRowsLayout('content-area-block', $data);

if (empty($content_blocks)) {
    return;
}

$dynamic_display_class = '';
if ($dynamic_display !== 'none') {
    $dynamic_display_class = " $dynamic_display";
}

do_action('cn/modules/styles', $row_id, $data);
?>

<div class="module content-area<?php echo esc_attr($dynamic_display_class); ?>" id="<?php echo esc_attr($row_id); ?>">
    <div class="uk-container uk-container-large">
        <div class="content-area__heading">
            <?php
            echo nl2br(Util::getHTML(
                get_the_title(),
                'h1',
                ['class' => 'content-area__title']
            ));
            ?>
        </div>

        <div class="uk-grid uk-grid-large" uk-grid>
            <div class="uk-width-1-4@m uk-width-1-1@s">
                <div class="content-area__jump-to">
                    <div class="uk-visible@m" uk-sticky="offset: 120">
                        <p class="jump-headline"><?php _e('JUMP TO:', 'kmag'); ?></p>

                        <?php foreach ($content_blocks as $index => $item) { 
                            $section_name = ACF::getField('section-name', $item); 
                            $section_id = str_replace(" ", "-", $section_name);
                            $section_id = str_replace(",", "-", $section_id);
                            $section_id = strtolower($section_id); ?>

                            <p class="section-name" data-id="<?php echo esc_attr($section_id); ?>"><?php echo esc_html($section_name); ?><p>
                        <?php } ?>
                    </div>

                    <div class="uk-hidden@m uk-visible" uk-sticky="offset: 120">
                        <div class="uk-grid uk-grid-small">
                            <div class="uk-width-1-3 label-container">
                                <p class="jump-headline"><?php _e('JUMP TO:', 'kmag'); ?></p>
                            </div>

                            <div class="uk-width-2-3">
                                <div class="select-container">
                                    <select name="jump_to" class="section-select">
                                        <option value=""><?php _e('Select', 'kmag'); ?></option>
                                        <?php foreach ($content_blocks as $index => $item) { 
                                            $section_name = ACF::getField('section-name', $item); 
                                            $section_id = str_replace(" ", "-", $section_name);
                                            $section_id = str_replace(",", "-", $section_id);
                                            $section_id = strtolower($section_id); ?>

                                            <option value="<?php echo esc_attr($section_id); ?>"><?php echo esc_html($section_name); ?></option>
                                        <?php } ?>
                                    </select>

                                    <svg class="icon icon-select-dropdown" aria-hidden="true">
                                        <use xlink:href="#icon-select-dropdown"></use>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="uk-width-3-4@m uk-width-1-1@s">
                <?php foreach ($content_blocks as $index => $item) { 
                    $section_name = ACF::getField('section-name', $item);
                    $section_id = str_replace(" ", "-", $section_name);
                    $section_id = str_replace(",", "-", $section_id);
                    $section_id = strtolower($section_id);
                    $content = ACF::getField('section-content', $item); ?>

                    <div class="content-area__body" id="<?php echo esc_attr($section_id); ?>">
                        <?php
                        echo nl2br(Util::getHTML(
                            $section_name,
                            'h2',
                            ['class' => 'hdg']
                        ));
                        
                        echo apply_filters('the_content', $content); ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>