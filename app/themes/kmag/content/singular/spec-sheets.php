<?php
/**
 * Spec Sheet template file.
 */

use CN\App\Media;
use CN\App\Fields\ACF;
use CN\App\Fields\Util;

$post_id = get_the_ID();
$data = ACF::getPostMeta($post_id);
$product_logo = ACF::getField('product_logo', $data);
$product_name = ACF::getField('product_name', $data);
$cited_date = ACF::getField('cited_date', $data);
$cited_revision = ACF::getField('cited_revision', $data);
$spec_sheet_pdf = ACF::getField('pdf_file', $data);
$chemical_compositions = ACF::getRowsLayout('chemical_composition', $data);
$physical_properties = ACF::getRowsLayout('physical_properties', $data);
$sizing_characteristics = ACF::getRowsLayout('sizing_characteristics', $data);
$notice = ACF::getField('notice', $data);
$disclaimer = ACF::getField('disclaimer', $data);
$particle_distributions = ACF::getRowsLayout('particle_distribution', $data);
remove_filter('the_content', 'wpautop');
$columnsToCheck = ['parameter', 'typical', 'tyler_mesh', 'opening'];
$columns_sizing_tbl_dt_present = array_filter($columnsToCheck, function ($column) use ($sizing_characteristics) {
    $tmp = array_map('trim', array_column($sizing_characteristics, $column));
    return count(array_filter($tmp)) > 0;
});
$haveSizingTblColumns = count($columns_sizing_tbl_dt_present);
?>

