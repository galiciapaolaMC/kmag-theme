<?php
/**
 * TruResponse Trial Data template file.
 */

use CN\App\Media;
use CN\App\Fields\ACF;
use CN\App\Fields\Util;
use CN\App\Fields\Options;

$post_id = get_the_ID();
$data = ACF::getPostMeta($post_id);
$trial_data_year = ACF::getField('trial-data-year', $data);
$trial_data_code = ACF::getField('trial-data-code', $data);
$trial_data_topic = ACF::getField('trial-data-topic', $data);
$additional_statistics = ACF::getRowsLayout('additional-statistics', $data);
$trial_data_pdf = ACF::getField('trial-data-pdf', $data);
$objective = ACF::getField('objective', $data);
$overview_list = ACF::getRowsLayout('overview-list', $data);
$trial_details = ACF::getField('trial-details', $data);
$summary_list = ACF::getRowsLayout('summary', $data);
$trial_data = ACF::getField('activate-trial-data', $data);
$options = Options::getSiteOptions();
$field_group = 'trial-data-banner';
$headline = ACF::getField("{$field_group}_headline", $options);
$content = ACF::getField("{$field_group}_content", $options);
$cta_link = ACF::getField("{$field_group}_cta-link", $options);

$background_image_desktop_id = ACF::getField("{$field_group}_image-desktop-id", $options);
$background_image_desktop_url = '';
if (!empty($background_image_desktop_id)) {
    $background_image_desktop_url = Media::getAttachmentSrcByID($background_image_desktop_id);
}

$background_image_mobile_id = ACF::getField("{$field_group}_image-mobile-id", $options);
$background_image_mobile_url = '';
if (!empty($background_image_mobile_id)) {
    $background_image_mobile_url = Media::getAttachmentSrcByID($background_image_mobile_id);
}

// Related content
$article_tags = get_the_terms($post_id, 'article-tag');
$related_posts = [];
if  (!empty($article_tags)) {
	$tag_array = array();
	$tag_filter = '';

	foreach ($article_tags as $tag) {
		$tag_array[] = $tag->slug;
		$tag_filter .= $tag->slug . ',';
	}

	$args = array(
		'post_type' => 'robust-articles',
		'post__not_in' => array($post_id),
		'posts_per_page' => 6,
		'tax_query' => array(
            array(
                'taxonomy' => 'article-tag',
                'field'    => 'slug',
                'terms'    => $tag_array
            ),
		)
	);

	$related_posts = get_post( $args );
}

$crop_obj = wp_get_post_terms($post_id, 'crop');
$crop_names = [];
if (count($crop_obj)) {
    foreach ($crop_obj as $crop) {
        $crop_names[] = strtolower($crop->slug);
    }
}

if (empty($trial_details)) {
    return;
}
?>

