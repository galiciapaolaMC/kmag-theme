<?php
/**
 * Material Compatibility template file.
 */

use CN\App\Fields\ACF;
use CN\App\Fields\Util;
use CN\App\Media;

$post_id = get_the_ID();
$data = ACF::getPostMeta($post_id);
$introduction = ACF::getField('introduction', $data);
$table_name = ACF::getField('table-name', $data);
$table_headers = ACF::getRowsLayout('table-headers', $data);
$table_rows = ACF::getRowsLayout('table-items', $data);
$hero = ACF::getField('hero', $data);
$logo = ACF::getField('logo', $data);
$file = ACF::getField('pdf', $data);

if (empty($table_rows)) {
    return;
}

?>

<article id="post-<?php the_ID(); ?>" class="material-compatibility"  data-post-type="material-compatibility">
    <div class="uk-container uk-container-large">
        <div class="logo-container">
            <h1><?php _e('Material Compatibility', 'kmag'); ?></h1>

            <?php if (!empty($file)) {
                $pdf_url = Media::getPdfSrcByID($file); ?>
                <a href="<?php echo esc_url($pdf_url); ?>" target="_blank"
                    class="btn btn-primary btn-pdf-download">
                    <?php _e('Download PDF', 'kmag'); ?>
                    <svg class="icon icon-download" aria-hidden="true">
                        <use xlink:href="#icon-download"></use>
                    </svg>
                </a>
            <?php } ?>
        </div>

        <?php if (!empty($hero)) {
            echo Util::getImageHTML(Media::getAttachmentByID($hero), 'full', ['class' => 'hero-image']); ?>
        <?php } ?>

        <div class="introduction">
            <?php if (!empty($logo)) {
                echo Util::getImageHTML(Media::getAttachmentByID($logo)); ?>
            <?php } ?>

            <?php if (!empty($introduction)) : ?>
                <p><?php echo esc_html($introduction); ?></p>
            <?php endif; ?>
        </div>

        <table class="uk-table uk-table-divider">
            <thead>
                <?php if (!empty($table_name)) { ?>
                    <tr>
                        <th class="table-name" colspan="3"><?php echo esc_html($table_name); ?></th>
                    </tr>
                <?php } ?>
                <tr>
                    <?php foreach ($table_headers as $header) : ?>
                        <th class="table-col-name"><?php echo esc_html(ACF::getField('name', $header)); ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($table_rows as $row) : ?>
                    <?php
                    $section_name = ACF::getField('section-name', $row);
                    $rows = ACF::getRowsLayout('table-rows', $row);
                    if (!empty($section_name)) { ?>
                        <tr><td class="section-name" colspan="3"><strong><?php echo esc_html($section_name); ?></strong></td></tr>
                    <?php } ?>

                    <?php if (!empty($rows)) : ?>
                        <?php foreach ($rows as $item) : ?>
                            <tr>
                                <td><?php echo esc_html(ACF::getField('column-1', $item)); ?></td>
                                <td><?php echo esc_html(ACF::getField('column-2', $item)); ?></td>
                                <td><?php echo esc_html(ACF::getField('column-3', $item)); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</article>
