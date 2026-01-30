<?php
/**
 * ACF Module: AdvancedCNPlant
 *
 * @global $data
 */

use CN\App\Fields\ACF;
use CN\App\Media;
use CN\App\Fields\Util;

$main_headline = ACF::getField('main-headline', $data);
$main_content = ACF::getField('main-content', $data);
$main_image_id = ACF::getField('main-image', $data);
$cn_content = ACF::getField('kmag-content', $data);
$cn_link = ACF::getField('kmag-link', $data);
$cn_image_id = ACF::getField('kmag-image', $data);
$bio_content = ACF::getField('biosciences-content', $data);
$bio_link = ACF::getField('biosciences-link', $data);
$bio_image_id = ACF::getField('biosciences-image', $data);

if (! $main_content) {
    return;
}

do_action('cn/modules/styles', $row_id, $data);
?>

<div class="module advanced-cn-plant" id="<?php echo esc_attr($row_id); ?>">
    <div class="uk-container uk-container-large">
        <div class="uk-grid uk-grid-large uk-child-width-1-2@m uk-child-width-1-1@s" uk-grid>
            <div class="advanced-cn-plant__image-container">
                <div class="main-image">
                    <?php echo Util::getImageHTML(Media::getAttachmentByID($main_image_id), 'full'); ?>
                </div>

                <div class="cn-image">
                    <?php echo Util::getImageHTML(Media::getAttachmentByID($cn_image_id), 'full'); ?>
                </div>

                <div class="bio-image">
                    <?php echo Util::getImageHTML(Media::getAttachmentByID($bio_image_id), 'full'); ?>
                </div>
            </div>

            <div class="advanced-cn-plant__content-container">
                <div class="main-content-container">
                    <h2 class="hdg hdg--2"><?php echo esc_html($main_headline); ?></h2>
                    <p class="content"><?php echo esc_html($main_content); ?></p>

                    <div class="mobile-main-image">
                        <?php echo Util::getImageHTML(Media::getAttachmentByID($main_image_id), 'full'); ?>
                    </div>
                </div>

                <div class="active-content">
                    <div class="cn-container">
                        <svg class="icon icon-mosaic-cn" aria-label="hidden">
                            <use xlink:href="#icon-mosaic-cn"></use>
                        </svg>
                        
                        <p class="content"><?php echo esc_html($cn_content); ?></p>

                        <?php echo Util::getButtonHTML($cn_link, ['class' => 'btn btn--small btn--secondary btn-cn-image']); ?>
                    </div>

                    <div class="bio-container">
                        <svg class="icon icon-mosaic-bioscience" aria-label="hidden">
                            <use xlink:href="#icon-mosaic-bioscience"></use>
                        </svg>

                        <p class="content"><?php echo esc_html($bio_content); ?></p>

                        <?php echo Util::getButtonHTML($bio_link, ['class' => 'btn btn--small btn--biosciences btn-bio-image']); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