<article id="post-<?php the_ID(); ?>" class="trures-trial-data" data-post-type="true-response-trial-data">
    <?php get_template_part('partials/back-to-resources-button'); ?>
    <div class="trures-trial-data__header">
        <div class="logo-container">
            <div class="uk-container">
                <svg class="icon icon-trures-trial-data" aria-hidden="true">
                    <use xlink:href="#icon-trures-trial-data"></use>
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

                    <?php the_title('<h1 class="hdg hdg--1">', '</h1>'); ?>

                    <?php if (!empty($trial_data_year)) { ?>
                        <p class="trial-data-year"><?php echo esc_html($trial_data_year); ?></p>
                    <?php } ?>

                    <div class="additional-statistics">
                        <?php if (!empty($trial_data_code)) { ?>
                            <p class="trial-data-code"><?php echo esc_html($trial_data_code); ?></p>
                        <?php } ?>
                        <?php if (!empty($trial_data_topic)) { ?>
                            <p class="trial-data-topic"><?php echo esc_html($trial_data_topic); ?></p>
                        <?php } ?>
                    </div>

                    <?php if (!empty($additional_statistics)) { 
                        foreach ($additional_statistics as $statistics) { 
                            $number = ACF::getField('additional-trial-data-number', $statistics);
                            $description = ACF::getField('additional-trial-data-description', $statistics); ?> 

                            <div class="additional-statistics">
                                <p class="trial-data-code"><?php echo esc_html($number); ?></p>
                                <p class="trial-data-topic"><?php echo esc_html($description); ?></p>
                            </div>
                        <?php } ?> 
                    <?php } ?>

                    <?php if (!empty($trial_data_pdf)) {
                        $pdf_url = Media::getPdfSrcByID($trial_data_pdf); ?>

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

    <div class="trures-trial-data__body">
        <div class="uk-grid uk-container-large" uk-grid>
            <div class="uk-width-1-5@m uk-width-1-1@s trures-trial-data__share-container share-desktop">
                <p><?php _e('SHARE:', 'kmag'); ?></p>

                <?php echo sharethis_inline_buttons(); ?>
            </div>

            <div class="uk-width-4-5@m uk-width-1-1@s entry-container">
                <?php if (!empty($objective)) { ?>
                    <div class="entry-objective">
                        <h2 class="hdg hdg--3"><?php _e('Objective', 'kmag'); ?></h2>

                        <?php echo apply_filters('the_content', $objective); ?>
                    </div>
                <?php } ?>

                <?php if (!empty($overview_list)) { ?>
                    <h2 class="bullet-list-title hdg hdg--3"><?php _e('Overview', 'kmag'); ?></h2>
                    <ul class="bullet-list">
                        <?php foreach ($overview_list as $item) { ?>
                            <li><?php echo esc_html($item['overview-item']); ?></li>
                        <?php } ?>
                        </ul>
                <?php } ?>

                <div class="entry-content">
                    <h2 class="content-title hdg hdg--3"><?php _e('Trial Details', 'kmag'); ?></h2>
                    <?php echo apply_filters('the_content', $trial_details); ?>
                </div>

                <?php if (!empty($summary_list)) { ?>
                    <h2 class="summary-list-title hdg hdg--3"><?php _e('Summary', 'kmag'); ?></h2>
                    <ul class="summary-list">
                        <?php foreach ($summary_list as $item) { ?>
                            <li><?php echo esc_html($item['summary-item']); ?></li>
                        <?php } ?>
                        </ul>
                <?php } ?>
            </div>
        </div>
    </div>

    <?php if ($trial_data === 'active') { ?>
        <div class="trures-trial-data__trial-data">
            <div class="uk-grid uk-grid-collapse uk-child-width-1-2@m uk-child-width-1-1@s" uk-grid>
                <div class="trial-data-content">
                    <?php if (!empty($headline)) {
                        printf(
                            '<h2 class="hdg hdg--2">%s</h2>',
                            $headline
                        );
                    }

                    if (!empty($content)) {
                        echo apply_filters('the_content', $content);
                    }

                    if (!empty($cta_link)) {
                        echo Util::getButtonHTML($cta_link, ['class' => 'btn btn--secondary btn--sm']);
                    } ?>
                </div>

                <div class="trial-data-image">
                    <?php printf(
                        '<div
                            class="trial-data-image--desktop uk-visible@s"
                            style="background-image: url(%1$s)"
                            data-default-image="%1$s"
                        >
                        </div>',
                        esc_url($background_image_desktop_url)
                    );

                    printf(
                        '<div
                            class="trial-data-image--mobile uk-hidden@s"
                            style="background-image: url(%1$s)"
                            data-default-image="%1$s"
                        >
                        </div>',
                        esc_url($background_image_mobile_url)
                    ); ?>
                </div>
            </div>
        </div>
    <?php } ?>

    <div class="trures-trial-data__related-content">
        <?php
        get_template_part( 'partials/related-content', null,
            array(
                    'data' => array(
                    'post_id' => $post_id,
                    'post_type' => get_post_type($post_id),
                )
            )
        );
        ?>
    </div>

    <div class="trures-trial-data__share-container share-mobile">
        <p><?php _e('SHARE:', 'kmag'); ?></p>

        <?php echo sharethis_inline_buttons(); ?>
    </div>
</article><!-- #post-## -->
