<?php
/**
 * Standard Article template file.
 */


use CN\App\Fields\ACF;
use CN\App\Fields\Util;

$post_id = get_the_ID();
$data = ACF::getPostMeta($post_id);
$article_title = ACF::getField('article_title', $data);
$article_body = ACF::getField('article_body', $data);
$author_name = ACF::getField('author_name', $data);
$author_title = ACF::getField('author_title', $data);
?>

<article id="post-<?php the_ID(); ?>" class="standard-article" data-post-type="standard-article">

    <?php get_template_part('partials/back-to-resources-button'); ?>

    <div class="standard-article__header">
        <div class="uk-container uk-container-large">
            <div class="uk-grid uk-container-large" uk-grid>
                <div class="uk-width-1-5@m uk-width-1-1@s"></div>
                <div class="uk-width-4-5@m uk-width-1-1@s entry-container">
                    <h1 class="hdg hdg--1"><?php echo apply_filters('the_title', $article_title); ?></h1>
                </div>
            </div>
        </div>
    </div>

    <div class="standard-article__body">
        <div class="uk-grid uk-container-large" uk-grid>
            <div class="uk-width-1-5@m uk-width-1-1@s standard-article__share-container share-desktop">
                <p><?php _e('SHARE:', 'kmag'); ?></p>
                <?php echo sharethis_inline_buttons(); ?>
            </div>
            <div class="uk-width-4-5@m uk-width-1-1@s entry__content">
                <?php echo apply_filters('the_content', $article_body); ?>
                <?php if (have_rows('inline_images')) { ?>
                    <div class="img_captions_holder">
                        <?php while (have_rows('inline_images')): the_row();
                            $image = get_sub_field('image');
                            $caption = get_sub_field('caption');
                            ?>
                            <img alt="<?php echo $article_title; ?>" src="<?php echo $image['url']; ?>"/>
                            <div class="caption_holder">
                                <?php echo '<h2>' . $caption . '</h2>'; ?>
                                <div class="author_holder">
                                    <?php if (!empty($author_name)) { ?>
                                        <b class="author_name"><?php echo $author_name; ?></b>
                                    <?php } ?>
                                    <?php if (!empty($author_title)) { ?>
                                        <b class="author_title">,<?php echo ' ' . $author_title; ?></b>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <div class="standard-article__related-content">
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
    <div class="standard-article__share-container share-mobile">
        <p><?php _e('SHARE:', 'kmag'); ?></p>
        <?php echo sharethis_inline_buttons(); ?>
    </div>
</article><!-- #post-## -->
