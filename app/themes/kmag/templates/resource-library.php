<?php

/**
 * Template Name: Resource Library
 *
 * This template displays Advanced Custom Fields
 * flexible content fields in a user-defined order.
 *
 * @package CN
 */

use CN\App\Media;
use CN\App\Fields\ACF;
use CN\App\Fields\Util;
use CN\App\Fields\ResourceLibraryUtil;

// Instantiating Resource Libray Util class
$resource_library = new ResourceLibraryUtil();

$global_resource_library_array = $resource_library->getGlobalResourceLibraryArray();

$tags_param_array = $global_resource_library_array['tags_param_array'];
$has_tags_params = $global_resource_library_array['has_tags_params'];
$resource_type_param_array = $global_resource_library_array['resource_type_param_array'];
$has_resource_type_params = $global_resource_library_array['has_resource_type_params'];
$search_query = $global_resource_library_array['search_query'];
$has_search_query = $global_resource_library_array['has_search_query'];
$is_ajax_search_request = $global_resource_library_array['is_ajax_search_request'];
$is_ajax_clearall_request = $global_resource_library_array['is_ajax_clearall_request'];
$global_crop_cookie_value = $global_resource_library_array['global_crop_cookie_value'];
$is_global_crop_cookie_set = $global_resource_library_array['is_global_crop_cookie_set'];

$resource_library_page_id = get_the_ID();
$resource_library_data = ACF::getPostMeta($resource_library_page_id);

// state = default or results
$resourceLibraryPageState = ($has_tags_params || $has_resource_type_params || $is_ajax_search_request || $is_global_crop_cookie_set) ? "results" : "default";

// Filter
$filters = [
    "crop" => "",
    "nutrients" => "",
    "topics" => "",
    "products" => "",
    "resource-types" => ""
];

// Standarad Article
$article_post_types = array("standard-articles", "robust-articles");
$featured_flag_articles = ACF::getField('featured_article_group_enable_featured_article', $resource_library_data);
$featured_article_id = ACF::getField('featured_article_group_featured_standard_article', $resource_library_data);
$standard_articles_id_list = ACF::getField('featured_article_group_standard_articles', $resource_library_data);

// Trending Topic
$featured_flag_trending_topic = ACF::getField('featured_trending_topic_group_enable_featured_trending_topic', $resource_library_data);
$featured_trending_topic_id = ACF::getField('featured_trending_topic_group_featured_trending_topic', $resource_library_data);
$robust_articles_id_list = ACF::getField('featured_trending_topic_group_robust_articles', $resource_library_data);

// Videos
$featured_flag_video = ACF::getField('featured_video_group_enable_featured_video', $resource_library_data);
$featured_video_id = ACF::getField('featured_video_group_featured_video', $resource_library_data);

// Audios
$featured_flag_audio = ACF::getField('featured_audio_group_enable_featured_audio', $resource_library_data);
$featured_audio_id = ACF::getField('featured_audio_group_featured_audio', $resource_library_data);

// Documents & Labels 
$document_labels_post_types = array("ghs-label", "spec-sheets", "directions-for-use", "sds-pages");

// Success Stories
$featured_flag_success_story = ACF::getField('featured_success_story_group_enable_featured_success_story', $resource_library_data);
$featured_success_story_id = ACF::getField('featured_success_story_group_featured_success_story', $resource_library_data);
?>

<?php get_header(); ?>

