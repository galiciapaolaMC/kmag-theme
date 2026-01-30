<?php
/**
 * ACF Module: Nutrient Knowledge
 *
 * @global $data
 *
 *
 */

use CN\App\Fields\ACF;
use CN\App\Media;
use CN\App\Fields\Util;

$nutrients = ACF::getField('nutrient', $data);
$fields = ACF::getPostMeta($nutrients[0]);
$benefit_image_id = ACF::getField('benefit_image', $fields);
$benefits = ACF::getRowsLayout('benefit-knowledge', $fields);

$left = 1;
$right = 2;

if (count($benefits) == 4) {
    $right = 3;
}

if (count($benefits) == 5) {
    $left = 2;
    $right = 4;
}

if (count($benefits) == 6) {
    $left = 2;
    $right = 5;
}

if (count($benefits) == 7) {
    $left = 3;
    $right = 6;
}

if (!$benefits) {
    return;
}

do_action('cn/modules/styles', $row_id, $data);
?>

<section class="module nutrient-knowledge" id="<?php echo esc_attr($row_id); ?>">
    <div class="uk-grid uk-grid-small uk-child-width-1-3@m uk-child-width-1-1@s" uk-grid>
        <div class="left-column">
            <?php for ($i = 0; $i <= $left; $i++) { ?>
                <div class="nutrient-knowledge__benefit benefit-<?php echo esc_attr($i); ?>" data-id="<?php echo esc_attr($i); ?>">
                    <h3 class="headline"><?php echo esc_html($benefits[$i]['headline']); ?></h3>
                    <p class="content"><?php echo esc_html($benefits[$i]['content']); ?></p>
                </div>
            <?php } ?>
        </div>

        <div class="center-column">
            <?php echo Util::getImageHTML(Media::getAttachmentByID($benefit_image_id), 'full'); ?>

            <div class="nutrient-nodes nodes-<?php echo esc_attr(count($benefits)); ?>">
                <?php for ($i = 0; $i < count($benefits); $i++) { ?>
                    <button type="button" class="nutrient-benefit-node node-<?php echo esc_attr($i); ?>"  data-id="<?php echo esc_attr($i); ?>"></button>
                <?php } ?>
            </div>
        </div>

        <div class="right-column">
            <?php for ($i = ($left + 1); $i <= $right; $i++) { ?>
                <div class="nutrient-knowledge__benefit benefit-<?php echo esc_attr($i); ?>"  data-id="<?php echo esc_attr($i); ?>">
                    <h3 class="headline"><?php echo esc_html($benefits[$i]['headline']); ?></h3>
                    <p class="content"><?php echo esc_html($benefits[$i]['content']); ?></p>
                </div>
            <?php } ?>
        </div>
    </div>

    <div class="uk-slider-container" uk-slider>
        <div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1">
            <ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin"></ul>

            <ul class="uk-slider-items uk-child-width-1-1@s uk-grid">
                <?php foreach ($benefits as $index => $benefit) { ?>
                    <li data-id="<?php echo esc_attr($index); ?>">
                        <div class="uk-card uk-card-default">
                            <div class="nutrient-knowledge__benefit">
                                <h3 class="headline"><?php echo esc_html($benefit['headline']); ?></h3>
                                <p class="content"><?php echo esc_html($benefit['content']); ?></p>
                            </div>
                        </div>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</section>

