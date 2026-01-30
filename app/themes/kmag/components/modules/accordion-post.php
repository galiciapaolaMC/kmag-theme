<?php
/**
 * ACF Module: AccordionPost
 *
 * @global $data
 * @global $row_id
 */

use CN\App\Fields\ACF;
use CN\App\Fields\Util;
use CN\App\Media;

$accordion_posts = ACF::getRowsLayout('accordion-post-block', $data);
if (!$accordion_posts) {
    return;
}

if (!function_exists('echoModules')) {
    function echoModules($items, $main_index)
    {
        $modules_name = ACF::getField('modules', $items);
        $modules_data = ACF::getRowsLayout('modules', $items);
        $modules_data = array_map(function ($module, $index) use ($modules_name) {
            $module['module_type'] = isset($modules_name[$index]) ? $modules_name[$index] : 'Unknown';
            return $module;
        }, $modules_data, array_keys($modules_data));
        foreach ($modules_data as $index => $module) {
            $data = $module;
            $row_id = $module['module_type'] . '_' . $main_index . '_' . $index;
            $file_module_name = str_replace('_', '-', $module['module_type']);
            $file = locate_template("components/modules/{$file_module_name}.php");
            if (file_exists($file)) {
                include $file;
            }
        }
    }
}

do_action('cn/modules/styles', $row_id, $data);
?>

<div class="module accordion-post" id="<?php echo esc_attr($row_id); ?>">
    <ul uk-accordion>
        <?php foreach ($accordion_posts as $index => $item) { ?>
            <?php
            $headline = ACF::getField('accordion-heading', $item);
            $sub_headline = ACF::getField('accordion-sub-heading', $item);
            ?>
            <li class="accordion-post__container accordion-post-li">
                <!-- Accordion Head -->
                <div class="accordion-post__headline uk-accordion-title">
                    <svg class="icon icon-accordion-close" aria-hidden="true">
                        <use xlink:href="#icon-accordion-close"></use>
                    </svg>
                    <svg class="icon icon-accordion-open" aria-hidden="true">
                        <use xlink:href="#icon-accordion-open"></use>
                    </svg>

                    <div class="head-holder">
                        <?php if ($sub_headline): ?>
                            <div class="sub-headline"><strong><?php echo esc_html($sub_headline); ?></strong></div>
                        <?php endif;
                        if ($headline):?>
                            <div class="headline"><?php echo esc_html($headline); ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Accordion Body -->
                <div class="uk-accordion-content accordion-post__content">
                    <div class="body-holder">
                        <?php echoModules($item, $index); ?>
                    </div>
                </div>
            </li>
        <?php } ?>
    </ul>
</div>
