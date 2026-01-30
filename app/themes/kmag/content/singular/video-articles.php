<?php
/**
 * Video Article template file.
 */

use CN\App\Fields\ACF;
use CN\App\Fields\Util;

$post_id = get_the_ID();
$data = ACF::getPostMeta($post_id);
$article_head = ACF::getField('article_header', $data);
$article_video_link = ACF::getField('article_video_link', $data);
$video_body = ACF::getField('article_body', $data);
$video_platform = ACF::getField('video-platform', $data);
$video_id = ACF::getField('video_id', $data, null);
$video_url = '';
if ($video_id !== null) {
    $video_url = $video_platform === 'youtube' ? 'https://www.youtube.com/embed/' . esc_html($video_id) : 'https://player.vimeo.com/video/' . esc_html($video_id) . '?title=0&byline=0&portrait=0';
}

?>

<article id="post-<?php the_ID(); ?>" class="video-articles" data-post-type="video-articles">

    <?php get_template_part('partials/back-to-resources-button'); ?>

    <div class="video-articles__header">
        <div class="uk-container-large">
            <div class="uk-grid uk-container-large" uk-grid>
                <div class="uk-width-1-5@m uk-width-1-1@s"></div>
                <div class="uk-width-4-5@m uk-width-1-1@s entry-container">
                    <h1 class="hdg hdg--1"><?php echo apply_filters('the_title', $article_head); ?></h1>
                    <?php
                    //                    echo Util::getButtonHTML(['title' => 'Save for later', 'url' => '', 'target' => ''], ['class' => 'btn btn--small',
                    //                        'icon-start' => 'arrow-left']);
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="video-articles__body">
        <div class="uk-grid uk-container-large" uk-grid>
            <div class="uk-width-1-5@m uk-width-1-1@s video-articles__share-container share-desktop">
                <p><?php _e('SHARE:', 'kmag'); ?></p>
                <?php echo sharethis_inline_buttons(); ?>
            </div>
            <div class="uk-width-4-5@m uk-width-1-1@s entry-container">
                <div class="video-holder">
                    <iframe src="<?php echo $video_url; ?>"
                            frameborder="0" allow="autoplay; fullscreen; picture-in-picture"
                            allowfullscreen></iframe>
                </div>
                <div class="entry-content">
                    <?php echo apply_filters('the_content', $video_body); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="video-articles__related-content">
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
    <div class="video-articles__share-container share-mobile">
        <p><?php _e('SHARE:', 'kmag'); ?></p>
        <?php echo sharethis_inline_buttons(); ?>
    </div>
</article><!-- #post-## -->
