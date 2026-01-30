<?php
/**
 * Robust Article template file.
 */

use CN\App\Media;
use CN\App\Fields\ACF;
use CN\App\Fields\Util;

$post_id = get_the_ID();
$post_type = 'robust-articles';
$data = ACF::getPostMeta($post_id);

// ACF Fields -> Hero Images
$hero_image = ACF::getField('hero_image', $data);
$has_hero_image = ! empty($hero_image);
$image_attachment = $has_hero_image ? Media::getAttachmentByID($hero_image) : false;
$src = $image_attachment ? ACF::getField('full', $image_attachment->sizes, $image_attachment->url) : null;
$alt = '';
if ($has_hero_image) {
	$alt = !empty($image_attachment->alt) ? esc_attr($image_attachment->alt) : esc_attr($image_attachment->title);
	$desktop_styles = 'background-image: url(' . esc_html($src). ');';
}

$hero_image_mobile = ACF::getField('hero_image_mobile', $data);
$has_hero_mobile_image = ! empty($hero_image_mobile);
$mobile_image_attachment = $has_hero_mobile_image ? Media::getAttachmentByID($hero_image_mobile) : false;
$src_mobile = $mobile_image_attachment ? ACF::getField('full', $mobile_image_attachment->sizes, $mobile_image_attachment->url) : null;
$mobile_alt = '';
if ($has_hero_mobile_image) {
	$mobile_alt = !empty($mobile_image_attachment->alt) ? esc_attr($mobile_image_attachment->alt) : esc_attr($mobile_image_attachment->title);
	$mobile_styles = 'background-image: url(' . esc_html($src_mobile). ');';
}

$article_intro = ACF::getField('article_intro', $data);
$article_body = ACF::getField('article_body', $data);
if (empty($article_body)) {
	return;
}

// ACF Fields -> Author Fields
$author_photo = ACF::getField('author_author-thumbnail', $data);
$has_author_photo = ! empty($author_photo);
$author_image_attachment = $has_author_photo ? Media::getAttachmentByID($author_photo) : false;

$author_name = ACF::getField('author_author-name', $data);
$escaped_author_name = ! empty($author_name) ? sprintf('<strong class="bio__author-name modal-name">%1$s</strong>', esc_html($author_name)) : '';
$author_title = ACF::getField('author_author-title', $data);
$escaped_author_title = ! empty($author_title) ? sprintf('<span class="bio__author-title modal-title">%1$s</span>', esc_html($author_title)) : '';
$author_bio = ACF::getField('author_author-bio', $data);
$has_bio = ! empty($author_bio);
$escaped_bio = $has_bio ? esc_html($author_bio) : '';

$author_image_html = '';
if ($has_author_photo) {
    $author_image_args = array('class' => 'robust-article-details__author-image');
	$author_image_html = Util::getImageHtml($author_image_attachment, 'medium', $author_image_args);
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


function getRobustArticleIntro($intro) {
	if ( !empty($intro) ) {
		return sprintf('<p class="robust-article-heading__intro">%s</p>', $intro);
	}
	return '';
}

?>
<article id="post-<?php the_ID(); ?>" class="robust-article" data-post-type="robust-article">
	<?php get_template_part('partials/back-to-resources-button'); ?>
	<?php if($has_hero_image) { ?>
		<div class="robust-article__hero" role="img" aria-lablel="<?php echo esc_attr($alt) ?>" style="<?php echo $desktop_styles ?>"></div>
	<?php } ?>
	<?php if($has_hero_mobile_image) { ?>
		<div class="robust-article__mobile-hero" role="img" aria-lablel="<?php echo esc_attr($mobile_alt) ?>">
			<img src="<?php echo esc_url($src_mobile); ?>" alt="<?php echo esc_attr($mobile_alt); ?>" class="robust-article__mobile-hero-image">
		</div>
	<?php } elseif ($has_hero_image) { ?>
		<div class="robust-article__mobile-hero" role="img" aria-lablel="<?php echo esc_attr($alt) ?>">
			<img src="<?php echo esc_url($src); ?>" alt="<?php echo esc_attr($alt); ?>" class="robust-article__mobile-hero-image">
		</div>
	<?php } ?>
	<div class="robust-article__heading-container uk-container uk-container-large uk-grid">
		<div class="uk-width-1-5@m uk-width-1-1@s"></div>
		<div class="uk-width-4-5@m uk-width-1-1@s robust-article-heading remove-padding-mobile">
			<?php the_title('<h1 class="robust-article-heading__title">', '</h1>'); ?>
			<?php echo getRobustArticleIntro($article_intro); ?>
		</div>
	</div>

	<div class="robust-article__body-container uk-container uk-container-large uk-grid">
		<aside class="robust-article-details uk-width-1-5@m uk-width-1-1@s remove-padding-mobile">
			<?php 
				echo $author_image_html;
				if (! empty($author_name)) {
					echo sprintf('<span class="robust-article-details__author-name">%1$s</span>', esc_html($author_name));
				}
				if (! empty($author_title)) {
					echo sprintf('<span class="robust-article-details__author-title">%1$s</span>', esc_html($author_title));
				}
			?>
			<?php if ($has_bio) { ?>
				<div class="bio robust-article-details__view-bio">
					<button class="bio__expand-button" uk-toggle="target: #modal-<?php echo esc_attr($post_id); ?>">
						<svg class="icon icon-expand" aria-hidden="true">
							<use xlink:href="#icon-expand"></use>
						</svg>
						<span>
						<?php _e('View Bio', 'kmag'); ?>
						</span>
					</button>
					<!-- Modal -->
					<div id="modal-<?php echo esc_attr($post_id); ?>" class="bio__modal uk-flex-top" uk-modal>
						<div class="uk-modal-dialog uk-modal-body">
							<!-- Modal Close Button -->
							<button class="uk-modal-close" type="button">
								<svg class="icon icon-close-modal" aria-hidden="true">
										<use xlink:href="#icon-close-modal"></use>
								</svg>
							</button>

							<!-- Modal Top Container -->
							<div class="uk-grid uk-grid-small bio__modal-top-container modal-top-container">
								<?php if ($has_author_photo) { ?>
									<div class="uk-width-1-3@m uk-width-1-1@s bio__modal-image modal-image">
										<?php echo $author_image_html; ?>
									</div>
								<?php } ?>
								<div class="uk-width-2-3@m uk-width-1-1@s">
									<div class="bio__name-title-container">
										<?php
											echo $escaped_author_name;
											echo $escaped_author_title;
										?>
									</div>
								</div>
							</div>

							<div class="bio__modal-bottom-container modal-bottom-container">
								<p>
									<?php echo $escaped_bio; ?>
								</p>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
			<div class="robust-article-details__share">
				<p><?php _e('SHARE:', 'kmag'); ?></p>
				<?php echo sharethis_inline_buttons(); ?>
			</div>   
		</aside>
		<div class="uk-width-4-5@m uk-width-1-1@s remove-padding-mobile">
			<div class="robust-article-entry-container">
				<?php echo apply_filters('the_content', $article_body); ?>
			</div>
		</div>
	</div>
	<div class="robust-article__related-content">
		<?php 
		get_template_part( 'partials/related-content', null,
			array(
					'data' => array(
					'post_id' => $post_id,
					'post_type' => $post_type
				)
			)
		);
		?>
	</div>
</article>