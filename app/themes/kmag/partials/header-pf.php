<?php

/**
 * The template for displaying the header.
 *
 * @package CN
 */

use CN\App\Media;
use CN\App\Fields\ACF;
use CN\App\Fields\Options;
use CN\App\Fields\Util;
use CN\App\Fields\SiteSearchUtil;


$options = Options::getSiteOptions();
$logo = ACF::getField('site_logo', $options);
$head_scripts = ACF::getField('head_scripts', $options);
$body_scripts = ACF::getField('body_scripts', $options);
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag("consent", "default", {
            "ad_storage": "denied",
            "analytics_storage": "denied",
            "ad_user_data": "denied",
            "ad_personalization": "denied",
            "wait_for_update": 500
        });
        gtag("set", "ads_data_redaction", true);
    </script>
    <script src="https://cmp.osano.com/AzZhEYTqLQ3Bc64Rh/027a037e-8992-45ea-ba28-3ce257409b0d/osano.js"></script>
    <meta theme-version="<?php echo esc_html(THEME_VERSION); ?>">
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="google-site-verification" content="a3JbbhvHV1ZBdYJ-Pv0cgJrPd0GBWMJi0ydwHaU-PcE" />
    <link rel="profile" href="http://gmpg.org/xfn/11">

    <?php
    wp_head();

    do_action('cn/global/crop-region');
    do_action('cn/global/crop-images');

    echo $head_scripts;
    ?>
</head>

<body <?php body_class(); ?>>

    <?php echo $body_scripts; ?>

    <!-- skip to main content -->
    <a href="#primary" class="screen-reader-text"><?php _e('Skip to Main Content', 'kmag'); ?></a>

    <?php do_action('cn/styles/icons'); 
    
    $data = ACF::getPostMeta(get_the_ID());
    $desktop_navigation = ACF::getField('page-navigation_desktop-navigation', $data, 'false');
    $mobile_navigation = ACF::getField('page-navigation_mobile-navigation', $data, 'false');
    $sticky_navigation = ACF::getRowsLayout('page-navigation_navigation', $data, false); 
    $header_class = '';
    $hidden = false;

    if ($desktop_navigation === 'false' && $mobile_navigation === 'true') {
        $header_class = 'uk-hidden@m';
    } 

    if ($desktop_navigation === 'true' && $mobile_navigation === 'false') {
        $header_class = 'uk-visible@m';
    } 

    if ($desktop_navigation === 'false' && $mobile_navigation === 'false') {
        $hidden = true;
    }

    if ($hidden === false) {
        ?>

        <header id="masthead" class="header sticky-navigation <?php echo esc_attr($header_class); ?>" role="banner">
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="uk-container uk-container-large header__main-container">
                    <div class="uk-grid uk-grid-medium header__header-wrapper" uk-grid>
                        <div class="uk-width-1-6@m uk-width-1-1 header__logo-container">
                            <a class="header__logo" href="<?php echo home_url(); ?>"><?php echo Util::getImageHTML(Media::getAttachmentByID($logo)); ?></a>
                        </div>

                        <div class="uk-width-5-6@m uk-width-1-1 uk-align-right">
                            <div class="header__menu">
                                <div class="sticky-nav__menu-wrap">
                                    <button class="sticky-nav__menu-toggle">
                                        <span></span>
                                        <span></span>
                                    </button>

                                    <ul class="sticky-nav uk-grid uk-grid-large uk-flex-right uk-text-right" uk-grid>
                                        <?php foreach ($sticky_navigation as $menu_item) {
                                            $item_name = ACF::getField('section-name', $menu_item);
                                            $item_anchor = ACF::getField('section-id', $menu_item);
                                            $external_link = ACF::getField('external-link', $menu_item); 
                                            $internal_link = ACF::getField('internal-link', $menu_item); ?>

                                            <?php if (!empty($item_anchor)) { ?>
                                                <li class="sticky-nav__menu-item" data-anchor="<?php echo esc_attr($item_anchor); ?>"><?php echo esc_html($item_name); ?></li>
                                            <?php } ?>

                                            <?php if (!empty($external_link['url'])) { ?>
                                                <li class="sticky-nav__menu-item"><a href="<?php echo esc_url($external_link['url']); ?>" target="_blank"><?php echo esc_html($item_name); ?></a></li>
                                            <?php } ?>

                                            <?php if (!empty($internal_link)) { 
                                                $internal_link = get_the_permalink($internal_link); ?>
                                                <li class="sticky-nav__menu-item"><a href="<?php echo esc_url($internal_link); ?>"><?php echo esc_html($item_name); ?></a></li>
                                            <?php } ?>


                                        <?php }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </header><!-- .header -->
    <?php } ?>