<?php
/**
 * ACF Module: Bios
 *
 * @global $data
 */

use CN\App\Fields\ACF;
use CN\App\Media;
use CN\App\Fields\Util;

$items = ACF::getRowsLayout('bio-items', $data);

if (! $items) {
    return;
}

do_action('cn/modules/styles', $row_id, $data);
?>

<div class="module bios" id="<?php echo esc_attr($row_id); ?>">
    <div class="uk-container uk-container-large">
        <div class="uk-grid uk-grid-large uk-child-width-1-3@m uk-child-width-1-2@s" uk-grid>
            <?php
            foreach ($items as $index => $item) { 
                $image_id = ACF::getField('image', $item);
                $name = ACF::getField('name', $item);
                $title = ACF::getField('title', $item);
                $bio_text = ACF::getField('bio-text', $item); ?>

                <div class="bios__content" uk-toggle="target: #modal-<?php echo esc_attr($index); ?>">
                    <div class="bios__image">
                        <?php echo Util::getImageHTML(Media::getAttachmentByID($image_id)); ?>
                    </div>

                    <p class="name"><?php echo esc_html($name); ?></p>
                    <p class="title"><?php echo esc_html($title); ?></p>
                    <button class="view-bio">
                        <svg class="icon icon-expand" aria-hidden="true">
                            <use xlink:href="#icon-expand"></use>
                        </svg>

                        <?php _e('View Bio', 'kmag'); ?>
                    </button>

                    <div id="modal-<?php echo esc_attr($index); ?>" class="bios__content-modal uk-flex-top" uk-modal>
                        <div class="uk-modal-dialog uk-modal-body">
                            <button class="uk-modal-close" type="button">
                                <svg class="icon icon-close-modal" aria-hidden="true">
                                    <use xlink:href="#icon-close-modal"></use>
                                </svg>
                            </button>

                            <div class="uk-grid uk-grid-small modal-top-container" uk-grid>
                                <div class="uk-width-1-3@m uk-width-1-1@s modal-image">
                                    <?php echo Util::getImageHTML(Media::getAttachmentByID($image_id)); ?>
                                </div>

                                <div class="uk-width-2-3@m uk-width-1-1@s modal-title">
                                    <div class="name-title-container">
                                        <h2 class="uk-modal-title modal-name"><?php echo esc_html($name); ?></h2>
                                        <p class="modal-position-title"><?php echo esc_html($title); ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-bottom-container">
                                <p><?php echo esc_html($bio_text); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