<article id="post-<?php the_ID(); ?>" class="spec-sheets" data-post-type="spec-sheet">
    <?php get_template_part('partials/back-to-resources-button'); ?>
    <div class="spec-sheets__header">
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
            <h1><?php _e('Technical Data Sheet', 'kmag'); ?></h1>
        </div>
        <div class="uk-container uk-container-large topic-holder">
            <div class="uk-grid uk-container-large" uk-grid>
                <div class="uk-width-1-5@m uk-width-1-1@s share-desktop"></div>
                <div class="uk-width-4-5@m uk-width-1-1@s">
                    <?php if (!empty($product_logo)) {
                        $link = Util::getImageHTML(Media::getAttachmentByID($product_logo), 'medium', ['class' => 'brand-logo', 'alt' => $product_name]);
                        echo $link;
                    }
                    ?>
                    <h4 class="product-name"><?php echo apply_filters('the_title', $product_name); ?></h4>
                    <div class="uk-margin-small-top citied-holder">
                        <?php if (!empty($cited_date)) { ?>
                            <span class="citied-date"><?php echo esc_html($cited_date); ?></span>
                        <?php } ?>
                        <?php if (!empty($cited_revision)) { ?>
                            <span class="citied-revision"><?php _e('SDS #: ', 'kmag'); ?><?php echo esc_html($cited_revision); ?></span>
                        <?php } ?>
                    </div>
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
    </div>
    <div class="spec-sheets__body">
        <div class="uk-container uk-container-large">
            <div class="uk-grid uk-container-large" uk-grid>
                <div class="uk-width-1-5@m uk-width-1-1@s share-desktop"></div>
                <div class="uk-width-4-5@m uk-width-1-1@s">
                    <div id="chemical_composition" class="chemical-comp-tbl-holder">
                        <h4 class="chemical-compo-heading"><?php _e('Chemical Composition', 'kmag'); ?></h4>
                        <table class="chemical-compo-table">
                            <tbody>
                            <tr>
                                <th><?php _e('Component', 'kmag'); ?></th>
                                <th><?php _e('Symbol', 'kmag'); ?></th>
                                <th><?php _e('Typical %', 'kmag'); ?></th>
                                <th><?php _e('Guarantee %(min.)', 'kmag'); ?></th>
                            </tr>
                            <?php if (count($chemical_compositions) == 0) { ?>
                                <tr>
                                    <td colspan="4"><?php _e('No data available', 'kmag'); ?></td>
                                </tr>
                            <?php } ?>
                            <?php foreach ($chemical_compositions as $chemical_composition) { ?>
                                <tr>
                                    <td data-my-column="<?php _e('Component', 'kmag'); ?>">
                                        <div class="cmp-td-data"><?php echo esc_html($chemical_composition['component']); ?></div>
                                    </td>
                                    <td data-my-column="<?php _e('Symbol', 'kmag'); ?>">
                                        <div class="cmp-td-data"><?php echo apply_filters('the_content', $chemical_composition['symbol']); ?></div>
                                    </td>
                                    <td data-my-column="<?php _e('Typical %', 'kmag'); ?>">
                                        <div class="cmp-td-data"><?php echo esc_html($chemical_composition['typical']); ?></div>
                                    </td>
                                    <td data-my-column="<?php _e('Guarantee %(min.)', 'kmag'); ?>">
                                        <div class="cmp-td-data"><?php echo esc_html($chemical_composition['guarantee_min']); ?></div>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <?php if (count($particle_distributions) > 0) { ?>
                        <div id="particle_distribution" class="particle-tbl-holder">
                            <h4 class="particle-heading"><?php _e('Particle Size Distribution Cumulative %', 'kmag'); ?></h4>
                            <table class="particle-table">
                                <tbody>
                                <tr>
                                    <th><?php _e('Tyler Mesh', 'kmag'); ?></th>
                                    <th><?php _e('US Mesh', 'kmag'); ?></th>
                                    <th><?php _e('Opening (mm)', 'kmag'); ?></th>
                                    <th><?php _e('Typical Range', 'kmag'); ?></th>
                                    <th><?php _e('Typical', 'kmag'); ?></th>
                                </tr>
                                <?php foreach ($particle_distributions as $particle_distribution) { ?>
                                    <tr>
                                        <td data-my-column="<?php _e('Tyler Mesh', 'kmag'); ?>">
                                            <div class="cmp-td-data"><?php echo esc_html($particle_distribution['tyler_mesh']); ?></div>
                                        </td>
                                        <td data-my-column="<?php _e('US Mesh', 'kmag'); ?>">
                                            <div class="cmp-td-data"><?php echo esc_html($particle_distribution['us_mesh']); ?></div>
                                        </td>
                                        <td data-my-column="<?php _e('Opening (mm)', 'kmag'); ?>">
                                            <div class="cmp-td-data"><?php echo esc_html($particle_distribution['opening']); ?></div>
                                        </td>
                                        <td data-my-column="<?php _e('Typical Range', 'kmag'); ?>">
                                            <div class="cmp-td-data"><?php echo esc_html($particle_distribution['typical_range']); ?></div>
                                        </td>
                                        <td data-my-column="<?php _e('Typical', 'kmag'); ?>">
                                            <div class="cmp-td-data"><?php echo esc_html($particle_distribution['typical']); ?></div>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    <?php } ?>
                    <?php if ($haveSizingTblColumns >= 3) { ?>
                        <div id="sizing_chart_main" class="sizing-lg-tbl-holder">
                            <h4 class="sizing-heading"><?php _e('Sizing Characteristics', 'kmag'); ?></h4>
                            <table class="sizing-table">
                                <tbody>
                                <tr>
                                    <?php if (in_array('tyler_mesh', $columns_sizing_tbl_dt_present)) { ?>
                                        <th><?php _e('Tyler Mesh', 'kmag'); ?></th>
                                    <?php } ?>
                                    <?php if (in_array('opening', $columns_sizing_tbl_dt_present)) { ?>
                                        <th><?php _e('Opening (mm)', 'kmag'); ?></th>
                                    <?php } ?>
                                    <?php if (in_array('typical', $columns_sizing_tbl_dt_present)) { ?>
                                        <th><?php _e('Typical', 'kmag'); ?></th>
                                    <?php } ?>
                                    <?php if (in_array('parameter', $columns_sizing_tbl_dt_present)) { ?>
                                        <th><?php _e('Parameter', 'kmag'); ?></th>
                                    <?php } ?>
                                </tr>
                                <?php foreach ($sizing_characteristics as $sizing_characteristic) { ?>
                                    <tr>
                                        <?php if (in_array('tyler_mesh', $columns_sizing_tbl_dt_present)) { ?>
                                            <td data-my-column="<?php _e('Tyler Mesh', 'kmag'); ?>">
                                                <div class="cmp-td-data"><?php echo esc_html($sizing_characteristic['tyler_mesh']); ?></div>
                                            </td>
                                        <?php } ?>
                                        <?php if (in_array('opening', $columns_sizing_tbl_dt_present)) { ?>
                                            <td data-my-column="<?php _e('Opening (mm)', 'kmag'); ?>">
                                                <div class="cmp-td-data"><?php echo esc_html($sizing_characteristic['opening']); ?></div>
                                            </td>
                                        <?php } ?>
                                        <?php if (in_array('typical', $columns_sizing_tbl_dt_present)) { ?>
                                            <td data-my-column="<?php _e('Typical', 'kmag'); ?>">
                                                <div class="cmp-td-data"><?php echo esc_html($sizing_characteristic['typical']); ?></div>
                                            </td>
                                        <?php } ?>
                                        <?php if (in_array('parameter', $columns_sizing_tbl_dt_present)) { ?>
                                            <td data-my-column="<?php _e('Parameter', 'kmag'); ?>">
                                                <div class="cmp-td-data"><?php echo esc_html($sizing_characteristic['parameter']); ?></div>
                                            </td>
                                        <?php } ?>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    <?php } ?>
                    <div class="uk-container uk-container-large psi-holder">
                        <div class="uk-grid-large uk-child-width-expand@l" uk-grid>
                            <div id="physical_properties" class="phy-properties-holder">
                                <h4 class="physical-property"><?php _e('Physical Properties', 'kmag'); ?></h4>
                                <div uk-grid>
                                    <div class="col-wrapper">
                                        <h4 class="physical-property-subheading"><?php _e('Bulk Density (Loose)', 'kmag'); ?></h4>
                                        <?php foreach ($physical_properties as $physical_property) { ?>
                                            <p class="physical-property-details"><?php echo esc_html($physical_property['bulk_density_loose']); ?></p>
                                        <?php } ?>
                                    </div>
                                    <div class="col-wrapper">
                                        <h4 class="physical-property-subheading"><?php _e('Typical', 'kmag'); ?></h4>
                                        <?php foreach ($physical_properties as $physical_property) { ?>
                                            <p class="physical-property-details"><?php echo esc_html($physical_property['typical']); ?></p>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <?php if ($haveSizingTblColumns <= 2) { ?>
                                <div id="sizing_characteristics" class="sizing-holder">
                                    <h4 class="sizing-character"><?php _e('Sizing Characteristics', 'kmag'); ?></h4>
                                    <div uk-grid>
                                        <div class="col-wrapper">
                                            <h4 class="sizing-character-subheading"><?php _e('Parameter', 'kmag'); ?></h4>
                                            <?php foreach ($sizing_characteristics as $sizing_characteristic) { ?>
                                                <p class="sizing-character-details"><?php echo esc_html($sizing_characteristic['parameter']); ?></p>
                                            <?php } ?>
                                        </div>
                                        <div class="col-wrapper">
                                            <h4 class="sizing-character-subheading"><?php _e('Typical', 'kmag'); ?></h4>
                                            <?php foreach ($sizing_characteristics as $sizing_characteristic) { ?>
                                                <p class="sizing-character-details"><?php echo esc_html($sizing_characteristic['typical']); ?></p>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="spec-sheets__foot">
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
