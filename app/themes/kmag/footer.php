<?php

/**
 * The template for displaying the footer.
 *
 * @package CN
 */

use CN\App\Media;
use CN\App\Fields\ACF;
use CN\App\Fields\Options;
use CN\App\Fields\Util;

$options = Options::getSiteOptions();
$logo = ACF::getField('footer-logo', $options);
$footer_menu = ACF::getRowsLayout('footer-menu', $options);
$newsletter = ACF::getField('newsletter-footer', $options);
$legal_menu = ACF::getRowsLayout('legal-menu', $options);
$copyright = ACF::getField('copyright', $options);
$facebook_link = ACF::getField('facebook-link', $options);
$twitter_link = ACF::getField('twitter-link', $options);
$youtube_link = ACF::getField('youtube-link', $options);
$instagram_link = ACF::getField('instagram-link', $options);
$footer_scripts = ACF::getField('footer_scripts', $options);
?>

<footer class="footer" role="contentinfo">
    <div class="uk-container uk-container-large">
        <div class="uk-grid uk-grid-medium" uk-grid>
            <div class="uk-width-1-3@m uk-width-1-1@s">
                <div class="uk-width-auto">
                    <a class="footer__logo" href="<?php echo home_url(); ?>"><?php echo Util::getImageHTML(Media::getAttachmentByID($logo)); ?></a>
                </div>
            </div>

            <div class="uk-width-expand@m uk-width-1-1@s">
                <div class="uk-grid uk-grid-medium footer__second-column" uk-grid>
                    <div class="footer__menu-links uk-width-expand@m uk-width-1-2@s">
                        <?php if (!empty($footer_menu)) {
                            foreach ($footer_menu as $menu_link) {
                                echo Util::getButtonHTML($menu_link['link'], ['class' => 'footer-link']);
                            }
                        } ?>
                    </div>

                    <div class="footer__newsletter uk-width-auto@m uk-width-1-1@s">
                        <?php if (!empty($newsletter)) {
                            echo Util::getButtonHTML($newsletter, [
                                'class' => 'link footer__external-link',
                                'icon-end' => 'new-tab'
                            ]);
                        } ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer__bottom-content" uk-grid>
            <div class="footer__legal-menu uk-width-3-4@m uk-child-1-1@s">
                <div class="uk-grid uk-grid-medium uk-child-width-1-2@m uk-child-width-1-1@s" uk-grid>
                    <div class="legal-links">
                        <?php if (!empty($legal_menu)) {
                            foreach ($legal_menu as $menu_link) {
                                echo Util::getButtonHTML($menu_link['link'], ['class' => 'footer__menu-link']);
                            }
                        } ?>
                    </div>

                    <p class="footer__copyright"><?php echo esc_html($copyright); ?></p>
                </div>
            </div>

            <div class="footer__social-icons uk-width-1-4@m uk-child-1-1@s">
                <?php if (!empty($facebook_link)) { ?>
                    <a href="<?php echo esc_url($facebook_link['url']); ?>" aria-label="<?php echo esc_html($facebook_link['title']); ?>" target="<?php echo esc_html($facebook_link['target']); ?>">
                        <svg class="icon icon-facebook" aria-hidden="true">
                            <use xlink:href="#icon-facebook"></use>
                        </svg>
                    </a>
                <?php } ?>

                <?php if (!empty($twitter_link)) { ?>
                    <a href="<?php echo esc_url($twitter_link['url']); ?>" aria-label="<?php echo esc_html($twitter_link['title']); ?>" target="<?php echo esc_html($twitter_link['target']); ?>">
                        <svg class="icon icon-twitter-x" aria-hidden="true">
                            <use xlink:href="#icon-twitter-x"></use>
                        </svg>
                    </a>
                <?php } ?>

                <?php if (!empty($instagram_link)) { ?>
                    <a href="<?php echo esc_url($instagram_link['url']); ?>" aria-label="<?php echo esc_html($instagram_link['title']); ?>" target="<?php echo esc_html($instagram_link['target']); ?>">
                        <svg class="icon icon-instagram" aria-hidden="true">
                            <use xlink:href="#icon-instagram"></use>
                        </svg>
                    </a>
                <?php } ?>

                <?php if (!empty($youtube_link)) { ?>
                    <a href="<?php echo esc_url($youtube_link['url']); ?>" aria-label="<?php echo esc_html($youtube_link['title']); ?>" target="<?php echo esc_html($youtube_link['target']); ?>">
                        <svg class="icon icon-youtube" aria-hidden="true">
                            <use xlink:href="#icon-youtube"></use>
                        </svg>
                    </a>
                <?php } ?>
            </div>
        </div>
    </div>
</footer>

<?php
wp_footer();

echo $footer_scripts;
?>

</body>

</html>