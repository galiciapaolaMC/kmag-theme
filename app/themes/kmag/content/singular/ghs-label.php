<?php
/**
 * GHS Label template file.
 */

use CN\App\Media;
use CN\App\Fields\ACF;
use CN\App\Fields\Util;

$post_id = get_the_ID();
$data = ACF::getPostMeta($post_id);
$revision = ACF::getField('revision', $data);
$issue_dt = ACF::getField('issue_date', $data);
$file_url = ACF::getField('file_url', $data);
$compound_name = ACF::getField('compound_name', $data);
$product_name = ACF::getField('product_name', $data);
$statements = ACF::getRowsLayout('statements', $data);
$warning_logo = ACF::getField('warning_logo', $data);
$company_address = ACF::getField('company_address', $data);
?>

<article id="post-<?php the_ID(); ?>" class="ghs-label"  data-post-type="ghs-label">
    <?php get_template_part('partials/back-to-resources-button'); ?>
    <div class="ghs-label__header">
        <div class="logo-container">
            <h1><?php _e('GHS Label', 'kmag'); ?></h1>
        </div>
        <div class="uk-container uk-container-large">
            <div class="uk-grid uk-container-large" uk-grid>
                <div class="uk-width-1-5@m uk-width-1-1@s"></div>
                <div class="uk-width-4-5@m uk-width-1-1@s entry-container">
                    <h2><?php echo esc_html($compound_name); ?></h2>
                    <h4><?php echo apply_filters('the_title', $product_name); ?></h4>
                    <div class="ghs-label-dates">
                        <?php if (!empty($issue_dt)) { ?>
                            <?php echo esc_html($issue_dt) . '<br>'; ?>
                        <?php } ?>
                        <?php if (!empty($revision)) { ?>
                            <?php echo esc_html($revision); ?>
                        <?php } ?>
                    </div>
                    <?php if (!empty($file_url)) {
                        $pdf_url = Media::getPdfSrcByID($file_url); ?>
                        <a href="<?php echo esc_url($pdf_url); ?>" target="_blank" class="btn btn-primary btn-download">
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
    <div class="ghs-label__body">
        <div class="uk-container uk-container-large">
            <div class="uk-grid uk-container-large" uk-grid>
                <div class="uk-width-1-5@m uk-width-1-1@s"></div>
                <div class="uk-width-4-5@m uk-width-1-1@s entry-container">
                    <?php $count = 0; ?>
                    <?php foreach ($statements as $statement) { ?>
                        <div class="statements-inner <?php if ($count == count($statements) - 1) {
                            echo 'last-statement-body';
                        } ?>">
                            <h4 class="statement-title"><?php echo $statement['statement_title']; ?></h4>
                            <div class="statement-body <?php if (!empty($warning_logo) && $count == 0) {
                                echo 'warning-logo-holder';
                            } ?>">
                                <?php
                                if (!empty($warning_logo) && $count == 0) {
                                    echo "<div class='warning-logo-sub-holder'>";
                                    echo Util::getImageHTML(Media::getAttachmentByID($warning_logo), 'medium', ['class' => 'warning-logo']);
                                    echo "</div>";
                                }
                                $count++;
                                ?>
                                <?php echo apply_filters('the_content', $statement['statement_body']); ?>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="company-address">
                        <div class="address-inner">
                            <div class="address-inner1">
                                <svg class="icon mosaic-black-logo" aria-hidden="true">
                                    <use xlink:href="#icon-mosaic-black-logo"></use>
                                </svg>
                            </div>
                            <div class="address-inner2">
                                <?php echo apply_filters('the_content', $company_address); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</article><!-- #post-## -->
