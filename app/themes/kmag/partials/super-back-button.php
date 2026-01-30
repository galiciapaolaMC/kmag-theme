<?php
/**
 * Super back button partial template
 */

use CN\App\Fields\Util;
use CN\App\Fields\ACF;
use CN\App\Fields\Options;

$options = Options::getSiteOptions();
$referrerSlugs = ACF::getRowsLayout('referrer_slug', $options);
$globalFilterReferrerSlugs = ACF::getRowsLayout('global_filter_referrer_slug', $options);
$unrestrictedSlugs = [];
foreach ($referrerSlugs as $index => $item) {
    $slug = ACF::getField('slug', $item);
    $unrestrictedSlugs[] = $slug;
}
$restrictedSlugs = [];
foreach ($globalFilterReferrerSlugs as $index => $item) {
    $slug = ACF::getField('slug', $item);
    $restrictedSlugs[] = $slug;
}
$slugs = [
    'restrictedSlugs' => $restrictedSlugs,
    'unrestrictedSlugs' => $unrestrictedSlugs
];
wp_localize_script(
    'cn-theme',
    'super_back_referrer_slugs',
    $slugs
);

?>
<div id="super-back-button-container" class="super-back-button-container">
    <div class="super-back-button">
        <button class="super-back-button__button btn btn--tertiary">
            <?php
                echo Util::getIconHTML('arrow-left', 0);
            ?>
            <span>
            <?php
                _e('Go Back', 'kmag');
            ?>
            </span>
        </button>
        <span class="super-back-button__description">
            <?php _e('Go back to where you left off', 'kmag'); ?>
        </span>
    </div>
</div>