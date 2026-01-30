<?php
/**
 * ACF Module: Frontier Field Trial Data Block
 * @var array $data
 * @var string $row_id
 *
 */

use CN\App\Fields\ACF;
use CN\App\Fields\Util;
use CN\App\Media;

// Configuration Data
$section_class = ACF::getField('section_class', $data);
$section_name = ACF::getField('headline', $data);
$section_desc = ACF::getField('content', $data);
$columns = ACF::getRowsLayout('columns', $data);
$gap_size = ACF::getField('gap_size', $data);
$reverse_columns_mobile = ACF::getField('reverse_mobile', $data);
$column_count = count($columns);
if (!empty($section_class)) {
    $section_class = " {$section_class}";
}

// Image Desktop
$trial_image_id = ACF::getField('trial_data_image', $data);
$has_trial_image = !empty($trial_image_id);
$trial_data_image = $has_trial_image ? Media::getAttachmentByID($trial_image_id) : false;
$trial_image_src = $trial_data_image ? ACF::getField('full', $trial_data_image->sizes, $trial_data_image->url) : null;
$trial_image_alt = '';
if ($has_trial_image) {
    $trial_image_alt = !empty($trial_data_image->alt) ? esc_attr($trial_data_image->alt) : esc_attr($trial_data_image->title);
}
// Image Mobile
$trial_image_mobile_id = ACF::getField('trial_data_mobile_image', $data);
$has_trial_image_mobile = !empty($trial_image_mobile_id);
$trial_data_image_mobile = $has_trial_image_mobile ? Media::getAttachmentByID($trial_image_mobile_id) : false;
$trial_image_src_mobile = $trial_data_image_mobile ? ACF::getField('medium_large', $trial_data_image_mobile->sizes, $trial_data_image_mobile->url) : null;
$trial_image_alt_mobile = '';
if ($has_trial_image_mobile) {
    $trial_image_alt_mobile = !empty($trial_data_image_mobile->alt) ? esc_attr($trial_data_image_mobile->alt) : esc_attr($trial_data_image_mobile->title);
}

// Trial Data
$trial_data_crop = ACF::getField('trial_data_crop', $data);
$trial_data_fertility_timing = ACF::getField('trial_data_fertility_timing', $data);
$trial_data_organic_matter = ACF::getField('trial_data_organic_matter', $data);
$trial_data_trial_objective = ACF::getField('trial_data_trial_objective', $data);
$trial_data_solid_type_mix = ACF::getField('trial_data_solid_type_mix', $data);
$trial_data_yield_comparison = ACF::getField('trial_data_yield_comparison', $data, 'N/A');
$trial_data_biopath_application = ACF::getField('trial_data_biopath_application', $data);
$soil_type_mix_label = '';
$soil_type_mix_data = $trial_data_solid_type_mix;
if (!empty($trial_data_solid_type_mix)) {
    $mix = explode(':', $trial_data_solid_type_mix, 2);
    if (count($mix) > 1) {
        list($soil_type_mix_label, $soil_type_mix_data) = $mix;
    }
}
do_action('cn/modules/styles', $row_id, $data);
?>

<section id="<?php echo esc_attr($row_id); ?>"
         class="module frontier-field-trial-block <?php echo esc_attr($section_class); ?>">
    <div class="uk-container">
        <div class="main-wrapper">
            <div class="main-wrapper__body">
                <div class="image-holder">
                    <img class="image-holder__image" src="<?php echo esc_url($trial_image_src); ?>"
                         alt="<?php echo esc_attr($trial_image_alt); ?>">
                    <img class="image-holder__mobile-image" src="<?php echo esc_url($trial_image_src_mobile); ?>"
                         alt="<?php echo esc_attr($trial_image_alt_mobile); ?>">
                </div>
                <div class="data-wrapper">
                    <div class="left-block">
                        <div class="inner-content">
                            <div class="inner-content__item">
                                <div class="item_heading"><?php _e('Crop:', 'kmag'); ?></div>
                                <div class="item-description"><?php echo esc_html($trial_data_crop); ?></div>
                            </div>
                            <div class="inner-content__item">
                                <div class="item_heading"><?php _e('Fertility Timing:', 'kmag'); ?></div>
                                <div class="item-description"><?php echo esc_html($trial_data_fertility_timing); ?></div>
                            </div>
                            <div class="inner-content__item">
                                <div class="item_heading"><?php _e('Organic Matter:', 'kmag'); ?></div>
                                <div class="item-description"><?php echo esc_html($trial_data_organic_matter); ?></div>
                            </div>
                            <div class="inner-content__item">
                                <div class="item_heading"><?php _e('Trial Objectives:', 'kmag'); ?></div>
                                <div class="item-description"><?php echo esc_html($trial_data_trial_objective); ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="right-block">
                        <div class="inner-content">
                            <div class="inner-content__item">
                                <div class="item_heading"><?php _e('Soil Type Mix:', 'kmag'); ?></div>
                                <?php if(!empty($soil_type_mix_label)):?>
                                <div class="item-label"><?php echo esc_html($soil_type_mix_label); ?>:</div>
                                <?php endif; ?>
                                <div class="item-description"><?php echo esc_html($soil_type_mix_data); ?></div>
                            </div>
                            <div class="inner-content__item">
                                <div class="item_heading"><?php _e('Yield Comparison:', 'kmag'); ?></div>
                                <div class="item-description yield-wrapper">
                                    <div><?php echo esc_html($trial_data_yield_comparison) . ' '; ?></div>
                                    <div class="item-bu-ac-label"><?php _e('bu/ac', 'kmag') ?></div>
                                </div>
                            </div>
                            <div class="inner-content__item">
                                <div class="item_heading"><?php _e('BioPath Application:', 'kmag'); ?></div>
                                <div class="item-description"><?php echo esc_html($trial_data_biopath_application); ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

