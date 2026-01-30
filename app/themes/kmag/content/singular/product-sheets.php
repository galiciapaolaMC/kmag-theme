<?php

/**
 * Product Sheet template file.
 */

use CN\App\Media;
use CN\App\Fields\ACF;
use CN\App\Fields\Util;

$post_id = get_the_ID();
$data = ACF::getPostMeta($post_id);
$sheet_banner = ACF::getField('sheet_banner', $data);
$product_name = ACF::getField('product_name', $data);
$product_description = ACF::getField('product_description', $data);
$cited_date = ACF::getField('cited_date', $data);
$cited_revision = ACF::getField('cited_revision', $data);
$spec_sheet_pdf = ACF::getField('pdf_file', $data);
$features_benefits = ACF::getRowsLayout('features_benefits', $data);
$technology_at_work = ACF::getRowsLayout('technology_at_work', $data);
$static_image = ACF::getField('static_image', $data); 
$product_profile = ACF::getRowsLayout('product_profile', $data);
$application = ACF::getRowsLayout('application', $data);
$notice = ACF::getField('notice', $data);
$disclaimer = ACF::getField('disclaimer', $data);
$particle_distributions = ACF::getRowsLayout('particle_distribution', $data);
//remove_filter('the_content', 'wpautop');
/* $columnsToCheck = ['parameter', 'typical', 'tyler_mesh', 'opening'];
$columns_sizing_tbl_dt_present = array_filter($columnsToCheck, function ($column) use ($sizing_characteristics) {
    $tmp = array_map('trim', array_column($sizing_characteristics, $column));
    return count(array_filter($tmp)) > 0;
});
$haveSizingTblColumns = count($columns_sizing_tbl_dt_present); */
?>

