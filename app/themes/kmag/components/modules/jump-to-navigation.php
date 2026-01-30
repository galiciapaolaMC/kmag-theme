<?php
/**
 * ACF Module: Jump To Navigation
 *
 * @global $data
 */

use CN\App\Fields\ACF;
use CN\App\Media;
use CN\App\Fields\Util;

$navigation_items = ACF::getRowsLayout('navigation-items', $data);

if (! $navigation_items) {
    return;
}

do_action('cn/modules/styles', $row_id, $data);
?>

<div class="module jump-to-navigation" id="<?php echo esc_attr($row_id); ?>">
    <div class="jump-to-navigation__container" uk-sticky>
        <div class="uk-container">
            <div class="uk-grid uk-grid-small">
                <div class="uk-width-auto label-container">
                    <p class="jump-headline"><?php _e('JUMP TO:', 'kmag'); ?></p>
                </div>

                <div class="uk-width-2-3">
                    <div class="select-container">
                        <button class="section-select" type="button">
                            <span><?php _e('Select', 'kmag'); ?></span>
                            <svg class="icon icon-select-dropdown" aria-hidden="true">
                                <use xlink:href="#icon-select-dropdown"></use>
                            </svg> 
                        </button>

                        <div uk-dropdown="mode: click; offset: 0">
                            <ul class="uk-nav uk-dropdown-nav">
                                <?php foreach ($navigation_items as $index => $item) { 
                                    $section_name = ACF::getField('name', $item); 
                                    $section_id = ACF::getField('module-number', $item); ?>

                                    <li data-value="<?php echo esc_attr($section_id); ?>" class="select-item"><button><?php echo esc_html($section_name); ?></button></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
