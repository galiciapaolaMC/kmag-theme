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


$options = Options::getSiteOptions();
$logo = ACF::getField('site_logo', $options);
$head_scripts = ACF::getField('head_scripts', $options);
$body_scripts = ACF::getField('body_scripts', $options);
$non_cached_pages = ACF::getField('non_cached_pages', $options, []);

$cache_meta_tags = '';
$current_post_id = get_the_ID();

if (count($non_cached_pages) > 0 && in_array($current_post_id, $non_cached_pages)) {
    $cache_meta_tags = '<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />';
    $cache_meta_tags .= '<meta http-equiv="Pragma" content="no-cache" />';
    $cache_meta_tags .= '<meta http-equiv="Expires" content="0" />';
}

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
    <?php echo $cache_meta_tags; ?>
    <link rel="profile" href="http://gmpg.org/xfn/11">

    <?php
    wp_head();

    echo $head_scripts;
    ?>
</head>

<body <?php body_class(); ?>>

    <?php echo $body_scripts; ?>

    <!-- skip to main content -->
    <a href="#primary" class="screen-reader-text"><?php _e('Skip to Main Content', 'kmag'); ?></a>

    <?php do_action('cn/styles/icons'); ?>

    <header id="masthead" class="header" role="banner">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="uk-container uk-container-large header__main-container">
                <div class="uk-grid uk-grid-medium header__header-wrapper" uk-grid>
                    <div class="uk-width-1-6 header__logo-container">
                        <a class="header__logo" href="<?php echo home_url(); ?>"><?php echo Util::getImageHTML(Media::getAttachmentByID($logo)); ?></a>
                    </div>

                    <div class="uk-width-5-6 header__menu-container">
                        <div class="header__menu">
                            <?php
                            // Loads the menu/primary.php template.
                            get_template_part('menu/primary');
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
       
        <button class="header__go-back-mobile">
            <svg class="icon icon-arrow-left">
                <use xlink:href="#icon-arrow-left"></use>
            </svg>
            <?php _e('Go Back', 'kmag'); ?>
        </button>
    </header><!-- .header -->
   
</div>
    