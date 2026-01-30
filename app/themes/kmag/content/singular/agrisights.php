<?php
/**
 * Agrisight template file.
 */

use CN\App\Media;
use CN\App\Fields\ACF;
use CN\App\Fields\Util;

$post_id = get_the_ID();
$data = ACF::getPostMeta($post_id);
$issue_number = ACF::getField('issue-number', $data);
$agrisights_pdf = ACF::getField('agrisights-pdf', $data);
$fact_list = ACF::getRowsLayout('fact-list', $data);
$article_introduction = ACF::getField('article-introduction', $data);
$article_body = ACF::getField('article-body', $data);

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

<article id="post-<?php the_ID(); ?>" class="agrisight" data-post-type="agrisight">
    <?php get_template_part('partials/back-to-resources-button'); ?>
    <div class="agrisight__header">
        <div class="logo-container">
            <div class="uk-container">
                <svg class="icon icon-agrisight" aria-hidden="true">
                    <use xlink:href="#icon-agrisight"></use>
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

                    <?php if (!empty($agrisights_pdf)) {
                        $pdf_url = Media::getPdfSrcByID($agrisights_pdf); ?>

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

    <div class="agrisight__body">
        <div class="uk-grid uk-container-large" uk-grid>
            <div class="uk-width-1-5@m uk-width-1-1@s agrisight__share-container share-desktop">
                <p><?php _e('SHARE:', 'kmag'); ?></p>

                <?php echo sharethis_inline_buttons(); ?>
            </div>

            <div class="uk-width-4-5@m uk-width-1-1@s entry-container">
                <?php if (!empty($fact_list)) { ?>
                    <ul class="fact-list uk-grid uk-grid-small uk-child-width-1-3@m uk-child-width-1-1@s">
                        <?php foreach ($fact_list as $fact) { ?>
                            <li><?php echo esc_html($fact['fact']); ?></li>
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

    <div class="agrisight__related-content">
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

    <div class="agrisight__share-container share-mobile">
        <p><?php _e('SHARE:', 'kmag'); ?></p>

        <?php echo sharethis_inline_buttons(); ?>
    </div>
</article><!-- #post-## -->
