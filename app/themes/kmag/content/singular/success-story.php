<?php
/**
 * Success Story template file.
 */

use CN\App\Fields\ACF;
use CN\App\Fields\Util;

$post_id = get_the_ID();
$data = ACF::getPostMeta($post_id);
$article_title = ACF::getField('article_title', $data);
$article_body = ACF::getField('article_body', $data);
$article_tags = get_the_terms($post_id, 'article-tag');
?>

<article id="post-<?php the_ID(); ?>" class="success-story" data-post-type="success-story">
    <?php get_template_part('partials/back-to-resources-button'); ?>

    <div class="success-story__header">
        <div class="uk-container uk-container-large">
            <div class="title">
                <h1 class="hdg hdg--1"><?php _e('Case Study', 'kmag'); ?></h1>
            </div>
            <div class="uk-grid uk-container-large" uk-grid>
                <div class="uk-width-1-5@m uk-width-1-1@s"></div>
                <div class="uk-width-4-5@m uk-width-1-1@s entry-container">
                    <h2 class="hdg hdg--2"><?php echo esc_html($article_title); ?></h2>
                    <?php
                    //                    echo Util::getButtonHTML(['title' => 'Save for later', 'url' => '/resource-library', 'target' => ''], ['class' => 'btn btn--small btn-save-later cn-save-for-later',
                    //                        'icon-start' => 'arrow-left']);
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="success-story__body">
        <div class="uk-grid uk-container-large" uk-grid>
            <div class="uk-width-1-5@m uk-width-1-1@s success-story__share-container share-desktop">
                <p><?php _e('SHARE:', 'kmag'); ?></p>
                <?php echo sharethis_inline_buttons(); ?>
            </div>

            <div class="uk-width-4-5@m uk-width-1-1@s entry-container">
                <div class="entry-content">
                    <?php echo apply_filters('the_content', $article_body); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="success-story__related-content">
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
    <div class="success-story__share-container share-mobile">
        <p><?php _e('SHARE:', 'kmag'); ?></p>
        <?php echo sharethis_inline_buttons(); ?>
    </div>
</article><!-- #post-## -->