<main class="main-container resource-library-container" id="primary">

    <div class="background-gradient gradient-core-page position-top">
    </div>

    <div class="uk-container rl-content-wrapper rl-common">

        <div class="rl-top-section">

            <div class="rl-top-section__heading-wrapper">
                <?php the_title('<h1 class="hdg hdg--1">', '</h1>'); ?>
                <p class="rl-page-desc"><?php _e("Hundreds of articles, trending topics, research insights and more to explore.", "kmag") ?>
                </p>
            </div>
           
            <?php

            // calling getSearchResults to set results_count globally which is used
            if ($resourceLibraryPageState === "results") {
                $output = $resource_library->getSearchResults($global_resource_library_array);
            }

            echo '<div id="filters-wrapper">' . $resource_library->getSearchFilterHtml($global_resource_library_array) . "</div>";

            // If page state is "results"
            if ($resourceLibraryPageState === "results") {
                echo '<div id="rl-ajax-filter-search-results">' . $output['results_html'] . '</div>';

            } else {
                // placeholder to show ajax search results
                echo '<div id="rl-ajax-filter-search-results"></div>'
            ?>

        </div>
        <div class="page-bg rl-default-content uk-container rl-common">

            <?php

                // ===================================================
                // Article section
                // ===================================================

                $standard_article_post_ids = array_map('intval', array_values($standard_articles_id_list));
                $standard_articles_posts = [];
                if (count($standard_article_post_ids) > 0) {
                    $standard_articles_args = array(
                        'post__in' => $standard_article_post_ids,      // Specify the IDs
                        'post_type' => 'any',         // Include all post types
                        'orderby' => 'post__in',      // Preserve the order of the IDs
                        'posts_per_page' => -1        // Ensure all posts are retrieved
                    );
                    $standard_articles_posts = get_posts($standard_articles_args);
                }
                // Pull in the remainder of standard article posts if the count is less than 3
                $standard_articles_posts_count = count($standard_articles_posts);
                if ($standard_articles_posts_count < 3) {
                    $standard_articles_remaining_count = 3 - $standard_articles_posts_count;
                    $standard_articles_remaining_args = array(
                        'post_type' => 'standard-articles',
                        'post_status' => 'publish',
                        'posts_per_page' => $standard_articles_remaining_count,
                        'orderby' => 'asc'
                    );
                    $standard_articles_remaining_query = new WP_Query($standard_articles_remaining_args);
                    $standard_articles_posts = array_merge($standard_articles_posts, $standard_articles_remaining_query->posts);
                }                
            ?>

            <?php if (count($standard_articles_posts)) : ?>

                <section class="rl-default-content__articles-sec  rl-default-content__rl-section">
                    <div class="container">
                        <h2 class="heading2"><?php _e("Articles", "kmag") ?> <span class="view-btn"><a class="arrow-right-wrapper" href="<?php echo esc_url(home_url()) . "/resource-library/?resourceType=standard-articles" ?>"><?php _e("View All", "kmag") ?>
                                    <svg class="icon icon-arrow-right">
                                        <use xlink:href="#icon-arrow-right  "></use>
                                    </svg></a></span>
                        </h2>
                        <?php // Featured Article  
                        ?>

                        <?php if (isset($featured_flag_articles) && $featured_flag_articles === "yes" && isset($featured_article_id) && !empty($featured_article_id)) : ?>

                            <?php

                            $featured_article_data = ACF::getPostMeta($featured_article_id);
                            $featured_article_title = get_the_title($featured_article_id);
                            $featured_article_url = get_permalink($featured_article_id);
                            $featured_article_intro = ACF::getField('article_intro', $featured_article_data);
                            if (has_post_thumbnail($featured_article_id)) {
                                $featured_article_img =  Util::getImageHTML(Media::getAttachmentByID(get_post_thumbnail_id($featured_article_id)));
                            } else {
                                $featured_article_img =  "";
                            }

                            ?>

                            <div class="boxes-wrap">
                                <div class="boxes-wrap__boxes-inner-wrap  mrtp-20 uk-grid  uk-grid-small uk-grid-match boxes-wrap__trending-topic-box-wrap featured-section">
                                    <div class="uk-card uk-card-body boxes-wrap__boxes-inner-wrap__box2 p-0 featured-image trending-topic-box1 ">
                                        <?php echo $featured_article_img ?>
                                    </div>
                                    <div class="uk-card uk-card-body boxes-wrap__boxes-inner-wrap__box2 border_rd_2 dark-bg white-content flex-box featured-content trending-topic-box1 mrtp-15">
                                        <div class="boxes-wrap__boxes-inner-wrap__topic white--txt">
                                            <?php _e("Article", "kmag") ?></div>
                                        <div class="boxes-wrap__boxes-inner-wrap__topic-hd white--txt">
                                            <?php echo esc_html(strip_tags($featured_article_title)); ?>
                                        </div>
                                        <div class="boxes-wrap__boxes-inner-wrap__topic-desc white--txt">
                                            <?php echo esc_html(strip_tags($featured_article_intro)) ?></div>
                                        <div class="boxes-wrap__boxes-inner-wrap__go-btn white--txt boxes-wrap__boxes-inner-wrap__go-btn-white">
                                            <a href="<?php echo esc_url($featured_article_url); ?>"><?php _e("Go", "kmag") ?><svg class="icon icon-arrow-go-white">
                                                    <use xlink:href="#icon-arrow-go-white"></use>
                                                </svg></a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php endif; ?>

                        <?php // Article lisitng  
                        ?>

                        <div class="boxes-wrap">
                            <div class="boxes-wrap__boxes-inner-wrap boxes-wrap__articles-box-wrap uk-grid  uk-grid-small uk-grid-match">

                                <?php foreach ($standard_articles_posts as $article) : ?>

                                    <?php echo $resource_library->getStandardArticleCardHtml($article->ID); ?>

                                <?php endforeach; ?>

                            </div>
                        </div>

                    </div>
                </section>
            <?php endif;  ?>

            <?php wp_reset_query();  ?>

            <?php
                // ===================================================
                // Trending Topic section
                // ===================================================
                
                $robust_article_post_ids = array_map('intval', array_values($robust_articles_id_list));
                $robust_articles_posts = [];

                if (count($robust_article_post_ids) > 0) {
                    $robust_articles_args = array(
                        'post__in' => $robust_article_post_ids,      // Specify the IDs
                        'post_type' => 'any',         // Include all post types
                        'orderby' => 'post__in',      // Preserve the order of the IDs
                        'posts_per_page' => -1        // Ensure all posts are retrieved
                    );
                    $robust_articles_posts = get_posts($robust_articles_args);    
                }
                // Pull in the remainder of robust article posts if the count is less than 3
                $robust_articles_posts_count = count($robust_articles_posts);
                if ($robust_articles_posts_count < 3) {
                    $robust_articles_remaining_count = 3 - $robust_articles_posts_count;
                    $robust_articles_remaining_args = array(
                        'post_type' => 'robust-articles',
                        'post_status' => 'publish',
                        'posts_per_page' => $robust_articles_remaining_count,
                        'orderby' => 'asc'
                    );
                    $robust_articles_remaining_query = new WP_Query($robust_articles_remaining_args);
                    $robust_articles_posts = array_merge($robust_articles_posts, $robust_articles_remaining_query->posts);
                }
            ?>

            <?php if (count($robust_articles_posts)) : ?>
                <section class="rl-default-content__trending-topic-sec  rl-default-content__rl-section">
                    <div class="container">
                        <h2 class="heading2"><?php _e("Trending Topic", "kmag") ?> <span class="view-btn"><a href="<?php echo esc_url(home_url()) . "/resource-library/?resourceType=robust-articles" ?>"><?php _e("View All", "kmag") ?>
                                    <svg class="icon icon-arrow-right">
                                        <use xlink:href="#icon-arrow-right"></use>
                                    </svg></a></span>
                        </h2>
                        <?php
                        // Featured Trending Topic
                        if (isset($featured_flag_trending_topic) && $featured_flag_trending_topic === "yes" && isset($featured_trending_topic_id) && !empty($featured_trending_topic_id)) { ?>

                            <?php

                            $featured_trending_topic_data = ACF::getPostMeta($featured_trending_topic_id);
                            $featured_trending_topic_title = get_the_title($featured_trending_topic_id);
                            $featured_trending_topic_url = get_permalink($featured_trending_topic_id);
                            $featured_trending_topic_intro = ACF::getField('article_intro', $featured_trending_topic_data);

                            if (get_post_thumbnail_id($featured_trending_topic_id)) {
                                $featured_trending_topic_img =  Util::getImageHTML(Media::getAttachmentByID(get_post_thumbnail_id($featured_trending_topic_id)));
                            } else {
                                $featured_trending_topic_img =  "";
                            }

                            ?>

                            <div class="boxes-wrap">
                                <div class="boxes-wrap__boxes-inner-wrap  mrtp-20 uk-grid  uk-grid-small uk-grid-match boxes-wrap__trending-topic-box-wrap featured-section">
                                    <div class="uk-card uk-card-body boxes-wrap__boxes-inner-wrap__box2 p-0 featured-image trending-topic-box1 ">
                                        <?php echo $featured_trending_topic_img ?>
                                    </div>
                                    <div class="uk-card uk-card-body boxes-wrap__boxes-inner-wrap__box2 border_rd_2 dark-bg white-content flex-box featured-content trending-topic-box1 mrtp-15">
                                        <div class="boxes-wrap__boxes-inner-wrap__topic white--txt">
                                            <?php _e("Trending Topic", "kmag") ?></div>
                                        <div class="boxes-wrap__boxes-inner-wrap__topic-hd white--txt">
                                            <?php echo esc_html(strip_tags($featured_trending_topic_title)); ?>
                                        </div>
                                        <div class="boxes-wrap__boxes-inner-wrap__topic-desc white--txt">
                                            <?php echo esc_html(strip_tags($featured_trending_topic_intro)) ?></div>
                                        <div class="boxes-wrap__boxes-inner-wrap__go-btn white--txt boxes-wrap__boxes-inner-wrap__go-btn-white">
                                            <a href="<?php echo esc_url($featured_trending_topic_url); ?>"><?php _e("Go", "kmag") ?><svg class="icon icon-arrow-go-white">
                                                    <use xlink:href="#icon-arrow-go-white"></use>
                                                </svg></a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php  } ?>

                        <?php // Trending Topic Listing  
                        ?>

                        <div class="boxes-wrap">
                            <div class="boxes-wrap__boxes-inner-wrap uk-grid  uk-grid-small uk-grid-match boxes-wrap__trending-topic-box-wrap">

                                <?php foreach ($robust_articles_posts as $trending_topic) : ?>

                                    <?php echo $resource_library->getRobustArticleCardHtml($trending_topic->ID) ?>

                                <?php endforeach; ?>

                            </div>
                        </div>
                    </div>
                </section>
            <?php endif;  ?>

            <?php wp_reset_query();  ?>

            <?php

                // ===================================================
                // TruResponse Trial Data section
                // ===================================================

                $trures_trial_data_args = array(
                    'post_type' => 'trures-trial-data',
                    'post_status' => 'publish',
                    'posts_per_page' => 6,
                    'orderby' => 'rand'
                );
                $trures_trial_data_query = new WP_Query($trures_trial_data_args);

            ?>
            <?php if ($trures_trial_data_query->have_posts()) : 
                $total_posts = $trures_trial_data_query->post_count;  ?>

                <section class="rl-default-content__trures-trial-data-sec  rl-default-content__rl-section">
                    <div class="container">
                        <h2 class="heading2">
                            <svg class="icon icon-trures-trial-data">
                                <use xlink:href="#icon-trures-trial-data"></use>
                            </svg>

                            <?php if ($total_posts === 6) { ?>
                                <span class="view-btn">
                                    <a href="<?php echo esc_url(home_url()) . "/resource-library/?resourceType=trures-trial-data" ?>">
                                        <?php _e("View All", "kmag") ?>
                                        <svg class="icon icon-arrow-right">
                                            <use xlink:href="#icon-arrow-right  "></use>
                                        </svg>
                                    </a>
                                </span>
                            <?php } ?>
                        </h2>
                        <div class="boxes-wrap">
                            <div class="boxes-wrap__boxes-inner-wrap uk-grid  uk-grid-small uk-grid-match boxes-wrap__trures-trial-data-box-wrap">

                                <?php foreach ($trures_trial_data_query->posts as $trial_data) : ?>

                                    <?php echo $resource_library->getTruResTrialDataCardHtml($trial_data->ID); ?>

                                <?php endforeach; ?>

                            </div>
                        </div>

                    </div>
                </section>
            <?php endif;  ?>

            <?php wp_reset_query();  ?>

            <?php

                // ===================================================
                // TrueResponsi Insights section
                // ===================================================


                $trures_insights_args = array(
                    'post_type' => 'trures-insights',
                    'post_status' => 'publish',
                    'posts_per_page' => 6,
                    'orderby' => 'rand'
                );
                $trures_insights_query = new WP_Query($trures_insights_args);

            ?>

            <?php if ($trures_insights_query->have_posts()) : 
                $total_posts = $trures_insights_query->post_count;  ?>

                <section class="rl-default-content__trures-insights-sec  rl-default-content__rl-section">
                    <div class="container">
                        <h2 class="heading2">
                            <svg class="icon icon-trures-insights">
                                <use xlink:href="#icon-trures-insights"></use>
                            </svg>
                            
                            <?php if ($total_posts === 6) { ?>
                                <span class="view-btn">
                                    <a href="<?php echo esc_url(home_url()) . "/resource-library/?resourceType=trures-insights" ?>">
                                        <?php _e("View All", "kmag") ?>
                                    </a>
                                    <svg class="icon icon-arrow-right">
                                        <use xlink:href="#icon-arrow-right  "></use>
                                    </svg>
                                </span>
                            <?php } ?>
                        </h2>

                        <div class="boxes-wrap">
                            <div class="boxes-wrap__boxes-inner-wrap uk-grid  uk-grid-small uk-grid-match boxes-wrap__trures-insights-box-wrap">

                                <?php foreach ($trures_insights_query->posts as $insights) : ?>

                                    <?php echo $resource_library->getTruResInsightsCardHtml($insights->ID); ?>

                                <?php endforeach; ?>

                            </div>
                        </div>

                    </div>
                </section>
            <?php endif;  ?>

            <?php wp_reset_query();  ?>
            
            <?php

                // ===================================================
                // Agrifacts section
                // ===================================================

                $agrifacts_args = array(
                    'post_type' => 'agrifacts',
                    'post_status' => 'publish',
                    'posts_per_page' => 6,
                    'orderby' => 'rand'
                );
                $agrifacts_query = new WP_Query($agrifacts_args);

            ?>
            <?php if ($agrifacts_query->have_posts()) : ?>

                <section class="rl-default-content__agrifacts-sec  rl-default-content__rl-section">
                    <div class="container">
                        <h2 class="heading2"><svg class="icon icon-agrifact-trimmed">
                                <use xlink:href="#icon-agrifact-trimmed"></use>
                            </svg>
                            <span class="view-btn"><a href="<?php echo esc_url(home_url()) . "/resource-library/?resourceType=agrifacts" ?>"><?php _e("View All", "kmag") ?>
                                    <svg class="icon icon-arrow-right">
                                        <use xlink:href="#icon-arrow-right  "></use>
                                    </svg>
                                </a></span>
                        </h2>
                        <div class="boxes-wrap">
                            <div class="boxes-wrap__boxes-inner-wrap uk-grid  uk-grid-small uk-grid-match boxes-wrap__agrifacts-box-wrap">

                                <?php foreach ($agrifacts_query->posts as $fact) : ?>

                                    <?php echo $resource_library->getAgrifactCardHtml($fact->ID); ?>

                                <?php endforeach; ?>

                            </div>
                        </div>

                    </div>
                </section>
            <?php endif;  ?>

            <?php wp_reset_query();  ?>

            <?php

                // ===================================================
                // Calculator section
                // ===================================================

                $calculator_args = array(
                    'post_type' => 'calculators',
                    'post_status' => 'publish',
                    'posts_per_page' => -1,
                    'orderby' => 'rand'
                );
                $calculator_query = new WP_Query($calculator_args);
            ?>

            <?php if ($calculator_query->have_posts()) : ?>


                <section class="rl-default-content__calculators-sec  rl-default-content__rl-section">
                    <div class="container">
                        <h2 class="heading2"><?php _e("Calculators", "kmag") ?></h2>

                        <?php // Calculator lisitng  
                        ?>

                        <div class="boxes-wrap">
                            <div class="boxes-wrap__boxes-inner-wrap uk-grid  uk-grid-small uk-grid-match  boxes-wrap__calculator-box-wrap">

                                <?php foreach ($calculator_query->posts as $calculator) : ?>
                                    <?php echo $resource_library->getCalculatorCardHtml($calculator->ID); ?>

                                <?php endforeach; ?>

                            </div>
                        </div>
                </section>
            <?php endif;  ?>
            <?php wp_reset_query();  ?>

            <?php

                // ===================================================
                // Agrisight section
                // ===================================================


                $agrisights_args = array(
                    'post_type' => 'agrisights',
                    'post_status' => 'publish',
                    'posts_per_page' => 6,
                    'orderby' => 'rand'
                );
                $agrisights_query = new WP_Query($agrisights_args);

            ?>

            <?php if ($agrisights_query->have_posts()) : ?>
                <section class="rl-default-content__agrisight-sec  rl-default-content__rl-section">
                    <div class="container">
                        <h2 class="heading2"><svg class="icon icon-agrisight-trimmed">
                                <use xlink:href="#icon-agrisight-trimmed  "></use>
                            </svg><span class="view-btn"><a href="<?php echo esc_url(home_url()) . "/resource-library/?resourceType=agrisights" ?>"><?php _e("View All", "kmag") ?></a>
                                <svg class="icon icon-arrow-right">
                                    <use xlink:href="#icon-arrow-right  "></use>
                                </svg></span>
                        </h2>
                        <div class="boxes-wrap">
                            <div class="boxes-wrap__boxes-inner-wrap uk-grid  uk-grid-small uk-grid-match boxes-wrap__agrisight-box-wrap">

                                <?php foreach ($agrisights_query->posts as $agrisight) : ?>

                                    <?php echo $resource_library->getAgrisightCardHtml($agrisight->ID); ?>

                                <?php endforeach; ?>

                            </div>
                        </div>

                    </div>
                </section>
            <?php endif;  ?>

            <?php wp_reset_query();  ?>

            <?php

                // ===================================================
                // Video section
                // ===================================================

                $video_args = array(
                    'post_type' => "video-articles",
                    'post_status' => 'publish',
                    'posts_per_page' => 3,
                    'orderby' => 'rand',
                    'meta_key' => 'article_type',
                    'meta_value' => 'video'
                );
                $video_query = new WP_Query($video_args);
            ?>

            <?php if ($video_query->have_posts()) : ?>
                <section class="rl-default-content__video-sec  rl-default-content__rl-section">
                    <div class="container">
                        <h2 class="heading2"><?php _e("Video", "kmag") ?> <span class="view-btn"><a href="<?php echo esc_url(home_url()) . "/resource-library/?resourceType=video-articles" ?>"><?php _e("View All", "kmag") ?>
                                    <svg class="icon icon-arrow-right">
                                        <use xlink:href="#icon-arrow-right"></use>
                                    </svg></a></span>
                        </h2>
                        <?php // Featured Video  
                        ?>

                        <?php if (isset($featured_flag_video) && $featured_flag_video === "yes" && isset($featured_video_id) && !empty($featured_video_id)) : ?>

                            <?php
                            $featured_video_data = ACF::getPostMeta($featured_video_id);
                            $featured_video_title = get_the_title($featured_video_id);
                            $featured_video_url = get_permalink($featured_video_id);
                            $featured_video_intro = ACF::getField('article_body', $featured_video_data);
                            $featured_video_img =  Util::getImageHTML(Media::getAttachmentByID(get_post_thumbnail_id($featured_video_id)));

                            ?>

                            <div class="boxes-wrap">
                                <div class="boxes-wrap__boxes-inner-wrap  mrtp-20 uk-grid uk-grid-small uk-grid-match boxes-wrap__video-box-wrap featured-section">
                                    <div class="uk-card uk-card-body boxes-wrap__boxes-inner-wrap__box2 border_rd_3 green-bg white-content flex-box boxes-wrap__video-box-wrap__video-box1 featured-content">
                                        <div class="boxes-wrap__boxes-inner-wrap__topic white--txt">
                                            <?php _e("Video", "kmag") ?></div>
                                        <div class="boxes-wrap__boxes-inner-wrap__topic-hd white--txt">
                                            <?php echo esc_html(strip_tags($featured_video_title)); ?>
                                        </div>
                                        <div class="boxes-wrap__boxes-inner-wrap__topic-desc white--txt">
                                            <?php echo esc_html(strip_tags($featured_video_intro)); ?>
                                        </div>
                                        <div class="boxes-wrap__boxes-inner-wrap__go-btn white--txt boxes-wrap__boxes-inner-wrap__go-btn-white">
                                            <a href="<?php echo esc_url($featured_video_url); ?>">
                                                <?php _e("Go", "kmag") ?><svg class="icon icon-arrow-go-white">
                                                    <use xlink:href="#icon-arrow-go-white"></use>
                                                </svg></a>
                                        </div>
                                    </div>
                                    <div class="uk-card uk-card-body boxes-wrap__boxes-inner-wrap__box2 p-0 boxes-wrap__video-box-wrap__video-box2 featured-image mrtp-15">
                                        <?php if (isset($featured_video_img)) {
                                            echo $featured_video_img;
                                        }  ?>

                                        <div class="video-btn"><a href="<?php echo esc_url($featured_video_url) ?>"><svg class="icon icon-video">
                                                    <use xlink:href="#icon-video"></use>
                                                </svg></a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php endif; ?>

                        <?php // Video lisitng   
                        ?>

                        <div class="boxes-wrap">

                            <div class="boxes-wrap__boxes-inner-wrap uk-grid  uk-grid-small uk-grid-match boxes-wrap__video-box-wrap">

                                <?php foreach ($video_query->posts as $video) : ?>

                                    <?php echo $resource_library->getAudioVideoCardHtml($video->ID); ?>
                                <?php endforeach; ?>

                            </div>
                        </div>
                </section>
            <?php endif;  ?>

            <?php wp_reset_query();  ?>

            <?php

                // ===================================================
                // Audio section
                // ===================================================

                $audio_args = array(
                    'post_type' => "video-articles",
                    'post_status' => 'publish',
                    'posts_per_page' => 3,
                    'orderby' => 'rand',
                    'meta_key' => 'article_type',
                    'meta_value' => 'audio'
                );
                $audio_query = new WP_Query($audio_args);

            ?>

            <?php if ($audio_query->have_posts()) : ?>

                <section class="rl-default-content__listen-now-sec  rl-default-content__rl-section">
                    <div class="container">
                        <h2 class="heading2"><?php _e("Listen Now", "kmag") ?> <span class="view-btn"><a href="<?php echo esc_url(home_url()) . "/resource-library/?resourceType=audio-articles" ?>"><?php _e("View All", "kmag") ?>
                                    <svg class="icon icon-arrow-right">
                                        <use xlink:href="#icon-arrow-right  "></use>
                                    </svg></a></span>
                        </h2>

                        <?php // Featured Audio  
                        ?>

                        <?php if (isset($featured_flag_audio) && $featured_flag_audio === "yes" && isset($featured_audio_id) && !empty($featured_audio_id)) : ?>

                            <?php
                            $featured_audio_data = ACF::getPostMeta($featured_audio_id);
                            $featured_audio_title = get_the_title($featured_audio_id);
                            $featured_audio_url = get_permalink($featured_audio_id);
                            $featured_audio_intro = ACF::getField('article_body', $featured_audio_data);
                            $featured_audio_img =  Util::getImageHTML(Media::getAttachmentByID(get_post_thumbnail_id($featured_audio_id)), 'large');
                            ?>


                            <div class="boxes-wrap">
                                <div class="boxes-wrap__boxes-inner-wrap  mrtp-20 uk-grid uk-grid-small uk-grid-match boxes-wrap__listen-now-box-wrap featured-section">
                                    <div class="uk-card uk-card-body boxes-wrap__boxes-inner-wrap__box2 p-0 featured-image listen-now-box1 ">
                                        <?php if (isset($featured_audio_img)) {
                                            echo $featured_audio_img;
                                        }  ?> <div class="audio-btn"><a href="<?php echo esc_url($featured_audio_url) ?>"><svg class="icon icon-audio">
                                        <use xlink:href="#icon-audio"></use>
                                    </svg></a>
                            </div>
                                    </div>
                                    <div class="uk-card uk-card-body boxes-wrap__boxes-inner-wrap__box2 border_rd_2 gradiant-green flex-box listen-now-box1 featured-content mrtp-15">
                                        <div class="boxes-wrap__boxes-inner-wrap__topic"> <?php _e("Audio", "kmag") ?>
                                        </div>
                                        <div class="boxes-wrap__boxes-inner-wrap__topic-hd">
                                            <?php echo esc_html(strip_tags($featured_audio_title)); ?></div>
                                        <div class="boxes-wrap__boxes-inner-wrap__topic-desc">
                                            <?php echo esc_html(strip_tags($featured_audio_intro)); ?>
                                        </div>
                                        <div class="boxes-wrap__boxes-inner-wrap__go-btn"><a href="<?php echo esc_url($featured_audio_url); ?>"><?php _e("Listen Now", "kmag") ?><svg class="icon icon-arrow-go-hearty-green">
                                                    <use xlink:href="#icon-arrow-go-hearty-green"></use>
                                                </svg></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>

                <?php endif; ?>

                <?php // Audio lisitng   
                ?>
                <div class="boxes-wrap">
                    <div class="boxes-wrap__boxes-inner-wrap uk-grid  uk-grid-small uk-grid-match boxes-wrap__listen-now-box-wrap">

                        <?php foreach ($audio_query->posts as $audio) : ?>

                            <?php echo $resource_library->getAudioVideoCardHtml($audio->ID); ?>
                        <?php endforeach; ?>

                    </div>
                </div>
                </section>

            <?php endif;  ?>

            <?php wp_reset_query();  ?>

            <?php

                // ===================================================
                // Documents & labels section
                // ===================================================

                $document_labels_args = array(
                    'post_type' => $document_labels_post_types,
                    'post_status' => 'publish',
                    'posts_per_page' => 6,
                    'orderby' => 'rand'
                );
                $document_labels_query = new WP_Query($document_labels_args);

            ?>

            <?php if ($document_labels_query->have_posts()) : ?>


                <section class="rl-default-content__documents-labels-sec  rl-default-content__rl-section">
                    <div class="container">
                        <h2 class="heading2"><?php _e("Documents & Labels", "kmag") ?> <span class="view-btn"><a href="<?php echo esc_url(home_url()) . "/resource-library/?resourceType=documents" ?>"><?php _e("View All", "kmag") ?>
                                    <svg class="icon icon-arrow-right">
                                        <use xlink:href="#icon-arrow-right  "></use>
                                    </svg></a></span>
                        </h2>
                        <div class="boxes-wrap">
                            <div class="boxes-wrap__boxes-inner-wrap uk-grid  uk-grid-small uk-grid-match boxes-wrap__documents-labels-box-wrap">

                                <?php foreach ($document_labels_query->posts as $document_label) : ?>

                                    <?php echo $resource_library->getDocumentsCardHtml($document_label->ID); ?>

                                <?php endforeach; ?>

                            </div>
                        </div>
                </section>

            <?php endif;  ?>

            <?php wp_reset_query();  ?>

            <?php

                // ===================================================
                // Success Story section
                // ===================================================

                $success_args = array(
                    'post_type' => 'success-story',
                    'post_status' => 'publish',
                    'posts_per_page' => 3,
                    'orderby' => 'rand'
                );
                $success_query = new WP_Query($success_args);

            ?>

            <?php if ($success_query->have_posts()) : ?>


                <section class="rl-default-content__success-story-sec  rl-default-content__rl-section">
                    <div class="container">
                        <h2 class="heading2"><?php _e("Success Story", "kmag") ?> <span class="view-btn"><a href="<?php echo esc_url(home_url()) . "/resource-library/?resourceType=success-story" ?>"><?php _e("View All", "kmag") ?>
                                    <svg class="icon icon-arrow-right">
                                        <use xlink:href="#icon-arrow-right  "></use>
                                    </svg></a></span></h2>

                        <?php // Featured Success Story  
                        ?>


                        <?php if (isset($featured_flag_success_story) && $featured_flag_success_story === "yes" && isset($featured_success_story_id) && !empty($featured_success_story_id)) : ?>

                            <?php
                            $featured_success_story_data = ACF::getPostMeta($featured_audio_id);
                            $featured_success_story_title = get_the_title($featured_audio_id);
                            $featured_success_story_url = get_permalink($featured_audio_id);
                            $featured_success_story_intro = ACF::getField('article_body', $featured_success_story_data);
                            $featured_success_story_img =  Util::getImageHTML(Media::getAttachmentByID(get_post_thumbnail_id($featured_audio_id)));
                            ?>

                            <div class="boxes-wrap">
                                <div class="boxes-wrap__boxes-inner-wrap  mrtp-20 uk-grid  uk-grid-small uk-grid-match boxes-wrap__trending-topic-box-wrap featured-section">
                                    <div class="uk-card uk-card-body boxes-wrap__boxes-inner-wrap__box2 p-0 featured-image trending-topic-box1 ">
                                        <?php echo $featured_article_img ?>
                                    </div>
                                    <div class="uk-card uk-card-body boxes-wrap__boxes-inner-wrap__box2 border_rd_2 dark-bg white-content flex-box featured-content trending-topic-box1 mrtp-15">
                                        <div class="boxes-wrap__boxes-inner-wrap__topic white--txt">
                                            <?php _e("Article", "kmag") ?></div>
                                        <div class="boxes-wrap__boxes-inner-wrap__topic-hd white--txt">
                                            <?php echo esc_html(strip_tags($featured_article_title)); ?>
                                        </div>
                                        <div class="boxes-wrap__boxes-inner-wrap__topic-desc white--txt">
                                            <?php echo esc_html(strip_tags($featured_article_intro)) ?></div>
                                        <div class="boxes-wrap__boxes-inner-wrap__go-btn white--txt boxes-wrap__boxes-inner-wrap__go-btn-white">
                                            <a href="<?php echo esc_url($featured_article_url); ?>"><?php _e("Go", "kmag") ?><svg class="icon icon-arrow-go-white">
                                                    <use xlink:href="#icon-arrow-go-white"></use>
                                                </svg></a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php endif; ?>

                        <?php // Success Story lisitng  
                        ?>

                        <div class="boxes-wrap">
                            <div class="boxes-wrap__boxes-inner-wrap uk-grid  uk-grid-small uk-grid-match  boxes-wrap__success-story-box-wrap">

                                <?php foreach ($success_query->posts as $success_story) : ?>

                                    <?php echo $resource_library->getSuccessStoryCardHtml($success_story->ID); ?>

                                <?php endforeach; ?>

                            </div>
                        </div>
                </section>
            <?php endif;  ?>
            <?php wp_reset_query();  ?>

        </div>
    <?php } ?>
    </div>
    <div class="background-gradient gradient-core-page position-bottom">
    </div>
</main>

<?php 
$ai_agent_button_location = ACF::getField('ai-agent_agent-button-location', $resource_library_data, 'disabled');
$ai_agent_disabled = $ai_agent_button_location === 'disabled';
if (!$ai_agent_disabled) {
    $ai_agent_id = ACF::getField('ai-agent_agent-id', $resource_library_data);
    $ai_agent_version = ACF::getField('ai-agent_agent-version', $data, 'v2');
?>
    <script type="module"
        src="https://agent.d-id.com/<?php echo esc_attr($ai_agent_version); ?>/index.js"
        data-mode="fabio"
        data-client-key="YXV0aDB8Njc0NzZhMDg3YjE5OTJkYWI1YmYyMDBiOm85ZzRXMmE4QmVUT3A2QnFKZzhfeg=="
        data-agent-id="<?php echo esc_attr($ai_agent_id); ?>"
        data-name="did-agent"
        data-orientation="horizontal"
        data-position="<?php echo $ai_agent_button_location; ?>"
        data-monitor="true"
    >
    </script>
<?php
} 
get_footer(); 
?>