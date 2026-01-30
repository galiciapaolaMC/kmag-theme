<?php
/**
 * Agrifacts template file.
 */

use CN\App\Media;
use CN\App\Fields\ACF;
use CN\App\Fields\Util;

$post_id = get_the_ID();
$data = ACF::getPostMeta($post_id);
$agrifacts_pdf = ACF::getField('agrifact_pdf', $data);
$article_introduction = ACF::getField('article_intro', $data);
$article_body = ACF::getField('article_body', $data);
$study_date = ACF::getField('study_date', $data);
try {
    if(!empty($study_date)) {
        $study_date = date('F Y', strtotime($study_date));
    }
} catch (Exception $e) {
    $study_date = '';
}
$study_code = ACF::getField('study_code', $data);
$study_topic = ACF::getField('study_topic', $data);
$article_tags = get_the_terms($post_id, 'article-tag');
$crop_obj = wp_get_post_terms($post_id, 'crop');
$crop_names = [];
if (count($crop_obj)) {
    foreach ($crop_obj as $crop) {
        $crop_names[] = strtolower($crop->slug);
    }
}

$study_dynamic_datas = ACF::getField('yield_stats', $data);
$study_dynamic_datas = Util::convertJsonQuotes($study_dynamic_datas);
$unitExtracted = null;
$amountExtracted = null;
$study_dyn_code = [];
$index = 0;
if (is_array($study_dynamic_datas)) {
    foreach ($study_dynamic_datas as $study_dyn_data) {
        if (isset($study_dyn_data['unit']) && !empty($study_dyn_data['unit'])) {
            $unitExtracted = $study_dyn_data['unit'];
            $unitExtracted = strtoupper($unitExtracted);
        }
        if (isset($study_dyn_data['amount']) && !empty($study_dyn_data['amount'])) {
            $amountExtracted = $study_dyn_data['amount'];
        }

        if (str_contains($amountExtracted, '%')) {
            $study_dyn_code[$index]['measured_in'] = $amountExtracted;
        } else {
            $study_dyn_code[$index]['measured_in'] = $amountExtracted . ' ' . $unitExtracted;
        }
        $study_dyn_code[$index]['for_study'] = $study_dyn_data['description'];
        $index++;
    }
}

?>
<article id="post-<?php the_ID(); ?>" class="agrifact" data-post-type="agrifact">
    <?php get_template_part('partials/back-to-resources-button'); ?>
    <div class="agrifact__header">
        <div class="logo-container">
            <div class="uk-container">
                <svg class="icon icon-agrifact" aria-hidden="true">
                    <use xlink:href="#icon-agrifact"></use>
                </svg>
            </div>
        </div>
        <div class="uk-container uk-container-large">
            <div class="uk-grid uk-container-large" uk-grid>
                <div class="uk-width-1-5@m uk-width-1-1@s"></div>
                <div class="uk-width-4-5@m uk-width-1-1@s entry-container">
                    <?php if (count($crop_names)) { ?>
                        <div class="studied-product-holder-main">
                            <?php
                            foreach ($crop_names as $crop_name) {
                                ?>
                                <div class="studied-product-holder">
                                    <svg class="icon icon-<?php echo esc_attr($crop_name); ?>">
                                        <use xlink:href="#icon-<?php echo esc_attr($crop_name); ?>"></use>
                                    </svg>
                                </div>
                                <?php
                            } ?>
                        </div>
                    <?php } ?>
                    <?php
                    the_title('<h1 class="hdg hdg--1">', '</h1>');
                    ?>
                    <?php if (!empty($study_date)) { ?>
                        <p class="study-date"><?php echo esc_html($study_date); ?></p>
                    <?php } ?>
                    <?php if (!empty($study_code)) { ?>
                        <p class="study-code"><?php echo esc_html($study_code); ?></p>
                    <?php } ?>
                    <?php if (!empty($study_topic)) { ?>
                        <p class="study-sub-topic"><?php echo esc_html($study_topic); ?></p>
                    <?php } ?>
                    <!-- getting data via json -->
                    <?php foreach ($study_dyn_code as $sdc) { ?>
                        <p class="study-code"><?php echo esc_html($sdc['measured_in']); ?></p>
                        <p class="study-sub-topic"><?php echo esc_html($sdc['for_study']); ?></p>
                    <?php } ?>
                    <?php if (!empty($agrifacts_pdf)) {
                        $pdf_url = Media::getPdfSrcByID($agrifacts_pdf); ?>
                        <a href="<?php echo esc_url($pdf_url); ?>" target="_blank"
                           class="btn btn-primary btn-agrifact-download">
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


    <div class="agrifact__body">
        <div class="uk-grid uk-container-large" uk-grid>
            <div class="uk-width-1-5@m uk-width-1-1@s agrifact__share-container share-desktop">
                <p><?php _e('SHARE:', 'kmag'); ?></p>
                <?php echo sharethis_inline_buttons(); ?>
            </div>
            <div class="uk-width-4-5@m uk-width-1-1@s entry-container">
                <?php if (!empty($article_introduction)) { ?>
                    <div class="entry-introduction">
                        <h2 class="hdg hdg--3"><?php _e('Objective', 'kmag'); ?></h2>
                        <?php echo apply_filters('the_content', $article_introduction); ?>
                    </div>
                <?php } ?>
                <div class="entry-content">
                    <?php echo apply_filters('the_content', $article_body); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="agrifact__related-content">
        <?php
        get_template_part('partials/related-content', null,
            array(
                'data' => array(
                    'post_id' => $post_id,
                    'post_type' => get_post_type($post_id)
                )
            )
        );
        ?>
    </div>
    <div class="agrifact__share-container share-mobile">
        <p><?php _e('SHARE:', 'kmag'); ?></p>
        <?php echo sharethis_inline_buttons(); ?>
    </div>
</article>
