<?php
/**
 * SDS Pages template file.
 */

use CN\App\Media;
use CN\App\Fields\ACF;
use CN\App\Fields\Util;

$post_id = get_the_ID();
$data = ACF::getPostMeta($post_id);
$top_header_product_name = ACF::getField("top_header_product_name", $data);
$top_header_product_logo = ACF::getField("top_header_product_logo", $data);
$top_header_status = ACF::getField("top_header_status", $data);
$top_header_pdf_file = ACF::getField('top_header_pdf_file', $data);
$top_header_revision_date = ACF::getField("top_header_revision_date", $data);
$top_header_sds = ACF::getField("top_header_sds", $data);
$top_header_sect_revised = ACF::getField("top_header_sect_revised", $data);
$top_header_issue_date = ACF::getField("top_header_issue_date", $data);
$top_header = ACF::getField("top_header", $data);
$sec_1_trade_name = ACF::getField("sec_1_trade_name", $data);
$sec_1_chemical_name = ACF::getField("sec_1_chemical_name", $data);
$sec_1_cas_number = ACF::getField("sec_1_cas_number", $data);
$sec_1_chemical_family = ACF::getField("sec_1_chemical_family", $data);
$sec_1_primary_use = ACF::getField("sec_1_primary_use", $data);
$sec_1_synonyms = ACF::getField("sec_1_synonyms", $data);
$sec_1_comp_info_corp_headquarters = ACF::getField("sec_1_comp_info_corp_headquarters", $data);
$sec_1_comp_info_us_guarantor = ACF::getField("sec_1_comp_info_us_guarantor", $data);
$sec_1_comp_info_canada_headquarters = ACF::getField("sec_1_comp_info_canada_headquarters", $data);
$sec_1_comp_info_contact_info = ACF::getField("sec_1_comp_info_contact_info", $data);
$sec_1_comp_info = ACF::getField("sec_1_comp_info", $data);
$sec_1_emergency_contact = ACF::getField("sec_1_emergency_contact", $data);
$sec_1 = ACF::getField("sec_1", $data);
$sec_2_osha_hcs_status = ACF::getField("sec_2_osha_hcs_status", $data);
$sec_2_ghs_classification = ACF::getRowsLayout("sec_2_ghs_classification", $data);
$sec_2_warning_symbol = ACF::getField("sec_2_warning_symbol", $data);
$sec_2_signal_word = ACF::getField("sec_2_signal_word", $data);
$sec_2_label_ele_prevention_list = ACF::getRowsLayout("sec_2_label_ele_prevention_list", $data);
$sec_2_label_ele_response_list = ACF::getRowsLayout("sec_2_label_ele_response_list", $data);
$sec_2_label_ele_storage_list = ACF::getRowsLayout("sec_2_label_ele_storage_list", $data);
$sec_2_label_ele_disposal_list = ACF::getRowsLayout("sec_2_label_ele_disposal_list", $data);
$sec_2_label_ele = ACF::getField("sec_2_label_ele", $data);
$sec_2 = ACF::getField("sec_2", $data);
$sec_3_formula = ACF::getField("sec_3_formula", $data);
$sec_3_composition_list = ACF::getRowsLayout("sec_3_composition_list", $data);
$sec_3 = ACF::getField("sec_3", $data);
$sec_4_first_aid_list = ACF::getRowsLayout("sec_4_first_aid_list", $data);
$sec_4_note_to_physician = ACF::getField("sec_4_note_to_physician", $data);
$sec_4 = ACF::getField("sec_4", $data);
$sec_5_extinguish = ACF::getField("sec_5_extinguish", $data);
$sec_5_protection = ACF::getField("sec_5_protection", $data);
$sec_5 = ACF::getField("sec_5", $data);
$sec_6_response_tech = ACF::getField("sec_6_response_tech", $data);
$sec_6 = ACF::getField("sec_6", $data);
$sec_7_handling = ACF::getField("sec_7_handling", $data);
$sec_7_storage = ACF::getField("sec_7_storage", $data);
$sec_7 = ACF::getField("sec_7", $data);
$sec_8_engineering_control = ACF::getField("sec_8_engineering_control", $data);
$sec_8_ppe_list = ACF::getRowsLayout("sec_8_ppe_list", $data);
$sec_8_general_hygience = ACF::getField("sec_8_general_hygience", $data);
$sec_8_exposure_list = ACF::getRowsLayout("sec_8_exposure_list", $data);
$sec_8_saskatchewan_list = ACF::getRowsLayout("sec_8_saskatchewan_list", $data);
$sec_8 = ACF::getField("sec_8", $data);
$sec_9_note = ACF::getField("sec_9_note", $data);
$sec_9_appearance = ACF::getField("sec_9_appearance", $data);
$sec_9_odor = ACF::getField("sec_9_odor", $data);
$sec_9_odor_threshold = ACF::getField("sec_9_odor_threshold", $data);
$sec_9_physical_state = ACF::getField("sec_9_physical_state", $data);
$sec_9_ph = ACF::getField("sec_9_ph", $data);
$sec_9_melting_freezing_points = ACF::getField("sec_9_melting_freezing_points", $data);
$sec_9_boiling_point = ACF::getField("sec_9_boiling_point", $data);
$sec_9_flash_point = ACF::getField("sec_9_flash_point", $data);
$sec_9_evaporation_rate = ACF::getField("sec_9_evaporation_rate", $data);
$sec_9_flammability = ACF::getField("sec_9_flammability", $data);
$sec_9_flammability_limits = ACF::getField("sec_9_flammability_limits", $data);
$sec_9_vapor_pressure = ACF::getField("sec_9_vapor_pressure", $data);
$sec_9_vapor_desnsity = ACF::getField("sec_9_vapor_desnsity", $data);
$sec_9_specific_gravity = ACF::getField("sec_9_specific_gravity", $data);
$sec_9_bulk_density = ACF::getField("sec_9_bulk_density", $data);
$sec_9_solubility = ACF::getField("sec_9_solubility", $data);
$sec_9_partition_coef = ACF::getField("sec_9_partition_coef", $data);
$sec_9_auto_ignition_temp = ACF::getField("sec_9_auto_ignition_temp", $data);
$sec_9_auto_decomposition_temp = ACF::getField("sec_9_auto_decomposition_temp", $data);
$sec_9_viscosity = ACF::getField("sec_9_viscosity", $data);
$sec_9_volatility = ACF::getField("sec_9_volatility", $data);
$sec_9 = ACF::getField("sec_9", $data);
$sec_10_chemical_stability = ACF::getField("sec_10_chemical_stability", $data);
$sec_10_conditions_to_avoid = ACF::getField("sec_10_conditions_to_avoid", $data);
$sec_10_incompatible = ACF::getField("sec_10_incompatible", $data);
$sec_10_hazardous_products = ACF::getField("sec_10_hazardous_products", $data);
$sec_10_corrosiveness = ACF::getField("sec_10_corrosiveness", $data);
$sec_10_hazardous_polymer = ACF::getField("sec_10_hazardous_polymer", $data);
$sec_10 = ACF::getField("sec_10", $data);
$sec_11_details = ACF::getRowsLayout("sec_11_details", $data);
$sec_11 = ACF::getField("sec_11", $data);
$sec_12_chemical_component = ACF::getRowsLayout("sec_12_chemical_component", $data);
$sec_12 = ACF::getField("sec_12", $data);
$sec_13_description = ACF::getField("sec_13_description", $data);
$sec_13 = ACF::getField("sec_13", $data);
$sec_14_regulatory = ACF::getField("sec_14_regulatory", $data);
$sec_14_id_number = ACF::getField("sec_14_id_number", $data);
$sec_14_hazard_class = ACF::getField("sec_14_hazard_class", $data);
$sec_14_proper_shipping_name = ACF::getField("sec_14_proper_shipping_name", $data);
$sec_14_packing_group = ACF::getField("sec_14_packing_group", $data);
$sec_14_dot_emergency_guide_num = ACF::getField("sec_14_dot_emergency_guide_num", $data);
$sec_14_bulk_transport = ACF::getField("sec_14_bulk_transport", $data);
$sec_14_marpol_annex = ACF::getField("sec_14_marpol_annex", $data);
$sec_14_imo_imdg = ACF::getField("sec_14_imo_imdg", $data);
$sec_14 = ACF::getField("sec_14", $data);
$sec_15_cercla = ACF::getField("sec_15_cercla", $data);
$sec_15_rcra = ACF::getField("sec_15_rcra", $data);
$sec_15_sara_title_iii_section_302_304 = ACF::getField("sec_15_sara_title_iii_section_302_304", $data);
$sec_15_sara_title_iii_rq = ACF::getField("sec_15_sara_title_iii_rq", $data);
$sec_15_sara_title_iii_tpq = ACF::getField("sec_15_sara_title_iii_tpq", $data);
$sec_15_sara_title_iii = ACF::getField("sec_15_sara_title_iii", $data);
$sec_15_section_311_312_acute = ACF::getField("sec_15_section_311_312_acute", $data);
$sec_15_section_311_312_chronic = ACF::getField("sec_15_section_311_312_chronic", $data);
$sec_15_section_311_312_fire = ACF::getField("sec_15_section_311_312_fire", $data);
$sec_15_section_311_312_pressure = ACF::getField("sec_15_section_311_312_pressure", $data);
$sec_15_section_311_312_reactivity = ACF::getField("sec_15_section_311_312_reactivity", $data);
$sec_15_section_311_312 = ACF::getField("sec_15_section_311_312", $data);
$sec_15_section_313 = ACF::getField("sec_15_section_313", $data);
$sec_15_ntp_iarc_osha = ACF::getField("sec_15_ntp_iarc_osha", $data);
$sec_15_canada_dsl = ACF::getField("sec_15_canada_dsl", $data);
$sec_15_canada_ndsl = ACF::getField("sec_15_canada_ndsl", $data);
$sec_15_tsca = ACF::getField("sec_15_tsca", $data);
$sec_15_ca_proposition_65 = ACF::getField("sec_15_ca_proposition_65", $data);
$sec_15_whmis = ACF::getField("sec_15_whmis", $data);
$sec_15_reach_reg = ACF::getField("sec_15_reach_registration", $data);
$sec_15 = ACF::getField("sec_15", $data);
$sec_16_disclaimer = apply_filters("the_content", ACF::getField("sec_16_disclaimer", $data));
$sec_16_preparation = ACF::getField("sec_16_preparation", $data);
$sec_16_revision_date = ACF::getField("sec_16_revision_date", $data);
$sec_16_sections_revised = ACF::getField("sec_16_sections_revised", $data);
$sec_16_sds_number = ACF::getField("sec_16_sds_number", $data);
$sec_16_references = ACF::getField("sec_16_references", $data);
$sec_16_ohc_nfpa_class_health = isset($data["sec_16_ohc_nfpa_class_health"]) ? $data["sec_16_ohc_nfpa_class_health"] : "";
$sec_16_ohc_nfpa_class_flammability = isset($data["sec_16_ohc_nfpa_class_flammability"]) ? $data["sec_16_ohc_nfpa_class_flammability"] : "";
$sec_16_ohc_nfpa_class_instability = isset($data['sec_16_ohc_nfpa_class_instability']) ? $data['sec_16_ohc_nfpa_class_instability'] : "";
$sec_16_ohc_nfpa_class_special_hazard = isset($data['sec_16_ohc_nfpa_class_special_hazard']) ? $data['sec_16_ohc_nfpa_class_special_hazard'] : "";
$sec_16_ohc_nfpa_class = isset($data['sec_16_ohc_nfpa_class']) ? $data['sec_16_ohc_nfpa_class'] : "";
$sec_16_ohc_hmis_class_health = isset($data["sec_16_ohc_hmis_class_health"]) ? $data["sec_16_ohc_hmis_class_health"] : "";
$sec_16_ohc_hmis_class_flammability = isset($data["sec_16_ohc_hmis_class_flammability"]) ? $data["sec_16_ohc_hmis_class_flammability"] : "";
$sec_16_ohc_hmis_class_physical = isset($data["sec_16_ohc_hmis_class_physical"]) ? $data["sec_16_ohc_hmis_class_physical"] : "";
$sec_16_ohc_hmis_class_ppe = isset($data["sec_16_ohc_hmis_class_ppe"]) ? $data["sec_16_ohc_hmis_class_ppe"] : "";
$sec_16_ohc_hmis_class = isset($data["sec_16_ohc_hmis_class"]) ? $data["sec_16_ohc_hmis_class"] : "";
$sec_16_ohc_whis_class_signal_word = apply_filters("the_content", ACF::getField("sec_16_ohc_whis_class_signal_word", $data));
$sec_16_ohc_whis_class_symbol = ACF::getField("sec_16_ohc_whis_class_symbol", $data);
$sec_16_ohc_whis_class_classification = apply_filters("the_content", ACF::getField("sec_16_ohc_whis_class_classification", $data));
$sec_16_ohc_whis_class_hazard_statements = apply_filters("the_content", ACF::getField("sec_16_ohc_whis_class_hazard_statements", $data));
$sec_16_ohc_whis_class = ACF::getField("sec_16_ohc_whis_class", $data);
$sec_16_ohc = ACF::getField("sec_16_ohc", $data);
function textFixture($dt_txt)
{
    if (!empty($dt_txt)) {
        return preg_replace('/H\d+:/i', '<strong>$0</strong>', $dt_txt);
    }
    return $dt_txt;
}

