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


################## Site Search ###################
// Instantiating Site Search Util class
$site_search = new SiteSearchUtil();
$global_site_search_array = $site_search->getGlobalSiteSearchArray();

$search_category_param = $global_site_search_array['search_category_param'];
$has_search_category_params = $global_site_search_array['has_search_category_params'];

$search_query = $global_site_search_array['search_query'];
$has_search_query = $global_site_search_array['has_search_query'];

 // search query related variables
 $search_query = filter_input(INPUT_GET, 'q', FILTER_SANITIZE_SPECIAL_CHARS);
 $has_search_query = isset($search_query) && !empty($search_query);

 $go_back_status = ($has_search_query && $has_search_category_params) ? "show" : "hide";

 if ($has_search_query) {
     $search_close_icon_class = "show";
     $search_icon_class = "hide";
 } else {
     $search_close_icon_class = "hide";
     $search_icon_class = "show";
 }

// state = default or results
$siteSearchPageState = ($has_search_query || $has_search_category_params) ? "results" : "default";

// calling getSearchResults to set results_count globally which is used
$output = [];
if ($siteSearchPageState === "results") {
    $output = $site_search->getSearchResults($global_site_search_array);
}


##################################################


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

    do_action('cn/global/crop-region');
    do_action('cn/global/crop-images');

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

                        <div class="uk-hidden@m">
                            <div class="mobile-crop-icon">
                                <span class="header__crop-region-button">
                                    <svg class="icon">
                                        <use xlink:href=""></use>
                                    </svg>
                                </span>
                            </div>
                        </div>

                       
                    </div>
                </div>
            </div>
        </nav>
        <button class="header__crop-region-button">
            <div class="header__crop-region-button-wrap">
                <div class="header__icon-wrapper">
                    <span class="header__crop-icon">
                        <svg class="icon">
                            <use xlink:href=""></use>
                        </svg>
                    </span>
                    <div class="header__crop-region-button-deselector">&times;</div>
                </div>
                <div class="header__crop-region-button-crop"></div>
                <span class="header__crop-region-button-region">

                </span>
            </div>
            <div class="header__crop-region-mobile-edit">
                <div class="mobile-inactive-crop">
                    <p><?php _e('Customize your experience', 'kmag'); ?></p>
                    <span><?php _e('Choose Region & Crop', 'kmag'); ?></span>
                </div>

                <div class="mobile-active-crop">
                    <span><?php _e('Edit Region and Crop', 'kmag'); ?></span>
                </div>
            </div>
        </button>

        <button class="header__go-back-mobile">
            <svg class="icon icon-arrow-left">
                <use xlink:href="#icon-arrow-left"></use>
            </svg>
            <?php _e('Go Back', 'kmag'); ?>
        </button>
    </header><!-- .header -->
    <div class="header__crop-region">
        <div class="header__crop-region-content">
            <div class="uk-grid-collapse uk-child-width-1-2@m header__crop-region-grid" uk-height-match="row: true" uk-grid>
                <div class="header__region-choice">
                    <div class="header__region-map-expander">
                        <div class="header__region-map-wrapper">
                            <?php
                            $file = locate_template("assets/images/north-america-map.svg");
                            if (file_exists($file)) {
                                include $file;
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="header__crop-choice">
                    <div id="welcome_panel" class="header__crop-choice-welcome display-panel">
                        <h2><?php _e('Personalize your experience', 'kmag'); ?></h2>
                        <p><?php _e('Create an enhanced site experience specific to your needs by providing your region and crop.', 'kmag'); ?></p>
                        <h3><?php _e('To begin, select on the map where your farm is located.', 'kmag'); ?></h3>
                    </div>
                    <div id="crop_select_panel" class="header__crop-choice-selector display-panel">
                        <h2><?php _e("You're located in", 'kmag'); ?><span id="conditional-word"><?php _e(' the', 'kmag'); ?></span><br /><span id="region-display-name"></span></h2>
                        <h3><?php _e('Select your desired crop', 'kmag'); ?></h3>

                        <div class="header__crop-dropdown">
                            <button class="uk-button uk-button-default header__crop-dropdown-button" role="combobox" type="button" id="crop-button" aria-controls="crop-dropdown" aria-expanded="false" aria-haspopup="true">
                                <div class="header__dropdown-button-placeholder"><?php _e('Select', 'kmag'); ?></div>
                                <span id="dropdown-button-content"></span>
                                <svg class="icon icon-arrow-down">
                                    <use xlink:href="#icon-arrow-down"></use>
                                </svg>
                            </button>
                            <div role="listbox" id="crop-dropdown" tabindex="-1" uk-dropdown="pos: bottom-center; boundary: !.boundary; shift: false; flip: false; mode:click;" class="uk-dropdown uk-animation-fade header__crop-dropdown-wrapper">
                                <ul class="uk-nav uk-dropdown-nav header__dropdown-nav"></ul>
                            </div>
                        </div>

                        <button id="apply-crop-select" class="btn btn--tertiary" disabled><?php _e('Apply', 'kmag'); ?></button>
                    </div>
                </div>
                <div id="final_choice_panel" class="header__final-choice">
                    <div class="header__crop-choice-conclusion">
                        <h2><?php _e('Enjoy an enhanced site experience tailored to growing', 'kmag'); ?> <span id="final-crop-choice"></span> <?php _e('in', 'kmag'); ?> <span id="final-conditional-word"><?php _e('the', 'kmag'); ?></span> <span id="final-region-choice"></span></h2>
                        <div class="header__final-choice-buttons">
                            <button class="btn btn--secondary header__enjoy-website"><?php _e('Enjoy Your New Website', 'kmag'); ?></button><button class="btn header__clear-selection"><?php _e('Clear Selection', 'kmag'); ?></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header__scroll-select-indicators">
                <?php echo Util::getIconHTML('map-scroll'); ?><?php _e('Scroll', 'kmag'); ?>
                <?php echo Util::getIconHTML('map-select'); ?><?php _e('Select', 'kmag'); ?>
            </div>
        </div>
    </div>

    <!-- Global Search -->
    <div class="header__site-search">
        <div class="header__site-search-content">
            <?php         
            
                echo '<div id="ss-wrapper">' . $site_search->getSiteSearchFormHtml($global_site_search_array) . "</div>"; 

                // If page state is "results"
                if ($siteSearchPageState === "results") {
                    echo '<div id="ss-ajax-site-search-results">' . $output['results_html'] . '</div>';

                } else {
                    // placeholder to show ajax search results
                    echo '<div id="ss-ajax-site-search-results"></div>';
                }

            ?>
             
            <button class="header__go-back-search-results <?php echo $go_back_status ?>">
                <svg class="icon icon-arrow-left">
                    <use xlink:href="#icon-arrow-left"></use>
                </svg>
                <?php _e('Go Back', 'kmag'); ?>
            </button>
             <div class="btn-search-close">   
                <svg class="icon icon-remove-filter">
                    <use xlink:href="#icon-remove-filter"></use>
                </svg>
            </div>
    </div>
   
</div>
    