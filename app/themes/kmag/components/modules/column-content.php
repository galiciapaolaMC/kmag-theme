<?php
/**
 * ACF Module: Column Content
 *
 * @var array $data
 * @var string $row_id
 *
 */

use CN\App\Fields\ACF;
use CN\App\Fields\Util;

$section_class    = ACF::getField('section_class', $data);
$columns          = ACF::getRowsLayout('columns', $data);
$gap_size         = ACF::getField('gap_size', $data);
$reverse_columns_mobile = ACF::getField('reverse_mobile', $data);
$module_vertical_alignment = ACF::getField('module-vertical-alignment', $data, 'middle');
$module_width     = ACF::getField('module-width', $data, 'normal');
$column_count     = count($columns);
$column_gap       = "uk-grid-{$gap_size}";
$reverse_mobile   = '';

if (!empty($section_class)) {
    $section_class = " {$section_class}";
}

if ($reverse_columns_mobile === '1' && $column_count === 2) {
    $reverse_mobile = 'reverse';
}

if ($column_count === 1) {
    $classes = 'uk-child-width-expand';
} elseif ($column_count === 2) {
    $classes = 'uk-child-width-1-2@m';
} elseif ($column_count === 3) {
    $classes = 'uk-child-width-1-2@s uk-child-width-1-3@m';
} elseif ($column_count === 4) {
    $classes = 'uk-child-width-1-2@s uk-child-width-1-4@m';
}

$grid_classes = "{$column_gap} {$classes} {$reverse_mobile} align-{$module_vertical_alignment}";

do_action('cn/modules/styles', $row_id, $data);
?>

<section id="<?php echo esc_attr($row_id); ?>" class="module column-content<?php echo esc_attr($section_class); ?> width-<?php echo esc_attr($module_width); ?>">
    <div class="column-content__grid-wrapper">
        <div class="<?php echo $grid_classes; ?>" uk-height-match uk-grid>
            <?php
            
            foreach ($columns as $index => $col) :
                $dats = ACF::getRowsLayout('modules', $col);
                
                $cell_number = 'cell-' . ($index + 1);

                ?>
            <div class="column-content__cell <?php echo $cell_number; ?>">

                <?php foreach ($col['modules'] as $ind => $el) {
                        $data = $dats[$ind];
                        $part = implode('-', explode('_', $el));
                        $file = locate_template("components/partials/{$part}.php");
                        if (file_exists($file)) {
                            include $file;
                        }
                    } ?>

            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>