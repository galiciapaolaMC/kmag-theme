<?php
/**
 * Directions For Use template file.
 */

use CN\App\Media;
use CN\App\Fields\ACF;
use CN\App\Fields\Util;

$post_id = get_the_ID();
$data = ACF::getPostMeta($post_id);
$product_name = ACF::getField('product_name', $data);
$revision = ACF::getField('revision', $data);
$issue_date = ACF::getField('issue_date', $data);
$direction_pdf_url = ACF::getField('file_url', $data);
$details = ACF::getRowsLayout('details', $data);
$warning = ACF::getField('warning', $data);

?>
<article id="post-<?php the_ID(); ?>" class="directions-for-use" data-post-type="direction-for-use">

    <?php get_template_part('partials/back-to-resources-button'); ?>

    <div class="directions-for-use__header">
        <div class="uk-container-large">
            <div class="uk-grid uk-container-large" uk-grid>
                <div class="uk-width-4-5@m uk-width-1-1@s entry-container">
                    <h1 class="hdg hdg--1"><?php _e('Directions For Use', 'kmag'); ?></h1>
                </div>
            </div>
            <div class="uk-grid uk-container-large uk-margin-remove-top" uk-grid>
                <div class="uk-width-1-5@m uk-width-1-1@s share-desktop"></div>
                <div class="uk-width-4-5@m uk-width-1-1@s entry-container">
                    <div class="entry-content">
                        <h2 class="product-name">
                            <?php echo apply_filters('the_title', $product_name); ?>
                        </h2>
                        <div class="issue-rev-holder">
                            <?php if (!empty($issue_date)) { ?>
                                <div class="issue_dt">
                                    <?php echo esc_html($issue_date); ?>
                                </div>
                            <?php } ?>
                            <?php if (!empty($revision)) { ?>
                                <div class="revision">
                                    <?php _e('SDS #: ', 'kmag'); ?><?php echo esc_html($revision); ?>
                                </div>
                            <?php } ?>
                        </div>
                        <?php if (!empty($direction_pdf_url)) {
                            $pdf_url = Media::getPdfSrcByID($direction_pdf_url); ?>
                            <a href="<?php echo esc_url($pdf_url); ?>" target="_blank"
                               class="btn btn-primary btn-download-directions-for-use">
                                <?php _e('Download PDF', 'kmag'); ?>
                                <svg class="icon icon-download" aria-hidden="true">
                                    <use xlink:href="#icon-download"></use>
                                </svg>
                            </a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="directions-for-use__body">
        <div class="uk-container-large dt-main-holder">
            <div class="uk-grid uk-container-large" uk-grid>
                <div class="uk-width-1-5@m uk-width-1-1@s share-desktop"></div>
                <div class="uk-width-4-5@m uk-width-1-1@s entry-container">
                    <div class="detail-table-holder">
                        <table class="dfu-table">
                            <tbody>
                            <tr>
                                <th><?php _e('Crop', 'kmag'); ?></th>
                                <th><?php _e('Product Application Rate (lbs/ac)', 'kmag'); ?></th>
                                <th><?php _e('B Rate (lbs/ac) %', 'kmag'); ?></th>
                                <th><?php _e('Maximum B Application for Season (lbs/ac)', 'kmag'); ?></th>
                                <th><?php _e('Method', 'kmag'); ?></th>
                            </tr>
                            <?php foreach ($details as $dt) { ?>
                                <tr>
                                    <td data-my-column="<?php _e('Crop', 'kmag'); ?>">
                                        <div class="cmp-td-data"><?php echo esc_html($dt['crop']); ?></div>
                                    </td>
                                    <td data-my-column="<?php _e('Product Application Rate (lbs/ac)', 'kmag'); ?>">
                                        <div class="cmp-td-data"><?php echo esc_html($dt['product_application']); ?></div>
                                    </td>
                                    <td data-my-column="<?php _e('B Rate (lbs/ac) %', 'kmag'); ?>">
                                        <div class="cmp-td-data"><?php echo esc_html($dt['b_rate']); ?></div>
                                    </td>
                                    <td data-my-column="<?php _e('Maximum B Application for Season (lbs/ac)', 'kmag'); ?>">
                                        <div class="cmp-td-data"><?php echo esc_html($dt['max_b_app']); ?></div>
                                    </td>
                                    <td data-my-column="<?php _e('Method', 'kmag'); ?>">
                                        <div class="cmp-td-data"><?php echo esc_html($dt['method']); ?></div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <?php if (!empty($warning)) { ?>
            <div class="uk-container-large">
                <div class="uk-grid uk-container-large" uk-grid>
                    <div class="uk-width-1-5@m uk-width-1-1@s share-desktop"></div>
                    <div class="uk-width-4-5@m uk-width-1-1@s entry-container warning">
                        <?php echo apply_filters('the_content', $warning); ?>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</article><!-- #post-## -->
