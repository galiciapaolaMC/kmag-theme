<?php
/**
 * TruResponse Insights template file.
 */

use CN\App\Media;
use CN\App\Fields\ACF;
use CN\App\Fields\Util;
use CN\App\Fields\Options;

$post_id = get_the_ID();
$data = ACF::getPostMeta($post_id);
$issue_number = ACF::getField('issue-number', $data);
$insights_pdf = ACF::getField('insights-pdf', $data);
$bullet_list = ACF::getRowsLayout('bullet-list', $data);
$article_introduction = ACF::getField('article-intro', $data);
$article_body = ACF::getField('article-body', $data);
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

if (empty($article_body)) {
    return;
}
?>

<article id="post-<?php the_ID(); ?>" class="trures-insights" data-post-type="true-response-insights">
    <?php get_template_part('partials/back-to-resources-button'); ?>
    <div class="trures-insights__header">
        <div class="logo-container">
            <div class="uk-container">
                <svg class="icon icon-trures-insights" aria-hidden="true">
                    <use xlink:href="#icon-trures-insights"></use>
                </svg>
            </div>
        </div>

        <div class="uk-container uk-container-large">
            <div class="uk-grid uk-container-large" uk-grid>
                <div class="uk-width-1-5@m uk-width-1-1@s"></div>

                <div class="uk-width-4-5@m uk-width-1-1@s entry-container">
                    <?php the_title('<h1 class="hdg hdg--1">', '</h1>'); ?>

                    <?php if (!empty($issue_number)) { ?>
                        <p class="issue-number"><?php _e('Issue ', 'kmag'); ?> <?php echo esc_html($issue_number); ?></p>
                    <?php } ?>

                    <?php if (!empty($insights_pdf)) {
                        $pdf_url = Media::getPdfSrcByID($insights_pdf); ?>

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

    <div class="trures-insights__body">
        <div class="uk-grid uk-container-large" uk-grid>
            <div class="uk-width-1-5@m uk-width-1-1@s trures-insights__share-container share-desktop">
                <p><?php _e('SHARE:', 'kmag'); ?></p>

                <?php echo sharethis_inline_buttons(); ?>
            </div>

            <div class="uk-width-4-5@m uk-width-1-1@s entry-container">
                <?php if (!empty($bullet_list)) { ?>
                    <ul class="bullet-list uk-grid uk-grid-small uk-child-width-1-3@m uk-child-width-1-1@s">
                        <?php foreach ($bullet_list as $item) { ?>
                            <li><?php echo esc_html($item['fact']); ?></li>
                        <?php } ?>
                        </ul>
                <?php } ?>

                <?php if (!empty($article_introduction)) { ?>
                    <div class="entry-introduction">
                        <h2 class="hdg hdg--3"><?php _e('Introduction', 'kmag'); ?></h2>

                        <?php echo apply_filters('the_content', $article_introduction); ?>
                    </div>
                <?php } ?>

                <div class="entry-content">
                    <?php echo apply_filters('the_content', $article_body); ?>
                </div>
            </div>
        </div>
    </div>

    <?php if ($trial_data === 'active') { ?>
        <div class="trures-insights__trial-data">
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

    <div class="trures-insights__related-content">
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

    <div class="trures-insights__share-container share-mobile">
        <p><?php _e('SHARE:', 'kmag'); ?></p>

        <?php echo sharethis_inline_buttons(); ?>
    </div>
</article><!-- #post-## -->
