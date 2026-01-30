<?php

/**
 * Product Label template file.
 */

use CN\App\Media;
use CN\App\Fields\ACF;
use CN\App\Fields\Util;

$post_id = get_the_ID();
$data = ACF::getPostMeta($post_id);
$title = get_the_title($post_id);
$logo = ACF::getField('logo', $data);
$crop_type = ACF::getField('crop-type', $data);
$application_list = ACF::getRowsLayout('application-list', $data);
$improvement_list = ACF::getRowsLayout('improvement-list', $data);
$volume = ACF::getField('volume', $data);
$density = ACF::getField('density', $data);
$net_weight = ACF::getField('net-weight', $data);
$benefits = ACF::getField('benefits', $data);
$analysis_items = ACF::getRowsLayout('analysis-items', $data);
$analysis_bold_column_1 = ACF::getField('analysis-bold-column-1', $data);
$analysis_bold_column_2 = ACF::getField('analysis-bold-column-2', $data);
$storage = ACF::getField('storage', $data);
$direction_of_use = ACF::getField('direction-of-use', $data);
$health_and_safety_label = ACF::getField('health-and-safety-label', $data);
$health_and_safety_content = ACF::getField('health-and-safety-content', $data);
$warranty = ACF::getField('warranty', $data);
$file = ACF::getField('pdf', $data);
?>

<article id="post-<?php the_ID(); ?>" class="product-label" data-post-type="product-label">
    <div class="uk-container uk-container-large">
        <div class="logo-container">
            <?php if (!empty($logo)) {
                echo Util::getImageHTML(Media::getAttachmentByID($logo));
            } ?>

            <h1><?php echo esc_html($title); ?></h1>

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

        <div class="uk-grid uk-grid-medium uk-child-width-1-2 container" uk-grid>
            <div>
                <p class="label-name"><?php _e('CROP TYPE', 'kmag'); ?></p>
                <p><?php echo esc_html($crop_type); ?></p>
            </div>

            <div>
                <?php if (!empty($application_list)) { ?>
                    <ul class="application-list">
                        <?php foreach ($application_list as $item) : ?>
                            <li><?php echo esc_html(ACF::getField('content', $item)); ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php } ?>
            </div>
        </div>

        <?php if (!empty($improvement_list)) { ?>
            <div class="uk-grid uk-grid-medium uk-child-width-1-3@s uk-child-width-1-1 container" uk-grid>
                <?php foreach ($improvement_list as $item) :
                    $icon = ACF::getField('icon', $item);
                    ?>

                    <div class="improvement-list">
                        <div class="uk-grid-small" uk-grid>
                            <?php if (!empty($icon)) { ?>
                                <div class="uk-width-1-5">
                                    <div class="icon">
                                        <?php echo Util::getImageHTML(Media::getAttachmentByID($icon)); ?>
                                    </div>
                                </div>
                            <?php } ?>

                            <div class="uk-width-expand">
                                <div class="content">
                                    <p><?php echo esc_html(ACF::getField('content', $item)); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php } ?>

        <div class="uk-grid uk-grid-medium uk-child-width-1-3@m uk-child-width-1-1 container" uk-grid>
            <?php if (!empty($volume)) { ?>
                <div>
                    <p class="label-name"><?php _e('VOLUME', 'kmag'); ?></p>
                    <p><?php echo esc_html($volume); ?></p>
                </div>
            <?php } ?>

            <?php if (!empty($density)) { ?>
                <div>
                    <p class="label-name"><?php _e('DENSITY', 'kmag'); ?></p>
                    <p><?php echo esc_html($density); ?></p>
                </div>
            <?php } ?>

            <?php if (!empty($net_weight)) { ?>
                <div>
                    <p class="label-name"><?php _e('NET WEIGHT', 'kmag'); ?></p>
                    <p><?php echo esc_html($net_weight); ?></p>
                </div>
            <?php } ?>
        </div>

        <?php if (!empty($benefits)) { ?>
            <div class="benefits body-content">
                <h2 class="label-name"><?php _e('PRODUCT BENEFITS', 'kmag'); ?></h2>
                <?php echo apply_filters('the_content', $benefits); ?>
            </div>
        <?php } ?>

        <div class="uk-grid uk-grid-large uk-child-width-1-2@m uk-child-width-1-1" uk-grid>
            <div>
                <?php if (!empty($analysis_items)) { ?>
                    <div class="analysis">
                        <h2 class="label-name"><?php _e('GUARANTEED ANALYSIS <br>CONTAINS BENEFICIAL SUBSTANCE(S)', 'kmag'); ?></h2>

                        <table class="uk-table uk-table-divider">
                            <tbody>
                                <?php foreach ($analysis_items as $item) : ?>
                                    <tr>
                                        <td class="<?php echo !empty(ACF::getField('bold-column-1', $item)) ? 'bold' : ''; ?>"><?php echo esc_html(ACF::getField('column-1', $item)); ?></td>
                                        <td class="<?php echo !empty(ACF::getField('bold-column-2', $item)) ? 'bold' : ''; ?>"><?php echo esc_html(ACF::getField('column-2', $item)); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th><?php echo !empty($analysis_bold_column_1) ? esc_html($analysis_bold_column_1) : ''; ?></th>
                                    <th><?php echo !empty($analysis_bold_column_2) ? esc_html($analysis_bold_column_2) : ''; ?></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                <?php } ?>

                <?php if (!empty($direction_of_use)) { ?>
                    <div class="direction-of-use body-content">
                        <h2 class="label-name"><?php _e('DIRECTIONS FOR USE', 'kmag'); ?></h2>
                        <?php echo apply_filters('the_content', $direction_of_use); ?>
                    </div>
                <?php } ?>
            </div>

            <div>
                <?php if (!empty($storage)) { ?>
                    <div class="storage body-content">
                        <h2 class="label-name"><?php _e('STORAGE', 'kmag'); ?></h2>
                        <?php echo apply_filters('the_content', $storage); ?>
                    </div>
                <?php } ?>

                <?php if (!empty($health_and_safety_content)) { ?>
                    <div class="health-and-safety">
                        <h2 class="label-name"><?php _e('HEALTH AND SAFETY', 'kmag'); ?></h2>

                        <div class="uk-grid uk-grid-small uk-flex-middle" uk-grid>
                            <?php if (!empty($health_and_safety_label)) { ?>
                                <div>
                                    <div class="warning-icon"></div>
                                </div>
                                <div class="label">
                                    <span><?php echo esc_html($health_and_safety_label); ?></span>
                                </div>
                            <?php } ?>
                        </div>

                        <?php echo apply_filters('the_content', $health_and_safety_content); ?>
                    </div>
                <?php } ?>

                <?php if (!empty($warranty)) { ?>
                    <div class="warranty body-content">
                        <h2 class="label-name"><?php _e('WARRANTY', 'kmag'); ?></h2>
                        <?php echo apply_filters('the_content', $warranty); ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</article><!-- #post-## -->