<article id="post-<?php the_ID(); ?>" class="product-sheets" data-post-type="product-sheet">
    <?php get_template_part('partials/back-to-resources-button'); ?>
    <div class="product-sheets__header">
        <div class="jump-holder">
            <div class="jump-txt"><?php _e('JUMP TO :', 'kmag'); ?></div>
            <div class="uk-inline">
                <div class="jump-sub">
                    <button class="uk-button uk-button-default" type="button">
                        <div class="inner-mng">
                            <div class="sel-txt"><?php _e('Select', 'kmag'); ?></div>
                            <svg class="icon icon-arrow-down">
                                <use xlink:href="#icon-arrow-down"></use>
                            </svg>
                        </div>
                    </button>
                </div>
                <div uk-dropdown="mode: click">
                    <ul>
                        <li><a uk-scroll
                                href="#chemical_composition"><?php _e('Chemical Composition', 'kmag'); ?></a>
                        </li>
                        <li><a uk-scroll
                                href="#physical_properties"><?php _e('Physical Properties', 'kmag'); ?></a>
                        </li>
                        <li>
                            <a uk-scroll
                                href="#sizing_characteristics"><?php _e('Sizing Characteristics', 'kmag'); ?></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="logo-container">
            <h1><?php _e('Product Sheet', 'kmag'); ?></h1>
        </div>
        <div class="uk-container uk-container-large topic-holder">
            <div class="uk-grid uk-container-large" uk-grid>
                <div class="uk-width-1-1@m uk-width-1-1@s">
                    <?php if (!empty($sheet_banner)) {
                        $link = Util::getImageHTML(Media::getAttachmentByID($sheet_banner), 'full', ['class' => 'sheet-banner', 'alt' => $product_name]);
                        echo $link;
                    }
                    ?>
                    <h4 class="product-name"><?php echo apply_filters('the_title', $product_name); ?></h4>
                    <?php if (!empty($cited_date)) { ?>
                        <div class="uk-margin-small-top citied-holder">
                            <?php if (!empty($cited_date)) { ?>
                                <span class="citied-date"><?php echo esc_html($cited_date); ?></span>
                            <?php } ?>
                            <?php if (!empty($cited_revision)) { ?>
                                <span class="citied-revision"><?php _e('SDS #: ', 'kmag'); ?><?php echo esc_html($cited_revision); ?></span>
                            <?php } ?>
                        </div>
                    <?php } ?>
                    <?php if (!empty($spec_sheet_pdf)) {
                        $pdf_url = Media::getPdfSrcByID($spec_sheet_pdf); ?>
                        <a href="<?php echo esc_url($pdf_url); ?>" target="_blank" class="btn btn-primary">
                            <?php _e('Download PDF', 'kmag'); ?>
                            <svg class="icon icon-download" aria-hidden="true">
                                <use xlink:href="#icon-download"></use>
                            </svg>
                        </a>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="uk-container uk-container-large content-holder">
            <div class="uk-grid uk-container-large" uk-grid>
                <div class="uk-width-1-1@m uk-width-1-1@s">
                    <h4 class="product-profile-heading-custom"><?php _e('THE PRODUCT', 'kmag'); ?></h4>
                    <?php echo esc_html($product_description); ?>
                </div>
            </div>
            <div class="uk-grid uk-container-large" uk-grid>
                <div class="uk-width-1-2@m uk-width-1-1@s">
                    <h4 class="product-profile-heading"><?php _e('FEATURES & BENEFITS', 'kmag'); ?></h4>
                    <?php if (count($features_benefits) == 0) { ?>
                        <ul>
                            <li><?php _e('No data available', 'kmag'); ?></li>
                        </ul>
                    <?php } ?>
                    <ul class="features-benefits">
                        <?php foreach ($features_benefits as $point) { ?>
                            <li><?php echo esc_html($point['point']); ?></li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="uk-width-1-2@m uk-width-1-1@s">
                    <h4 class="product-profile-heading"><?php _e('TECHNOLOGY AT WORK', 'kmag'); ?></h4>
                    <?php if (count($technology_at_work) == 0) { ?>
                        <ol>
                            <li><?php _e('No data available', 'kmag'); ?></li>
                        </ol>
                    <?php } ?>
                    <ol class="technology-at-work">
                        <?php foreach ($technology_at_work as $point) { ?>
                            <li><?php echo esc_html($point['point']); ?></li>
                        <?php } ?>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="product-sheets__body">
        <div class="uk-container uk-container-large">
            <div class="uk-width-1-1">
                <h2 class="product-main-heading"><?php _e('TECHNICAL INFORMATION', 'kmag'); ?></h2>
            </div>
            <div class="uk-grid uk-container-large" uk-grid>
                <div class="uk-width-1-5@m uk-width-1-1@s share-desktop"></div>
                <div class="uk-width-4-5@m uk-width-1-1@s">
                    <div id="product_profile" class="product-profile-tbl-holder">
                        <h4 class="product-profile-heading"><?php _e('PRODUCT PROFILE', 'kmag'); ?></h4>
                        <table class="product-profile-table">
                            <tbody>
                                <?php foreach ($product_profile as $item) { ?>
                                    <tr>
                                        <th><?php echo esc_html($item['title']); ?></th>
                                        <td data-my-column="<?php echo esc_html($item['title']); ?>">
                                            <div class="cmp-td-data"><?php echo esc_html($item['content']); ?></div>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div id="application" class="application-tbl-holder">
                        <h4 class="application-heading"><?php _e('APPLICATION', 'kmag'); ?></h4>
                        <table class="application-table">
                            <tbody>
                                <?php foreach ($application as $item) { ?>
                                    <tr>
                                        <th><?php echo esc_html($item['title']); ?></th>
                                        <td data-my-column="<?php echo esc_html($item['title']); ?>">
                                            <div class="cmp-td-data"><?php echo esc_html($item['content']); ?></div>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="product-sheets__foot">
        <?php if (!empty($notice)) { ?>
            <div class="notice-holder">
                <?php echo esc_html($notice); ?>
            </div>
        <?php } ?>
        <?php if (!empty($disclaimer)) { ?>
            <div class="disclaimer-holder">
                <?php echo esc_html($disclaimer); ?>
            </div>
        <?php } ?>
    </div>
</article><!-- #post-## -->