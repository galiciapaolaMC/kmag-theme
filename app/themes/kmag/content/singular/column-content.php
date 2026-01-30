<?php
/**
 * Column Content CPT template file.
 */

use CN\App\Media;
use CN\App\Fields\ACF;
use CN\App\Fields\Util;

$post_id = get_the_ID();
$data = ACF::getPostMeta($post_id);
$heading = ACF::getField('heading', $data);
$sub_heading = ACF::getField('sub_heading', $data);
$description = ACF::getField('description', $data);
$image = ACF::getField('image', $data);
$contents = ACF::getRowsLayout('contents', $data);
?>
<article id="post-<?php the_ID(); ?>" class="column-content-asst">
    <div class="column-content-asst__header">
        <div class="uk-container-large">
            <div class="uk-grid uk-container-large" uk-grid>
                <div class="uk-width-4-5@m uk-width-1-1@s entry-container">
                    <h1 class="hdg hdg--1"><?php echo apply_filters('the_title', $heading); ?></h1>
                </div>
            </div>
        </div>
    </div>
    <div class="column-content-asst__body">
        <div class="uk-container-large">
            <div class="uk-grid uk-container-large" uk-grid>
                <?php if (isset($image) && !empty($image)) { ?>
                    <div class="uk-width-1-3@m uk-width-1-1@s share-desktop image-holder">
                        <?php
                        echo wp_get_attachment_image($image, 'full');
                        ?>
                    </div>
                <?php } ?>
                <div class="uk-width-expand@m uk-width-1-1@s entry-container">
                    <div class="section">
                        <h4><?php echo esc_html($sub_heading); ?></h4>
                        <p><?php echo esc_html($description); ?></p>
                    </div>
                    <?php foreach ($contents as $content) { ?>
                        <div class="contents">
                            <?php if (isset($content['content_title']) && !empty($content['content_title'])) { ?>
                                <h4><?php echo esc_html($content['content_title']); ?> : </h4>
                                <?php
                            }
                            $documents = ACF::getRowsLayout('document', $content);
                            foreach ($documents as $document) {
                                if (isset($document['file']) && !empty($document['file'])) {
                                    if (acf_get_attachment($document['file'])) { ?>
                                        <div class="content-list">
                                            <?php $document_url = Media::getPdfSrcByID($document['file']); ?>
                                            <a href="<?php echo esc_url($document_url); ?>" target="_blank"
                                               class="btn btn-primary btn-download-column-content-asst">
                                                <?php _e($document['label'], 'kmag'); ?>
                                                <svg class="icon icon-download" aria-hidden="true">
                                                    <use xlink:href="#icon-download"></use>
                                                </svg>
                                            </a>
                                        </div>
                                    <?php }
                                }
                            } ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</article><!-- #post-## -->
