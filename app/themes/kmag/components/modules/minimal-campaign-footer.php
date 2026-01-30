<?php
/**
 * ACF Module: Minimal Campaign Footer
 *
 * @global $data
 */

use CN\App\Fields\ACF;
use CN\App\Fields\Options;
use CN\App\Fields\Util;
use CN\App\Media;

$options = Options::getSiteOptions();
$copyright = ACF::getField('copyright', $options);
$legal_menu = ACF::getRowsLayout('legal-menu', $options);
$logo = ACF::getField('logo', $data);

?>

<footer class="minimal-campaign-footer" role="contentinfo">
    <div class="minimal-campaign-footer__wrapper">
            <a class="minimal-campaign-footer__logo" href="<?php echo home_url(); ?>"><?php echo Util::getImageHTML(Media::getAttachmentByID($logo)); ?></a>
            <div class="minimal-campaign-footer__menu-links">
                <?php if (!empty($legal_menu)) {
                    foreach ($legal_menu as $menu_link) {
                        echo Util::getButtonHTML($menu_link['link'], ['class' => 'minimal-campaign-footer__menu-link']);
                    }
                } ?>
                <p class="minimal-campaign-footer__copyright"><?php echo esc_html($copyright); ?></p>
            </div>
        </div>
    </div>
</footer>