?>


<article id="post-<?php the_ID(); ?>" class="sds-page" data-post-type="sds-page">
    <?php get_template_part('partials/back-to-resources-button'); ?>
    <div class="sds-page__header">
        <!-- Jump to Mobile Section -->
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
                    <ul class="jumptoul">
                        <li>
                            <a uk-scroll class="scroll-tag" href="#sec_1">
                                <?php _e('Section 1 - Product and Company Identification', 'kmag'); ?>
                            </a>
                        </li>
                        <li>
                            <a uk-scroll class="scroll-tag" href="#sec_2">
                                <?php _e('Section 2 — Hazard Identification', 'kmag'); ?> </a>
                        </li>
                        <li>
                            <a uk-scroll class="scroll-tag" href="#sec_3">
                                <?php _e('Section 3 — Composition Information on Ingredients', 'kmag'); ?>
                            </a>
                        </li>
                        <li>
                            <a uk-scroll class="scroll-tag" href="#sec_4">
                                <?php _e('Section 4 — First Aid Measures', 'kmag'); ?>
                            </a>
                        </li>
                        <li>
                            <a uk-scroll class="scroll-tag" href="#sec_5">
                                <?php _e('Section 5 — Fire Fighting Measures', 'kmag'); ?></a>
                        </li>
                        <li>
                            <a uk-scroll class="scroll-tag" href="#sec_6">
                                <?php _e('Section 6 — Accidental Release Measures', 'kmag'); ?></a>
                        </li>
                        <li>
                            <a uk-scroll class="scroll-tag" href="#sec_7">
                                <?php _e('Section 7 — Handling and Storage', 'kmag'); ?>
                            </a>
                        </li>
                        <li>
                            <a uk-scroll class="scroll-tag" href="#sec_8">
                                <?php _e('Section 8 — Exposure Controls / Personal
                            Protection', 'kmag'); ?></a>
                        </li>
                        <li>
                            <a uk-scroll class="scroll-tag" href="#sec_9">
                                <?php _e('Section 9 — Physical and Chemical Properties', 'kmag'); ?>
                            </a>
                        </li>
                        <li>
                            <a uk-scroll class="scroll-tag" href="#sec_10">
                                <?php _e('Section 10 — Stability and Reactivity', 'kmag'); ?>
                            </a>
                        </li>
                        <li>
                            <a uk-scroll class="scroll-tag" href="#sec_11">
                                <?php _e('Section 11 — Toxicological Information', 'kmag'); ?>
                            </a>
                        </li>
                        <li>
                            <a uk-scroll class="scroll-tag"
                               href="#sec_12"><?php _e('Section 12 — Ecological Information', 'kmag'); ?></a>
                        </li>
                        <li>
                            <a uk-scroll class="scroll-tag"
                               href="#sec_13"><?php _e('Section 13 — Disposal Considerations', 'kmag'); ?></a>
                        </li>
                        <li>
                            <a uk-scroll class="scroll-tag"
                               href="#sec_14"><?php _e('Section 14 — Transport Info', 'kmag'); ?></a></li>
                        <li>
                            <a uk-scroll class="scroll-tag"
                               href="#sec_15"><?php _e('Section 15 — Regulatory Information', 'kmag'); ?></a>
                        </li>
                        <li>
                            <a uk-scroll class="scroll-tag"
                               href="#sec_16"><?php _e('Section 16 — Other Information', 'kmag'); ?></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Jump to Mobile Section -->
        <div class="uk-container uk-container-large logo-holder">
            <div class="uk-grid uk-container-large" uk-grid>
                <div class="uk-width-4-5@m uk-width-1-1@s">
                    <h1 class="main-title"><?php _e('Safety Data Sheet ', 'kmag'); ?></h1>
                </div>
            </div>
        </div>
        <div class="uk-container uk-container-large topic-holder">
            <div class="uk-grid uk-container-large" uk-grid>
                <div class="uk-width-1-5@m uk-width-1-1@s share-desktop"></div>
                <div class="uk-width-4-5@m uk-width-1-1@s product-logo-img">
                    <?php if (is_numeric($top_header_product_logo)) {
                        echo Util::getImageHTML(Media::getAttachmentByID($top_header_product_logo)); ?>
                    <?php } ?>
                    <?php if (!empty($top_header_product_name)) { ?>
                        <h4 class="product-name">
                            <strong><?php echo apply_filters('the_title', $top_header_product_name); ?></strong></h4>
                    <?php } ?>
                    <div class="uk-margin-small-top  uk-margin-small-bottom">
                        <div class="uk-grid uk-container-large uk-grid-margin-small" uk-grid>
                            <?php if (!empty($top_header_status)) { ?>
                                <div class="uk-width-1-3@m uk-width-1-1@s uk-margin-small-top">
                                    <span class="sds-page__status">
                                        <?php _e('Status', 'kmag'); ?>: <?php echo esc_html($top_header_status); ?>
                                    </span>
                                </div>
                            <?php } ?>
                            <?php if (!empty($top_header_revision_date)) { ?>
                                <div class="uk-width-1-3@m uk-width-1-1@s uk-margin-small-top">
                                    <span class="sds-page__revision uk-margin-medium-right">
                                        <?php _e('Revision Date', 'kmag'); ?>: <?php echo date_format(date_create($top_header_revision_date), "M d, Y"); ?>
                                    </span>
                                </div>
                            <?php } ?>
                            <?php if (!empty($top_header_product_code)) { ?>
                                <div class="uk-width-1-3@m uk-width-1-1@s uk-margin-small-top">
                                    <span class="sds-page__sds">
                                         <?php _e('SDS # ', 'kmag'); ?>: <?php echo esc_html($top_header_sds); ?>
                                    </span>
                                </div>
                            <?php } ?>
                            <?php if (!empty($top_header_sect_revised)) { ?>
                                <div class="uk-width-1-3@m uk-width-1-1@s uk-margin-small-top">
                                    <span class="sds-page__sec_rev">
                                        <?php _e('Section(s) Revised', 'kmag'); ?>: <?php echo esc_html($top_header_sect_revised); ?>
                                    </span>
                                </div>
                            <?php } ?>
                            <?php if (!empty($top_header_issue_date)) { ?>
                                <div class="uk-width-1-3@m uk-width-1-1@s uk-margin-small-top">
                                    <span class="sds-page__issue_date">
                                        <?php _e('Issue Date', 'kmag'); ?>: <?php echo date_format(date_create($top_header_issue_date), 'm/d/Y'); ?>
                                    </span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <?php if (!empty($top_header_pdf_file)) {
                        $pdf_url = Media::getPdfSrcByID($top_header_pdf_file); ?>
                        <a href="<?php echo esc_url($pdf_url); ?>" target="_blank" class="btn btn-primary download-btn">
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
    <div class="sds-page__body">
        <div class="uk-grid uk-container-large" uk-grid>
            <div class="uk-width-1-5@m uk-width-1-1@s share-desktop section-common-left">
                <!-- Jump to DeskTop Section -->
                <div class="jump-to-desktop-wrapper">
                    <h4 class="uk-margin-small-bottom"><?php _e('JUMP TO:', 'kmag'); ?></h4>
                    <ul class="jumptoul">
                        <li>
                            <a uk-scroll class="scroll-tag" href="#sec_1">
                                <?php _e('Section 1 - Product and Company Identification', 'kmag'); ?>
                            </a>
                        </li>
                        <li>
                            <a uk-scroll class="scroll-tag" href="#sec_2">
                                <?php _e('Section 2 — Hazard Identification', 'kmag'); ?>
                            </a>
                        </li>
                        <li>
                            <a uk-scroll class="scroll-tag" href="#sec_3">
                                <?php _e('Section 3 — Composition Information on Ingredients', 'kmag'); ?>
                            </a>
                        </li>
                        <li>
                            <a uk-scroll class="scroll-tag" href="#sec_4">
                                <?php _e(' Section 4 — First Aid Measures', 'kmag'); ?>
                            </a>
                        </li>
                        <li>
                            <a uk-scroll class="scroll-tag" href="#sec_5">
                                <?php _e('Section 5 — Fire Fighting Measures', 'kmag'); ?>
                            </a>
                        </li>
                        <li>
                            <a uk-scroll class="scroll-tag" href="#sec_6">
                                <?php _e('Section 6 — Accidental Release Measures', 'kmag'); ?>
                            </a>
                        </li>
                        <li>
                            <a uk-scroll class="scroll-tag" href="#sec_7">
                                <?php _e('Section 7 — Handling and Storage', 'kmag'); ?>
                            </a>
                        </li>
                        <li>
                            <a uk-scroll class="scroll-tag" href="#sec_8">
                                <?php _e('Section 8 — Exposure Controls / Personal Protection', 'kmag'); ?>
                            </a>
                        </li>
                        <li>
                            <a uk-scroll class="scroll-tag" href="#sec_9">
                                <?php _e('Section 9 — Physical and Chemical Properties', 'kmag'); ?>
                            </a>
                        </li>
                        <li>
                            <a uk-scroll class="scroll-tag" href="#sec_10">
                                <?php _e('Section 10 — Stability and Reactivity', 'kmag'); ?>
                            </a>
                        </li>
                        <li>
                            <a uk-scroll class="scroll-tag" href="#sec_11">
                                <?php _e('Section 11 — Toxicological Information', 'kmag'); ?>
                            </a>
                        </li>
                        <li>
                            <a uk-scroll class="scroll-tag" href="#sec_12">
                                <?php _e('Section 12 — Ecological Information', 'kmag'); ?>
                            </a>
                        </li>
                        <li>
                            <a uk-scroll class="scroll-tag" href="#sec_13">
                                <?php _e('Section 13 — Disposal Considerations', 'kmag'); ?>
                            </a>
                        </li>
                        <li>
                            <a uk-scroll class="scroll-tag" href="#sec_14">
                                <?php _e('Section 14 — Transport Info', 'kmag'); ?>
                            </a>
                        </li>
                        <li>
                            <a uk-scroll class="scroll-tag" href="#sec_15">
                                <?php _e('Section 15 — Regulatory Information', 'kmag'); ?>
                            </a>
                        </li>
                        <li>
                            <a uk-scroll class="scroll-tag" href="#sec_16">
                                <?php _e('Section 16 — Other Information', 'kmag'); ?>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="uk-width-4-5@m uk-width-1-1@s section-right">

                <div id="sec_1" class="sds-page-section__body sds-sec-1-body">
                    <div class="sds-page-section-holder">
                        <h2 class="sds-sec-heading">
                            <?php _e('Section 1 — Product and Company Identification', 'kmag'); ?>
                        </h2>
                    </div>
                    <div class="uk-grid uk-container-large" uk-grid>
                        <div class="uk-width-expand@m uk-width-1-1@s">
                            <h5 class="super-top-subheading"><?php _e('Chemical Name', 'kmag'); ?></h5>
                            <div class="box-body"><?php echo esc_html($sec_1_chemical_name); ?></div>
                        </div>
                        <div class="uk-width-1-3@m uk-width-1-1@s">
                            <h5 class="super-top-subheading"><?php _e('CAS Number', 'kmag'); ?></h5>
                            <div class="box-body"><?php echo esc_html($sec_1_cas_number); ?></div>
                        </div>
                    </div>
                    <div class="uk-grid uk-container-large" uk-grid>
                        <div class="uk-width-expand@m uk-width-1-1@s">
                            <h5 class="super-top-subheading"><?php _e('Synonyms', 'kmag'); ?></h5>
                            <div class="box-body">
                                <?php echo apply_filters('the_content', $sec_1_synonyms); ?>
                            </div>
                        </div>
                        <div class="uk-width-1-3@m uk-width-1-1@s">
                            <h5 class="super-top-subheading"><?php _e('Primary Use', 'kmag'); ?></h5>
                            <div class="box-body"><?php echo esc_html($sec_1_primary_use); ?></div>
                        </div>
                    </div>
                    <div class="uk-grid uk-container-large" uk-grid>
                        <div class="uk-width-1-1@m uk-width-1-1@s">
                            <h5 class="super-top-subheading"><?php _e('Company Information', 'kmag'); ?></h5>
                        </div>
                    </div>
                    <div class="uk-grid uk-container-large uk-margin-small-top" uk-grid>
                        <div class="uk-width-expand@m uk-width-1-1@s">
                            <h3 class="box-heading"><?php _e('Corporate Headquarters', 'kmag'); ?></h3>
                            <div class="box-body"><?php echo apply_filters("the_content", $sec_1_comp_info_corp_headquarters); ?></div>
                        </div>
                        <div class="uk-width-1-3@m uk-width-1-1@s">
                            <h3 class="box-heading"><?php _e('US Guarantor', 'kmag'); ?></h3>
                            <div class="box-body"><?php echo apply_filters("the_content", $sec_1_comp_info_us_guarantor); ?></div>
                        </div>
                    </div>
                    <div class="uk-grid uk-container-large" uk-grid>
                        <div class="uk-width-expand@m uk-width-1-1@s">
                            <h3 class="box-heading"><?php _e('Canada Guarantor', 'kmag'); ?></h3>
                            <div class="box-body"><?php echo apply_filters("the_content", $sec_1_comp_info_canada_headquarters); ?></div>
                        </div>
                        <div class="uk-width-1-3@m uk-width-1-1@s">
                            <h3 class="box-heading"><?php _e('Contact Info', 'kmag'); ?></h3>
                            <div class="box-body"><?php echo apply_filters("the_content", $sec_1_comp_info_contact_info); ?></div>
                        </div>
                    </div>
                    <div class="uk-grid uk-container-large" uk-grid>
                        <div class="uk-width-expand@m uk-width-1-1@s">
                            <h5 class="super-top-subheading"><?php _e('Emergency Contacts', 'kmag'); ?></h5>
                            <div class="box-heading-sub uk-margin-small-bottom emergency-dt-holder">
                                <?php echo apply_filters("the_content", $sec_1_emergency_contact); ?>
                            </div>
                        </div>
                        <div class="uk-width-1-3@m uk-width-1-1@s"></div>
                    </div>
                </div>

                <div id="sec_2" class="sds-page-section__body sds-sec-2-body">
                    <div class="sds-page-section-holder">
                        <h2 class="sds-sec-heading"><?php _e('Section 2 — Hazard Identification', 'kmag'); ?></h2>
                    </div>
                    <div class="uk-grid uk-container-large uk-margin-large-bottom" uk-grid>
                        <div class="uk-width-1-1@m uk-width-1-1@s">
                            <h5 class="super-top-subheading"><?php _e('OSHA / HCS Status', 'kmag'); ?></h5>
                            <div class="box-body"><?php echo esc_html($sec_2_osha_hcs_status); ?></div>
                        </div>
                    </div>

                    <div class="ghs-grid-container-desktop">
                        <div class="ghs-grid-header-1 super-top-subheading"><?php _e('GHS Classification', 'kmag'); ?></div>
                        <div class="ghs-grid-header-2 super-top-subheading"><?php _e('Signal Word : ', 'kmag'); ?><?php echo esc_html($sec_2_signal_word); ?>
                            <br><?php _e('Hazard Statement(s)', 'kmag'); ?></div>
                        <?php
                        foreach ($sec_2_ghs_classification as $index => $secghs) { ?>
                            <div class="ghs-grid-item"><?php echo esc_html($secghs['column_ghs_1']); ?></div>
                            <div class="ghs-grid-item"><?php echo esc_html($secghs['column_ghs_2']); ?></div>
                            <?php if ($index == 0) { ?>
                                <div class="ghs-grid-item"
                                     style="grid-row: span <?php echo count($sec_2_ghs_classification); ?>;text-align: center;">
                                    <?php if (is_numeric($sec_2_warning_symbol)) {
                                        echo Util::getImageHTML(Media::getAttachmentByID($sec_2_warning_symbol)); ?>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                            <div class="ghs-grid-item <?php if ($index == 0) {
                                echo 'ghs-hazd-col';
                            } ?>"><?php echo apply_filters('the_content', textFixture($secghs['column_hazard_3'])); ?></div>
                            <?php
                        } ?>
                    </div>
                    <div class="ghs-container-mobile">
                        <div class="super-top-subheading"><?php _e('GHS Classification', 'kmag'); ?></div>
                        <div class="ghs-sub1-container">
                            <?php foreach ($sec_2_ghs_classification as $secghs) { ?>
                                <div class="ghs-grp">
                                    <div class="ghs-cnt-item"><?php echo esc_html($secghs['column_ghs_1']); ?></div>
                                    <div class="ghs-cnt-item"><?php echo esc_html($secghs['column_ghs_2']); ?></div>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="ghs-sub2-container">
                            <div class="super-top-subheading"><?php _e('Signal Word : ', 'kmag'); ?><?php echo esc_html($sec_2_signal_word); ?>
                                <br><?php _e('Hazard Statement(s)', 'kmag'); ?></div>
                            <div>
                                <?php if (is_numeric($sec_2_warning_symbol)) {
                                    echo Util::getImageHTML(Media::getAttachmentByID($sec_2_warning_symbol)); ?>
                                <?php } ?>
                            </div>
                            <?php foreach ($sec_2_ghs_classification as $secghs) { ?>
                                <div class="ghs-cnt-item"><?php echo apply_filters('the_content', textFixture($secghs['column_hazard_3'])); ?></div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="uk-grid uk-container-large">
                        <div class="uk-width-1-1@m uk-width-1-1@s">
                            <h5 class="super-top-subheading"><?php _e('Label Elements', 'kmag'); ?></h5>
                        </div>
                        <div class="uk-width-1-3@m uk-width-1-1@s">
                            <h3 class="box-heading"><?php _e('Prevention', 'kmag'); ?></h3>
                        </div>
                        <?php if (count($sec_2_label_ele_prevention_list) === 0) { ?>
                            <div class="uk-width-expand@m uk-width-1-1@s">
                                <?php _e('Not applicable', 'kmag'); ?>
                            </div>
                        <?php } ?>
                    </div>

                    <?php foreach ($sec_2_label_ele_prevention_list as $prevention) { ?>
                        <div class="uk-grid uk-container-large uk-margin-small-top" uk-grid>
                            <div class="uk-width-1-3@m uk-width-1-1@s">
                                <p class="prevention-heading"><?php echo esc_html($prevention['label']); ?></p>
                            </div>
                            <div class="uk-width-expand@m uk-width-1-1@s">
                                <div class="box-body"><?php echo apply_filters("the_content", $prevention['description']); ?></div>
                            </div>
                        </div>
                    <?php } ?>

                    <div class="uk-grid uk-container-large">
                        <div class="uk-width-1-3@m uk-width-1-1@s">
                            <h3 class="box-heading"><?php _e('Response', 'kmag'); ?></h3>
                        </div>
                        <?php if (count($sec_2_label_ele_response_list) === 0) { ?>
                            <div class="uk-width-expand@m uk-width-1-1@s">
                                <?php _e('Not applicable', 'kmag'); ?>
                            </div>
                        <?php } ?>
                    </div>

                    <?php foreach ($sec_2_label_ele_response_list as $response) { ?>
                        <div class="uk-grid uk-container-large uk-margin-small-top" uk-grid>
                            <div class="uk-width-1-3@m uk-width-1-1@s">
                                <p class="prevention-heading"><?php echo esc_html($response['label']); ?></p>
                            </div>
                            <div class="uk-width-expand@m uk-width-1-1@s">
                                <div class="box-body"><?php echo apply_filters("the_content", $response['description']); ?></div>
                            </div>
                        </div>
                    <?php } ?>


                    <div class="uk-grid uk-container-large" uk-grid>
                        <div class="uk-width-1-1@m uk-width-1-1@s">
                            <h3 class="box-heading"><?php _e('Storage', 'kmag'); ?></h3>
                        </div>
                    </div>
                    <?php foreach ($sec_2_label_ele_storage_list as $storage) { ?>
                        <div class="uk-grid uk-container-large uk-margin-small-top" uk-grid>
                            <div class="uk-width-1-3@m uk-width-1-1@s">
                                <p class="prevention-heading"><?php echo esc_html($storage['label']); ?></p>
                            </div>
                            <div class="uk-width-expand@m uk-width-1-1@s">
                                <div class="box-body"><?php echo apply_filters("the_content", $storage['description']); ?></div>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="uk-grid uk-container-large" uk-grid>
                        <div class="uk-width-1-1@m uk-width-1-1@s">
                            <h3 class="box-heading"><?php _e('Disposal', 'kmag'); ?></h3>
                        </div>
                    </div>
                    <?php foreach ($sec_2_label_ele_disposal_list as $disposal) { ?>
                        <div class="uk-grid uk-container-large uk-margin-small-top" uk-grid>
                            <div class="uk-width-1-3@m uk-width-1-1@s">
                                <p class="prevention-heading"><?php echo esc_html($disposal['label']); ?></p>
                            </div>
                            <div class="uk-width-expand@m uk-width-1-1@s">
                                <div class="box-body"><?php echo apply_filters("the_content", $disposal['description']); ?></div>
                            </div>
                        </div>
                    <?php } ?>
                </div>

                <div id="sec_3" class="sds-page-section__body sds-sec-3-body">
                    <div class="sds-page-section-holder">
                        <h2 class="sds-sec-heading"><?php _e('Section 3 — Composition Information on
                            Ingredients', 'kmag'); ?></h2>
                    </div>
                    <div class="uk-grid uk-container-large" uk-grid>
                        <div class="uk-width-1-1@m uk-width-1-1@s">
                            <h5 class="super-top-subheading"><?php _e('Formula', 'kmag'); ?></h5>
                            <div class="box-body"><?php echo esc_html($sec_3_formula); ?></div>
                        </div>
                        <div class="uk-width-5-1@m uk-width-1-1@s">
                            <h5 class="super-top-subheading"><?php _e('Composition', 'kmag'); ?></h5>
                            <div class="box-body">
                                <table class="composition-table">
                                    <tbody>
                                    <?php foreach ($sec_3_composition_list as $composition) { ?>
                                        <tr>
                                            <td><?php echo esc_html($composition['label']); ?></td>
                                            <td><?php echo esc_html($composition['code']); ?></td>
                                            <td><?php echo esc_html($composition['range']); ?></td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="sec_4" class="sds-page-section__body sds-sec-4-body">
                    <div class="sds-page-section-holder">
                        <h2 class="sds-sec-heading">
                            <?php _e('Section 4 — First Aid Measures', 'kmag'); ?></h2>
                        <h5 class="super-top-subheading"><?php _e('First Aid Procedures', 'kmag'); ?></h5>
                    </div>
                    <div class="uk-grid uk-container-large" uk-grid>
                        <?php foreach ($sec_4_first_aid_list as $first_aid) { ?>
                            <div class="uk-width-1-2@m uk-width-1-1@s">
                                <h3 class="sub-top-subheading"><?php echo esc_html($first_aid['label']); ?></h3>
                                <div class="box-body"><?php echo esc_html($first_aid['description']); ?></div>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="sds-page-section-holder uk-margin-medium-top">
                        <h5 class="super-top-subheading"><?php _e('Note to Physician', 'kmag'); ?></h5>
                    </div>
                    <div class="uk-grid uk-container-large" uk-grid>
                        <div class="uk-width-1-1@m uk-width-1-1@s">
                            <div class="box-body"><?php echo esc_html($sec_4_note_to_physician); ?></div>
                        </div>
                    </div>
                </div>

                <div id="sec_5" class="sds-page-section__body sds-sec-5-body">
                    <div class="sds-page-section-holder">
                        <h2 class="sds-sec-heading"><?php _e('Section 5 — Fire Fighting Measures', 'kmag'); ?></h2>
                    </div>
                    <div class="uk-grid uk-container-large" uk-grid>
                        <div class="uk-width-1-2@m uk-width-1-1@s">
                            <?php if (!empty($sec_5_extinguish)) { ?>
                                <h5 class="super-top-subheading"><?php _e('Extinguishing Media', 'kmag'); ?></h5>
                                <div class="box-body"><?php echo esc_html($sec_5_extinguish); ?></div>
                            <?php } ?>
                        </div>
                        <div class="uk-width-1-2@m uk-width-1-1@s">
                            <?php if (!empty($sec_5_protection)) { ?>
                                <h5 class="super-top-subheading"><?php _e('Protection of Firefighters', 'kmag'); ?></h5>
                                <div class="box-body"><?php echo esc_html($sec_5_protection); ?></div>
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <div id="sec_6" class="sds-page-section__body sds-sec-6-body">
                    <div class="sds-page-section-holder">
                        <h2 class="sds-sec-heading"><?php _e('Section 6 — Accidental Release Measures', 'kmag'); ?></h2>
                    </div>
                    <div class="uk-grid uk-container-large" uk-grid>
                        <div class="uk-width-1-1@m uk-width-1-1@s">
                            <h5 class="super-top-subheading"><?php _e('Response Techniques', 'kmag'); ?></h5>
                            <div class="box-body"><?php echo esc_html($sec_6_response_tech); ?></div>
                        </div>
                    </div>
                </div>

                <div id="sec_7" class="sds-page-section__body sds-sec-7-body">
                    <div class="sds-page-section-holder">
                        <h2 class="sds-sec-heading"><?php _e('Section 7 — Handling and Storage', 'kmag'); ?></h2>
                    </div>
                    <div class="uk-grid uk-container-large" uk-grid>
                        <div class="uk-width-1-2@m uk-width-1-1@s">
                            <?php if (!empty($sec_7_handling)) { ?>
                                <h5 class="super-top-subheading"><?php _e('Handling', 'kmag'); ?></h5>
                                <div class="box-body"><?php echo esc_html($sec_7_handling); ?></div>
                            <?php } ?>
                        </div>
                        <div class="uk-width-1-2@m uk-width-1-1@s">
                            <?php if (!empty($sec_7_storage)) { ?>
                                <h5 class="super-top-subheading"><?php _e('Storage', 'kmag'); ?></h5>
                                <div class="box-body"><?php echo esc_html($sec_7_storage); ?></div>
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <div id="sec_8" class="sds-page-section__body sds-sec-8-body">
                    <div class="sds-page-section-holder">
                        <h2 class="sds-sec-heading"><?php _e('Section 8 — Exposure Controls / Personal Protection', 'kmag'); ?></h2>
                    </div>
                    <div class="uk-grid uk-container-large" uk-grid>
                        <div class="uk-width-1-1@m uk-width-1-1@s">
                            <?php if (!empty($sec_8_engineering_control)) { ?>
                                <h5 class="super-top-subheading"><?php _e('Engineering Controls', 'kmag'); ?></h5>
                                <div class="box-body"><?php echo esc_html($sec_8_engineering_control); ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <?php if (count($sec_8_ppe_list) > 0) { ?>
                        <div class="uk-grid uk-container-large" uk-grid>
                            <div class="uk-width-1-1@m uk-width-1-1@s">
                                <h5 class="super-top-subheading"><?php _e('Personal Protective Equipment (PPE)', 'kmag'); ?></h5>
                            </div>
                            <?php foreach ($sec_8_ppe_list as $ppe) { ?>
                                <div class="uk-width-1-2@m uk-width-1-1@s">
                                    <h3 class="sub-top-subheading"><?php echo esc_html($ppe['label']); ?></h3>
                                    <div class="box-body"><?php echo apply_filters('the_content', $ppe['description']); ?></div>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } ?>
                    <div class="uk-grid uk-container-large" uk-grid>
                        <div class="uk-width-1-1@m uk-width-1-1@s">
                            <?php if (!empty($sec_8_general_hygience)) { ?>
                                <h5 class="super-top-subheading"><?php _e('General Hygiene Considerations', 'kmag'); ?></h5>
                                <div class="box-body"><?php echo esc_html($sec_8_general_hygience); ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <?php if (count($sec_8_exposure_list) > 0) { ?>
                        <div class="uk-grid uk-container-large" uk-grid>
                            <div class="uk-width-1-1@m uk-width-1-1@s">
                                <h5 class="super-top-subheading"><?php _e('Exposure Guidelines', 'kmag'); ?></h5>
                            </div>
                            <?php foreach ($sec_8_exposure_list as $exposure) { ?>
                                <div class="uk-width-1-2@m uk-width-1-1@s">
                                    <h3 class="sub-top-subheading"><?php echo esc_html($exposure['label']); ?></h3>
                                    <div class="box-body"><?php echo apply_filters('the_content', $exposure['description']); ?></div>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } ?>
                    <?php if (count($sec_8_saskatchewan_list) > 0) { ?>
                        <div class="uk-grid uk-container-large" uk-grid>
                            <div class="uk-width-1-1@m uk-width-1-1@s">
                                <h5 class="super-top-subheading"><?php _e('Saskatchewan', 'kmag'); ?></h5>
                            </div>
                            <?php foreach ($sec_8_saskatchewan_list as $saskatchewan) { ?>
                                <div class="uk-width-1-2@m uk-width-1-1@s">
                                    <h3 class="box-heading"><?php echo esc_html($saskatchewan['label']); ?></h3>
                                    <div class="box-body"><?php echo apply_filters('the_content', $saskatchewan['description']); ?></div>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>

                <div id="sec_9" class="sds-page-section__body sds-sec-9-body">
                    <div class="sds-page-section-holder">
                        <h2 class="sds-sec-heading"><?php _e('Section 9 — Physical and Chemical Properties ', 'kmag'); ?></h2>
                        <div class="box-body uk-margin-medium-bottom">
                            <?php _e('Note :', 'kmag'); ?><?php echo esc_html($sec_9_note); ?>
                        </div>
                    </div>
                    <div class="uk-grid uk-container-large" uk-grid>
                        <div class="uk-width-1-2@m uk-width-1-1@s">
                            <div class="uk-grid uk-container-large" uk-grid>
                                <div class="uk-width-1-2@m uk-width-1-1@s">
                                    <h3 class="table-heading"><?php _e('Appearance ', 'kmag'); ?></h3>
                                </div>
                                <div class="uk-width-expand@m uk-width-1-1@s">
                                    <div class="box-body"><?php echo esc_html($sec_9_appearance); ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="uk-width-1-2@m uk-width-1-1@s">
                            <div class="uk-grid uk-container-large" uk-grid>
                                <div class="uk-width-1-2@m uk-width-1-1@s">
                                    <h3 class="table-sub-heading"><?php _e('Vapor Pressure (mm Hg) ', 'kmag'); ?></h3>
                                </div>
                                <div class="uk-width-expand@m uk-width-1-1@s">
                                    <div class="box-body"><?php echo esc_html($sec_9_vapor_pressure); ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="uk-grid uk-container-large" uk-grid>
                        <div class="uk-width-1-2@m uk-width-1-1@s">
                            <div class="uk-grid uk-container-large" uk-grid>
                                <div class="uk-width-1-2@m uk-width-1-1@s">
                                    <h3 class="table-heading"><?php _e('Odor ', 'kmag'); ?></h3>
                                </div>
                                <div class="uk-width-expand@m uk-width-1-1@s">
                                    <div class="box-body"><?php echo esc_html($sec_9_odor); ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="uk-width-1-2@m uk-width-1-1@s">
                            <div class="uk-grid uk-container-large" uk-grid>
                                <div class="uk-width-1-2@m uk-width-1-1@s">
                                    <h3 class="table-sub-heading"><?php _e('Vapor Density (air=1) ', 'kmag'); ?></h3>
                                </div>
                                <div class="uk-width-expand@m uk-width-1-1@s">
                                    <div class="box-body"><?php echo esc_html($sec_9_vapor_desnsity); ?></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="uk-grid uk-container-large" uk-grid>
                        <div class="uk-width-1-2@m uk-width-1-1@s">
                            <div class="uk-grid uk-container-large" uk-grid>
                                <div class="uk-width-1-2@m uk-width-1-1@s">
                                    <h3 class="table-heading"><?php _e('Odor Threshold ', 'kmag'); ?></h3>
                                </div>
                                <div class="uk-width-expand@m uk-width-1-1@s">
                                    <div class="box-body"><?php echo esc_html($sec_9_odor_threshold); ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="uk-width-1-2@m uk-width-1-1@s">
                            <div class="uk-grid uk-container-large" uk-grid>
                                <div class="uk-width-1-2@m uk-width-1-1@s">
                                    <h3 class="table-sub-heading"><?php _e('Specific Gravity or Relative Density ', 'kmag'); ?></h3>
                                </div>
                                <div class="uk-width-expand@m uk-width-1-1@s">
                                    <div class="box-body"><?php echo esc_html($sec_9_specific_gravity); ?></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="uk-grid uk-container-large" uk-grid>
                        <div class="uk-width-1-2@m uk-width-1-1@s">
                            <div class="uk-grid uk-container-large" uk-grid>
                                <div class="uk-width-1-2@m uk-width-1-1@s">
                                    <h3 class="table-heading"><?php _e('Physical state ', 'kmag'); ?></h3>
                                </div>
                                <div class="uk-width-expand@m uk-width-1-1@s">
                                    <div class="box-body"><?php echo esc_html($sec_9_physical_state); ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="uk-width-1-2@m uk-width-1-1@s">
                            <div class="uk-grid uk-container-large" uk-grid>
                                <div class="uk-width-1-2@m uk-width-1-1@s">
                                    <h3 class="table-sub-heading"><?php _e('Bulk Density ', 'kmag'); ?></h3>
                                </div>
                                <div class="uk-width-expand@m uk-width-1-1@s">
                                    <div class="box-body"><?php echo esc_html($sec_9_bulk_density); ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="uk-grid uk-container-large" uk-grid>
                        <div class="uk-width-1-2@m uk-width-1-1@s">
                            <div class="uk-grid uk-container-large" uk-grid>
                                <div class="uk-width-1-2@m uk-width-1-1@s">
                                    <h3 class="table-heading"><?php _e('pH ', 'kmag'); ?></h3>
                                </div>
                                <div class="uk-width-expand@m uk-width-1-1@s">
                                    <div class="box-body"><?php echo esc_html($sec_9_ph); ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="uk-width-1-2@m uk-width-1-1@s">
                            <div class="uk-grid uk-container-large" uk-grid>
                                <div class="uk-width-1-2@m uk-width-1-1@s">
                                    <h3 class="table-sub-heading"><?php _e('Solubility in Water ', 'kmag'); ?></h3>
                                </div>
                                <div class="uk-width-expand@m uk-width-1-1@s">
                                    <div class="box-body"><?php echo esc_html($sec_9_solubility); ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="uk-grid uk-container-large" uk-grid>
                        <div class="uk-width-1-2@m uk-width-1-1@s">
                            <div class="uk-grid uk-container-large" uk-grid>
                                <div class="uk-width-1-2@m uk-width-1-1@s">
                                    <h3 class="table-heading"><?php _e('Melting Point/ Freezing Point ', 'kmag'); ?>
                                    </h3>
                                </div>
                                <div class="uk-width-expand@m uk-width-1-1@s">
                                    <div class="box-body"><?php echo esc_html($sec_9_melting_freezing_points); ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="uk-width-1-2@m uk-width-1-1@s">
                            <div class="uk-grid uk-container-large" uk-grid>
                                <div class="uk-width-1-2@m uk-width-1-1@s">
                                    <h3 class="table-sub-heading"><?php _e('Partition coefficient ', 'kmag'); ?></h3>
                                </div>
                                <div class="uk-width-expand@m uk-width-1-1@s">
                                    <div class="box-body"><?php echo esc_html($sec_9_partition_coef); ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="uk-grid uk-container-large" uk-grid>
                        <div class="uk-width-1-2@m uk-width-1-1@s">
                            <div class="uk-grid uk-container-large" uk-grid>
                                <div class="uk-width-1-2@m uk-width-1-1@s">
                                    <h3 class="table-heading"><?php _e('Boiling Point', 'kmag'); ?></h3>
                                </div>
                                <div class="uk-width-expand@m uk-width-1-1@s">
                                    <div class="box-body"><?php echo esc_html($sec_9_boiling_point); ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="uk-width-1-2@m uk-width-1-1@s">
                            <div class="uk-grid uk-container-large" uk-grid>
                                <div class="uk-width-1-2@m uk-width-1-1@s">
                                    <h3 class="table-sub-heading"><?php _e('Auto-Ignition Temperature', 'kmag'); ?></h3>
                                </div>
                                <div class="uk-width-expand@m uk-width-1-1@s">
                                    <div class="box-body"><?php echo esc_html($sec_9_auto_ignition_temp); ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="uk-grid uk-container-large" uk-grid>
                        <div class="uk-width-1-2@m uk-width-1-1@s">
                            <div class="uk-grid uk-container-large" uk-grid>
                                <div class="uk-width-1-2@m uk-width-1-1@s">
                                    <h3 class="table-heading"><?php _e('Flash Point', 'kmag'); ?></h3>
                                </div>
                                <div class="uk-width-expand@m uk-width-1-1@s">
                                    <div class="box-body"><?php echo esc_html($sec_9_flash_point); ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="uk-width-1-2@m uk-width-1-1@s">
                            <div class="uk-grid uk-container-large" uk-grid>
                                <div class="uk-width-1-2@m uk-width-1-1@s">
                                    <h3 class="table-sub-heading"><?php _e('Decomposition Temperature', 'kmag'); ?></h3>
                                </div>
                                <div class="uk-width-expand@m uk-width-1-1@s">
                                    <div class="box-body"><?php echo esc_html($sec_9_auto_decomposition_temp); ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="uk-grid uk-container-large" uk-grid>
                        <div class="uk-width-1-2@m uk-width-1-1@s">
                            <div class="uk-grid uk-container-large" uk-grid>
                                <div class="uk-width-1-2@m uk-width-1-1@s">
                                    <h3 class="table-heading"><?php _e('Evaporation Rate', 'kmag'); ?></h3>
                                </div>
                                <div class="uk-width-expand@m uk-width-1-1@s">
                                    <div class="box-body"><?php echo esc_html($sec_9_evaporation_rate); ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="uk-width-1-2@m uk-width-1-1@s">
                            <div class="uk-grid uk-container-large" uk-grid>
                                <div class="uk-width-1-2@m uk-width-1-1@s">
                                    <h3 class="table-sub-heading"><?php _e('Viscosity', 'kmag'); ?></h3>
                                </div>
                                <div class="uk-width-expand@m uk-width-1-1@s">
                                    <div class="box-body"><?php echo esc_html($sec_9_viscosity); ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="uk-grid uk-container-large" uk-grid>
                        <div class="uk-width-1-2@m uk-width-1-1@s">
                            <div class="uk-grid uk-container-large" uk-grid>
                                <div class="uk-width-1-2@m uk-width-1-1@s">
                                    <h3 class="table-heading"><?php _e('Flammability', 'kmag'); ?></h3>
                                </div>
                                <div class="uk-width-expand@m uk-width-1-1@s">
                                    <div class="box-body"><?php echo esc_html($sec_9_flammability); ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="uk-width-1-2@m uk-width-1-1@s">
                            <div class="uk-grid uk-container-large" uk-grid>
                                <div class="uk-width-1-2@m uk-width-1-1@s">
                                    <h3 class="table-sub-heading"><?php _e('Volatility', 'kmag'); ?></h3>
                                </div>
                                <div class="uk-width-expand@m uk-width-1-1@s">
                                    <div class="box-body"><?php echo esc_html($sec_9_volatility); ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="uk-grid uk-container-large" uk-grid>
                        <div class="uk-width-1-2@m uk-width-1-1@s">
                            <div class="uk-grid uk-container-large" uk-grid>
                                <div class="uk-width-1-2@m uk-width-1-1@s">
                                    <h3 class="table-heading"><?php _e('Upper/Lower Flammability or explosive limits', 'kmag'); ?></h3>
                                </div>
                                <div class="uk-width-expand@m uk-width-1-1@s">
                                    <div class="box-body"><?php echo esc_html($sec_9_flammability_limits); ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="uk-width-1-2@m uk-width-1-1@s"></div>
                    </div>


                </div>

                <div id="sec_10" class="sds-page-section__body sds-sec-10-body">
                    <div class="sds-page-section-holder">
                        <h2 class="sds-sec-heading"><?php _e('Section 10 — Stability and Reactivity', 'kmag'); ?></h2>
                    </div>
                    <?php if (!empty($sec_10_chemical_stability)) { ?>
                        <div class="uk-grid uk-container-large" uk-grid>
                            <div class="uk-width-1-3@m uk-width-1-1@s">
                                <h3 class="table-heading"><?php _e('Chemical Stability', 'kmag'); ?></h3>
                            </div>
                            <div class="uk-width-expand@m uk-width-1-1@s">
                                <div class="box-body"><?php echo esc_html($sec_10_chemical_stability); ?></div>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (!empty($sec_10_conditions_to_avoid)) { ?>
                        <div class="uk-grid uk-container-large" uk-grid>
                            <div class="uk-width-1-3@m uk-width-1-1@s">
                                <h3 class="table-heading"><?php _e('Conditions to Avoid', 'kmag'); ?></h3>
                            </div>
                            <div class="uk-width-expand@m uk-width-1-1@s">
                                <div class="box-body"><?php echo esc_html($sec_10_conditions_to_avoid); ?></div>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (!empty($sec_10_incompatible)) { ?>
                        <div class="uk-grid uk-container-large" uk-grid>
                            <div class="uk-width-1-3@m uk-width-1-1@s">
                                <h3 class="table-heading"><?php _e('Incompatible Materials', 'kmag'); ?></h3>
                            </div>
                            <div class="uk-width-expand@m uk-width-1-1@s">
                                <div class="box-body"><?php echo esc_html($sec_10_incompatible); ?></div>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (!empty($sec_10_hazardous_products)) { ?>
                        <div class="uk-grid uk-container-large" uk-grid>
                            <div class="uk-width-1-3@m uk-width-1-1@s">
                                <h3 class="table-heading"><?php _e('Hazardous Decomposition Products', 'kmag'); ?></h3>
                            </div>
                            <div class="uk-width-expand@m uk-width-1-1@s">
                                <div class="box-body"><?php echo esc_html($sec_10_hazardous_products); ?></div>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (!empty($sec_10_corrosiveness)) { ?>
                        <div class="uk-grid uk-container-large" uk-grid>
                            <div class="uk-width-1-3@m uk-width-1-1@s">
                                <h3 class="table-heading"><?php _e('Corrosiveness', 'kmag'); ?></h3>
                            </div>
                            <div class="uk-width-expand@m uk-width-1-1@s">
                                <div class="box-body"><?php echo esc_html($sec_10_corrosiveness); ?></div>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (!empty($sec_10_hazardous_polymer)) { ?>
                        <div class="uk-grid uk-container-large" uk-grid>
                            <div class="uk-width-1-3@m uk-width-1-1@s">
                                <h3 class="table-heading"><?php _e('Hazardous Polymerization', 'kmag'); ?></h3>
                            </div>
                            <div class="uk-width-expand@m uk-width-1-1@s">
                                <div class="box-body"><?php echo esc_html($sec_10_hazardous_polymer); ?></div>
                            </div>
                        </div>
                    <?php } ?>
                </div>

                <div id="sec_11" class="sds-page-section__body sds-sec-11-body">
                    <div class="sds-page-section-holder">
                        <h2 class="sds-sec-heading"><?php _e('Section 11 — Toxicological Information', 'kmag'); ?></h2>
                    </div>
                    <div class="uk-grid uk-container-large" uk-grid>
                        <?php foreach ($sec_11_details as $details) { ?>
                            <div class="uk-width-1-2@m uk-width-1-1@s">
                                <h5 class="super-top-subheading table-margin-bottom"><?php echo esc_html($details['chemical_component']); ?></h5>
                                <?php
                                $toxicological_information = ACF::getRowsLayout('toxicological_information', $details);
                                foreach ($toxicological_information as $toxi_info) {
                                    ?>
                                    <div class="uk-grid uk-container-large" uk-grid>
                                        <div class="uk-width-1-2@m uk-width-1-1@s">
                                            <h3 class="table-heading"><?php echo esc_html($toxi_info['label']); ?></h3>
                                        </div>
                                        <div class="uk-width-1-2@m uk-width-1-1@s">
                                            <div class="box-body"><?php echo $toxi_info['description']; ?></div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <div id="sec_12" class="sds-page-section__body sds-sec-12-body">
                    <div class="sds-page-section-holder">
                        <h2 class="sds-sec-heading"><?php _e('Section 12 — Ecological Information', 'kmag'); ?></h2>
                    </div>
                    <div class="uk-grid uk-container-large" uk-grid>
                        <?php foreach ($sec_12_chemical_component as $chemical_comp) { ?>
                            <div class="uk-width-1-2@m uk-width-1-1@s">
                                <h5 class="super-top-subheading table-margin-bottom"><?php echo esc_html($chemical_comp['label']); ?></h5>
                                <h3 class="sub-top-subheading"><?php echo esc_html($chemical_comp['type']); ?></h3>
                                <div class="box-body"><?php echo apply_filters('the_content', $chemical_comp['description']); ?></div>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <div id="sec_13" class="sds-page-section__body sds-sec-13-body">
                    <div class="sds-page-section-holder">
                        <h2 class="sds-sec-heading"><?php _e('Section 13 — Disposal Considerations', 'kmag'); ?></h2>
                    </div>
                    <div class="uk-grid uk-container-large" uk-grid>
                        <div class="uk-width-1-1@m uk-width-1-1@s">
                            <div class="box-body"><?php echo esc_html($sec_13_description); ?></div>
                        </div>
                    </div>
                </div>

                <div id="sec_14" class="sds-page-section__body sds-sec-14-body">
                    <div class="sds-page-section-holder">
                        <h2 class="sds-sec-heading"><?php _e('Section 14 — Transport Info', 'kmag'); ?></h2>
                    </div>
                    <div class="uk-grid uk-container-large" uk-grid>
                        <div class="uk-width-1-2@m uk-width-1-1@s">
                            <h3 class="table-heading"><?php _e('Regulatory Status', 'kmag'); ?></h3>
                        </div>
                        <div class="uk-width-1-2@m uk-width-1-1@s">
                            <div class="box-body"><?php echo esc_html($sec_14_regulatory); ?></div>
                        </div>
                    </div>
                    <div class="uk-grid uk-container-large" uk-grid>
                        <div class="uk-width-1-2@m uk-width-1-1@s">
                            <h3 class="table-heading"><?php _e('Identification Number', 'kmag'); ?></h3>
                        </div>
                        <div class="uk-width-1-2@m uk-width-1-1@s">
                            <div class="box-body"><?php echo esc_html($sec_14_id_number); ?></div>
                        </div>
                    </div>
                    <div class="uk-grid uk-container-large" uk-grid>
                        <div class="uk-width-1-2@m uk-width-1-1@s">
                            <h3 class="table-heading"><?php _e('Hazard Class', 'kmag'); ?></h3>
                        </div>
                        <div class="uk-width-1-2@m uk-width-1-1@s">
                            <div class="box-body"><?php echo esc_html($sec_14_hazard_class); ?></div>
                        </div>
                    </div>
                    <div class="uk-grid uk-container-large" uk-grid>
                        <div class="uk-width-1-2@m uk-width-1-1@s">
                            <h3 class="table-heading"><?php _e('Proper Shipping Name', 'kmag'); ?></h3>
                        </div>
                        <div class="uk-width-1-2@m uk-width-1-1@s">
                            <div class="box-body"><?php echo esc_html($sec_14_proper_shipping_name); ?></div>
                        </div>
                    </div>
                    <div class="uk-grid uk-container-large" uk-grid>
                        <div class="uk-width-1-2@m uk-width-1-1@s">
                            <h3 class="table-heading"><?php _e('Packing Group', 'kmag'); ?></h3>
                        </div>
                        <div class="uk-width-1-2@m uk-width-1-1@s">
                            <div class="box-body"><?php echo esc_html($sec_14_packing_group); ?></div>
                        </div>
                    </div>
                    <div class="uk-grid uk-container-large" uk-grid>
                        <div class="uk-width-1-2@m uk-width-1-1@s">
                            <h3 class="table-heading"><?php _e('DOT Emergency Response Guide Number', 'kmag'); ?>
                            </h3>
                        </div>
                        <div class="uk-width-1-2@m uk-width-1-1@s">
                            <div class="box-body"><?php echo esc_html($sec_14_dot_emergency_guide_num); ?></div>
                        </div>
                    </div>
                    <div class="uk-grid uk-container-large" uk-grid>
                        <div class="uk-width-1-2@m uk-width-1-1@s">
                            <h3 class="table-heading"><?php _e('Transport in bulk according to Annex II of MARPOL 73/78 and the IBC Code', 'kmag'); ?>
                            </h3>
                        </div>
                        <div class="uk-width-1-2@m uk-width-1-1@s">
                            <div class="box-body"><?php echo esc_html($sec_14_bulk_transport); ?></div>
                        </div>
                    </div>
                    <div class="uk-grid uk-container-large" uk-grid>
                        <div class="uk-width-1-2@m uk-width-1-1@s">
                            <h3 class="table-heading"><?php _e('MARPOL Annex V', 'kmag'); ?></h3>
                        </div>
                        <div class="uk-width-1-2@m uk-width-1-1@s">
                            <div class="box-body"><?php echo esc_html($sec_14_marpol_annex); ?></div>
                        </div>
                    </div>
                    <div class="uk-grid uk-container-large" uk-grid>
                        <div class="uk-width-1-2@m uk-width-1-1@s">
                            <h3 class="table-heading"><?php _e('IMO/IMDG', 'kmag'); ?></h3>
                        </div>
                        <div class="uk-width-1-2@m uk-width-1-1@s">
                            <div class="box-body"><?php echo esc_html($sec_14_imo_imdg); ?></div>
                        </div>
                    </div>
                </div>

                <div id="sec_15" class="sds-page-section__body sds-sec-15-body">
                    <div class="sds-page-section-holder">
                        <h2 class="sds-sec-heading"><?php _e('Section 15 — Transport Info', 'kmag'); ?></h2>
                    </div>
                    <div class="uk-grid uk-container-large" uk-grid>
                        <div class="uk-width-1-2@m uk-width-1-1@s">
                            <?php if (!empty($sec_15_cercla)) { ?>
                                <h3 class="box-heading"><?php _e('CERCLA', 'kmag'); ?></h3>
                                <div class="box-body"><?php echo esc_html($sec_15_cercla); ?></div>
                            <?php } ?>
                        </div>
                        <div class="uk-width-1-2@m uk-width-1-1@s">
                            <?php if (!empty($sec_15_rcra)) { ?>
                                <h3 class="box-heading"><?php _e('RCRA 261.33', 'kmag'); ?></h3>
                                <div class="box-body"><?php echo esc_html($sec_15_rcra); ?></div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="uk-grid uk-container-large" uk-grid>
                        <div class="uk-width-1-1@m uk-width-1-1@s">
                            <div class="uk-grid uk-container-large" uk-grid>
                                <div class="uk-width-1-1@m uk-width-1-1@s">
                                    <h3 class="box-heading"><?php _e('SARA Title III', 'kmag'); ?></h3>
                                    <div class="box-body"><?php _e('(Exemptions at 40 CFR, Part 370 may apply for agricultural use, or for quantities of less than 10,000 pounds on-site.)', 'kmag'); ?></div>
                                </div>
                                <div class="uk-width-1-3@m uk-width-1-1@s">
                                    <?php if (!empty($sec_15_sara_title_iii_section_302_304)) { ?>
                                        <h3 class="sub-top-subheading"><?php _e('Section 302/304', 'kmag'); ?></h3>
                                        <div class="box-body"><?php echo esc_html($sec_15_sara_title_iii_section_302_304); ?></div>
                                    <?php } ?>
                                </div>
                                <div class="uk-width-1-3@m uk-width-1-1@s">
                                    <?php if (!empty($sec_15_sara_title_iii_rq)) { ?>
                                        <h3 class="sub-top-subheading"><?php _e('RQ', 'kmag'); ?></h3>
                                        <div class="box-body"><?php echo esc_html($sec_15_sara_title_iii_rq); ?></div>
                                    <?php } ?>
                                </div>
                                <div class="uk-width-1-3@m uk-width-1-1@s">
                                    <?php if (!empty($sec_15_sara_title_iii_tpq)) { ?>
                                        <h3 class="sub-top-subheading"><?php _e('TPQ', 'kmag'); ?></h3>
                                        <div class="box-body"><?php echo esc_html($sec_15_sara_title_iii_tpq); ?></div>
                                    <?php } ?>
                                </div>
                                <div class="uk-width-1-1@m uk-width-1-1@s uk-margin-small-bottom">
                                    <h3 class="box-heading-sub"><?php _e('Section 311/312', 'kmag'); ?></h3>
                                </div>
                                <div class="uk-width-1-3@m uk-width-1-1@s uk-margin-small-top">
                                    <?php if (!empty($sec_15_section_311_312_acute)) { ?>
                                        <h3 class="sub-top-subheading"><?php _e('Acute', 'kmag'); ?></h3>
                                        <div class="box-body"><?php echo esc_html($sec_15_section_311_312_acute); ?></div>
                                    <?php } ?>
                                </div>
                                <div class="uk-width-1-3@m uk-width-1-1@s uk-margin-small-top">
                                    <?php if (!empty($sec_15_section_311_312_chronic)) { ?>
                                        <h3 class="sub-top-subheading"><?php _e('Chronic', 'kmag'); ?></h3>
                                        <div class="box-body"><?php echo esc_html($sec_15_section_311_312_chronic); ?></div>
                                    <?php } ?>
                                </div>
                                <div class="uk-width-1-3@m uk-width-1-1@s uk-margin-small-top">
                                    <?php if (!empty($sec_15_section_311_312_fire)) { ?>
                                        <h3 class="sub-top-subheading"><?php _e('Fire', 'kmag'); ?></h3>
                                        <div class="box-body"><?php echo esc_html($sec_15_section_311_312_fire); ?></div>
                                    <?php } ?>
                                </div>
                                <div class="uk-width-1-3@m uk-width-1-1@s uk-margin-small-top">
                                    <?php if (!empty($sec_15_section_311_312_pressure)) { ?>
                                        <h3 class="sub-top-subheading"><?php _e('Pressure', 'kmag'); ?></h3>
                                        <div class="box-body"><?php echo esc_html($sec_15_section_311_312_pressure); ?></div>
                                    <?php } ?>
                                </div>
                                <div class="uk-width-1-3@m uk-width-1-1@s uk-margin-small-top">
                                    <?php if (!empty($sec_15_section_311_312_reactivity)) { ?>
                                        <h3 class="sub-top-subheading"><?php _e('Reactivity', 'kmag'); ?></h3>
                                        <div class="box-body"><?php echo esc_html($sec_15_section_311_312_reactivity); ?></div>
                                    <?php } ?>
                                </div>

                                <div class="uk-width-1-1@m uk-width-1-1@s uk-margin-small-top">
                                    <?php if (!empty($sec_15_section_313)) { ?>
                                        <h3 class="sub-top-subheading"><?php _e('Section 313', 'kmag'); ?></h3>
                                        <div class="box-body"><?php echo esc_html($sec_15_section_313); ?></div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="uk-grid uk-container-large" uk-grid>
                        <div class="uk-width-1-3@m uk-width-1-1@s">
                            <?php if (!empty($sec_15_ntp_iarc_osha)) { ?>
                                <h3 class="box-heading"><?php _e('NTP, IARC, OSHA', 'kmag'); ?></h3>
                                <div class="box-body"><?php echo esc_html($sec_15_ntp_iarc_osha); ?></div>
                            <?php } ?>
                        </div>
                        <div class="uk-width-1-3@m uk-width-1-1@s">
                            <?php if (!empty($sec_15_canada_dsl) || !empty($sec_15_canada_ndsl)) { ?>
                                <h3 class="box-heading"><?php _e('Canada DSL and NDSL', 'kmag'); ?></h3>
                                <div class="uk-grid uk-container-large" uk-grid>
                                    <div class="uk-width-1-2@m uk-width-1-1@s">
                                        <?php if (!empty($sec_15_canada_dsl)) { ?>
                                            <h3 class="sub-top-subheading"><?php _e('DSL', 'kmag'); ?></h3>
                                            <div class="box-body"><?php echo esc_html($sec_15_canada_dsl); ?></div>
                                        <?php } ?>
                                    </div>
                                    <div class="uk-width-1-2@m uk-width-1-1@s">
                                        <?php if (!empty($sec_15_canada_ndsl)) { ?>
                                            <h3 class="sub-top-subheading"><?php _e('NDSL', 'kmag'); ?></h3>
                                            <div class="box-body"><?php echo esc_html($sec_15_canada_ndsl); ?></div>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="uk-width-1-3@m uk-width-1-1@s">
                            <?php if (!empty($sec_15_tsca)) { ?>
                                <h3 class="box-heading"><?php _e('TSCA', 'kmag'); ?></h3>
                                <div class="box-body"><?php echo esc_html($sec_15_tsca); ?></div>
                            <?php } ?>
                        </div>
                    </div>


                    <div class="uk-grid uk-container-large" uk-grid>
                        <div class="uk-width-1-1@m uk-width-1-1@s">
                            <?php if (!empty($sec_15_ca_proposition_65)) { ?>
                                <h3 class="box-heading"><?php _e('CA Proposition 65', 'kmag'); ?></h3>
                                <div class="box-body">
                                    <?php echo esc_html($sec_15_ca_proposition_65); ?>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="uk-width-1-1@m uk-width-1-1@s">
                            <div class="uk-grid uk-container-large" uk-grid>
                                <div class="uk-width-1-6@m uk-width-1-1@s">
                                    <div>
                                        <svg class="icon danger-symbol" width="86" height="77">
                                            <use xlink:href="#danger-symbol"></use>
                                        </svg>
                                    </div>
                                </div>
                                <div class="uk-width-expand@m uk-width-1-1@s">
                                    <h4 class="warning-sec"><?php _e('WARNING: Cancer and reproductive Harm – www.P65Warnings.ca.gov', 'kmag'); ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="uk-grid uk-container-large" uk-grid>
                        <div class="uk-width-1-1@m uk-width-1-1@s">
                            <?php if (!empty($sec_15_whmis)) { ?>
                                <h3 class="box-heading"><?php _e('WHMIS', 'kmag'); ?></h3>
                                <h3 class="sub-top-subheading"><?php _e('WHMIS 2015', 'kmag'); ?></h3>
                                <div class="box-body"><?php echo esc_html($sec_15_whmis); ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="uk-grid uk-container-large" uk-grid>
                        <div class="uk-width-1-1@m uk-width-1-1@s">
                            <?php if (!empty($sec_15_reach_reg)) { ?>
                                <h3 class="box-heading"><?php _e('REACH Registration', 'kmag'); ?></h3>
                                <h3 class="sub-top-subheading"><?php _e('Substance Names', 'kmag'); ?></h3>
                                <div class="box-body"><?php echo esc_html($sec_15_reach_reg); ?></div>
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <div id="sec_16" class="sds-page-section__body sds-sec-16-body">
                    <div class="sds-page-section-holder">
                        <h2 class="sds-sec-heading"><?php _e('Section 16 — Other Information', 'kmag'); ?></h2>
                    </div>
                    <div class="sec16_disclaimer">
                        <?php if (!empty($sec_16_disclaimer)) { ?>
                            <h5 class="super-top-subheading"><?php _e('Disclaimer', 'kmag'); ?></h5>
                            <div class="box-body"><?php echo apply_filters('the_content', $sec_16_disclaimer); ?></div>
                        <?php } ?>
                    </div>
                    <div class="uk-grid uk-container-large uk-margin-medium-top uk-margin-medium-bottom" uk-grid>
                        <div class="uk-width-1-2@m uk-width-1-1@s">
                            <?php if (!empty($sec_16_preparation)) { ?>
                                <h5 class="super-top-subheading"><?php _e('Preparation', 'kmag'); ?></h5>
                                <div class="box-body"><?php echo esc_html($sec_16_preparation); ?></div>
                            <?php } ?>
                        </div>
                        <div class="uk-width-1-2@m uk-width-1-1@s">
                            <?php if (!empty($sec_16_revision_date)) { ?>
                                <h5 class="super-top-subheading"><?php _e('Revision Date', 'kmag'); ?></h5>
                                <div class="box-body"><?php echo date_format(date_create($sec_16_revision_date), "M d, Y"); ?></div>
                            <?php } ?>
                        </div>
                        <div class="uk-width-1-2@m uk-width-1-1@s">
                            <?php if (!empty($sec_16_sections_revised)) { ?>
                                <h5 class="super-top-subheading"><?php _e('Sections Revised', 'kmag'); ?></h5>
                                <div class="box-body"><?php echo esc_html($sec_16_sections_revised); ?></div>
                            <?php } ?>
                        </div>
                        <div class="uk-width-1-2@m uk-width-1-1@s">
                            <?php if (!empty($sec_16_sds_number)) { ?>
                                <h5 class="super-top-subheading"><?php _e('SDS Number', 'kmag'); ?></h5>
                                <div class="box-body"><?php echo esc_html($sec_16_sds_number); ?></div>
                            <?php } ?>
                        </div>
                        <div class="uk-width-1-1@m uk-width-1-1@s">
                            <?php if (!empty($sec_16_references)) { ?>
                                <h5 class="super-top-subheading"><?php _e('References', 'kmag'); ?></h5>
                                <div class="box-body"><?php echo esc_html($sec_16_references); ?></div>
                            <?php } ?>
                        </div>
                    </div>

                    <div>
                        <h3 class="sec16_hazard_clf">
                            <?php _e('Other Hazard Classifications', 'kmag'); ?>
                        </h3>
                        <div class="uk-margin-medium-bottom uk-margin-medium-top">
                            <h5 class="super-top-subheading table-margin-bottom"><?php _e('NFPA HAZARD CLASS', 'kmag'); ?></h5>
                            <div class="uk-grid uk-container-large" uk-grid>
                                <div class="uk-width-1-4@m uk-width-1-1@s">
                                    <h3 class="sub-top-subheading"><?php _e('Health', 'kmag'); ?></h3>
                                    <div class="box-body uk-margin-small-top"><?php echo esc_html($sec_16_ohc_nfpa_class_health); ?></div>
                                </div>
                                <div class="uk-width-1-4@m uk-width-1-1@s">
                                    <h3 class="sub-top-subheading"><?php _e('Flammability', 'kmag'); ?></h3>
                                    <div class="box-body uk-margin-small-top"><?php echo esc_html($sec_16_ohc_nfpa_class_flammability); ?></div>
                                </div>
                                <div class="uk-width-1-4@m uk-width-1-1@s">
                                    <h3 class="sub-top-subheading"><?php _e('Instability', 'kmag'); ?></h3>
                                    <div class="box-body uk-margin-small-top"><?php echo esc_html($sec_16_ohc_nfpa_class_instability); ?></div>
                                </div>
                                <div class="uk-width-1-4@m uk-width-1-1@s">
                                    <h3 class="sub-top-subheading"><?php _e('Special Hazard', 'kmag'); ?></h3>
                                    <div class="box-body uk-margin-small-top"><?php echo esc_html($sec_16_ohc_nfpa_class_special_hazard); ?></div>
                                </div>
                            </div>
                        </div>


                        <div class="uk-margin-medium-bottom">
                            <h5 class="super-top-subheading table-margin-bottom"><?php _e('HMIS HAZARD CLASS', 'kmag'); ?></h5>
                            <div class="uk-grid uk-container-large" uk-grid>
                                <div class="uk-width-1-4@m uk-width-1-1@s">
                                    <h3 class="sub-top-subheading"><?php _e('Health', 'kmag'); ?></h3>
                                    <div class="box-body uk-margin-small-top"><?php echo esc_html($sec_16_ohc_hmis_class_health); ?></div>
                                </div>
                                <div class="uk-width-1-4@m uk-width-1-1@s">
                                    <h3 class="sub-top-subheading"><?php _e('Flammability', 'kmag'); ?></h3>
                                    <div class="box-body uk-margin-small-top"><?php echo esc_html(strval($sec_16_ohc_hmis_class_flammability)); ?></div>
                                </div>
                                <div class="uk-width-1-4@m uk-width-1-1@s">
                                    <h3 class="sub-top-subheading"><?php _e('Physical Hazard', 'kmag'); ?></h3>
                                    <div class="box-body uk-margin-small-top"><?php echo esc_html($sec_16_ohc_hmis_class_physical); ?></div>
                                </div>
                                <div class="uk-width-1-4@m uk-width-1-1@s">
                                    <h3 class="sub-top-subheading"><?php _e('PPE', 'kmag'); ?></h3>
                                    <div class="box-body uk-margin-small-top"><?php echo esc_html($sec_16_ohc_hmis_class_ppe); ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="uk-margin-medium-bottom">
                            <h5 class="super-top-subheading table-margin-bottom"><?php _e('WHMIS 2015 (HPR) HAZARD CLASS', 'kmag'); ?></h5>
                            <div class="uk-grid uk-container-large" uk-grid>
                                <div class="uk-width-1-4@m uk-width-1-1@s">
                                    <?php if (!empty($sec_16_ohc_whis_class_signal_word)) { ?>
                                        <h3 class="sub-top-subheading"><?php _e('Signal Word', 'kmag'); ?></h3>
                                        <div class="box-body uk-margin-small-top"><?php echo apply_filters('the_content', $sec_16_ohc_whis_class_signal_word); ?></div>
                                    <?php } ?>
                                </div>
                                <div class="uk-width-1-4@m uk-width-1-1@s">
                                    <?php if (!empty($sec_16_ohc_whis_class_symbol)) { ?>
                                        <h3 class="sub-top-subheading"><?php _e('Symbol', 'kmag'); ?></h3>
                                        <div class="box-body uk-margin-small-top">
                                            <?php if (is_numeric($sec_16_ohc_whis_class_symbol)) {
                                                echo Util::getImageHTML(Media::getAttachmentByID($sec_16_ohc_whis_class_symbol)); ?>
                                            <?php } ?>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="uk-width-1-4@m uk-width-1-1@s">
                                    <?php if (!empty($sec_16_ohc_whis_class_classification)) { ?>
                                        <h3 class="sub-top-subheading"><?php _e('Classification', 'kmag'); ?></h3>
                                        <div class="box-body uk-margin-small-top"><?php echo apply_filters('the_content', $sec_16_ohc_whis_class_classification); ?></div>
                                    <?php } ?>
                                </div>
                                <div class="uk-width-1-4@m uk-width-1-1@s">
                                    <?php if (!empty($sec_16_ohc_whis_class_hazard_statements)) { ?>
                                        <h3 class="sub-top-subheading"><?php _e('Hazard Statements', 'kmag'); ?></h3>
                                        <div class="box-body uk-margin-small-top"><?php echo apply_filters('the_content', $sec_16_ohc_whis_class_hazard_statements); ?></div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</article>
