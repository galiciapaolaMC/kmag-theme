<?php

namespace CN\App\Fields;

use CN\App\Media;
use CN\App\Fields\ACF;
use CN\App\Fields\Util;
use CN\App\Interfaces\WordPressHooks;


/**
 * Class SiteSearchUtil
 *
 * @package CN\App\Fields
 */
class SiteSearchUtil implements WordPressHooks
{

    private $global_site_search_array;

    public function __construct()
    {
        $this->setGlobalSiteSearchArray();
    }

    /**
     * Add class hooks.
     */
    public function addHooks()
    {
        add_action('wp_enqueue_scripts', [$this, 'cnSiteSearchScripts']);

        // Ajax Callback
        add_action('wp_ajax_cn_ajax_site_search', [$this, 'cn_ajax_site_search_callback']);
        add_action('wp_ajax_nopriv_cn_ajax_site_search', [$this, 'cn_ajax_site_search_callback']);
    }

    function getSanitizedParamValue($param)
    {
        $sanitized_value = filter_input(INPUT_GET, $param, FILTER_SANITIZE_SPECIAL_CHARS);
        return $sanitized_value;
    }

    function getParam($param_id, $default_value)
    {
        $sanitized_param_value = $this->getSanitizedParamValue($param_id);
        $get_action_param = (isset($sanitized_param_value) && !empty($sanitized_param_value)) ? $sanitized_param_value : $default_value;
        return $get_action_param;
    }

    function isParamSet($param_id)
    {
        $sanitized_param_value = filter_input(INPUT_GET, $param_id, FILTER_SANITIZE_SPECIAL_CHARS);
        $is_param_set = (isset($sanitized_param_value) && !empty($sanitized_param_value));
        return $is_param_set;
    }

    public function setGlobalSiteSearchArray()
    {
        // searchCategory variables
        $search_category_param = $this->getParam("searchCategory", "");
        $has_search_category_params = $this->isParamSet("searchCategory");

        // search query related variables
        $search_query = $this->getParam("q", "");
        $has_search_query = $this->isParamSet("q");

        // ajax search request
        $get_action_param = $this->getSanitizedParamValue("action");
        $is_ajax_search_request = ($get_action_param === "cn_ajax_site_search");

        // ajax loadmore request
        $get_loadmore_param =  $this->getSanitizedParamValue("loadmore");
        $is_ajax_loadmore_request = ($get_loadmore_param === "yes") ? true : false;

        // results count
        $results_count = 0;

        // get page number
        $page_num_get_value = $this->getSanitizedParamValue("page");
        $page_num = (isset($page_num_get_value) && !empty($page_num_get_value)) ? (int)$page_num_get_value : 1;

        $global_site_search_array = array(
            'search_category_param' => $search_category_param,
            'has_search_category_params' => $has_search_category_params,
            'search_query' => $search_query,
            'has_search_query' => $has_search_query,
            'is_ajax_search_request' => $is_ajax_search_request,
            'is_ajax_loadmore_request' => $is_ajax_loadmore_request,
            'results_count' => $results_count,
            'page_num' => $page_num
        );

        $this->global_site_search_array = $global_site_search_array;
    }

    //get global site search array
    public function getGlobalSiteSearchArray()
    {
        $global_site_search_array = $this->global_site_search_array;
        return $global_site_search_array;
    }


    // get trimmed text
    public function getTrimmedText($text, $chars)
    {
        return mb_strimwidth($text, 0, $chars, '...');
    }


    // Performance Products Card
    public function getPerformanceProductCard($id)
    {
        $meta = ACF::getPostMeta($id);
        $product_logo_id = ACF::getField('black-logo', $meta);
        $product_color = ACF::getField('color', $meta, 'transparent');
        $description = ACF::getField('description', $meta);
        $title = ACF::getField('name', $meta);
        $link = ACF::getField('performance_product_slug', $meta);
        $product_slug = sanitize_title(get_the_title($id));
        $extension = pathinfo($_SERVER['SERVER_NAME'], PATHINFO_EXTENSION);

        $img_folder = $extension === 'local' ? 'app' : 'wp-content';


        if (str_contains($product_slug, 'prb9')) {
            $product_slug = 'refirma-hydraguard';
        }

        $product_html = '<div class="uk-card uk-card-body boxes-wrap__boxes-inner-wrap__box product-box product-' . $product_slug . '" style="background-color:' . esc_attr($product_color) . '">
                <div class="hero__product-logo" style="background-color:' . esc_attr($product_color) . '"><svg class="icon icon-' . $product_slug . '" aria-hidden="true">
                <use xlink:href="#icon-' . $product_slug . '"></use>
            </svg></div> 
                <h2>' . esc_html($title) . '</h2>
                <p class="product-desc">' . esc_html($description) . '</p>
                <a href="' . esc_url($link) . '" class="product-btn">' . sprintf(
            __('Go to %1$s.', 'kmag'),
            get_the_title($id)
        ) . '</a>
                <img class="product-image" src="/' . $img_folder . '/uploads/product-cards/product-' . $product_slug . '.png" />
            </div>';


        return $product_html;
    }


    // Standard Article Card
    public function getStandardArticleCardHtml($id)
    {
        $article_data = ACF::getPostMeta($id);
        $article_title = get_the_title($id);
        $article_url = get_permalink($id);
        $article_body = ACF::getField('article_excerpt', $article_data, null);
        $card_html = '';


        $article_body = $article_body ?? ACF::getField('article_body', $article_data, null) ?? ACF::getField('section-content', $article_data);

        if (strlen($article_body) > 75) {
            $article_body = $this->getTrimmedText($article_body, 75);
        }

        $card_html = '
        <div class="uk-card uk-card-body boxes-wrap__boxes-inner-wrap__box boxes-wrap__boxes-inner-wrap__articles-box">
            <div class="boxes-wrap__boxes-inner-wrap__topic">' . __("Article", "kmag") . '
            </div>
            <a class="uk-card-title boxes-wrap__boxes-inner-wrap__topic-hd" href="' . esc_url($article_url) . '">'
            . esc_html(strip_tags($article_title)) . '</a>
            <div class="boxes-wrap__boxes-inner-wrap__topic-desc">' . esc_html(strip_tags($article_body)) . '</div>
            <div class="boxes-wrap__boxes-inner-wrap__go-btn"><a href="' . esc_url($article_url) . '">' . __("Go", "kmag") . '<svg class="icon icon-arrow-go-hearty-green">
            <use xlink:href="#icon-arrow-go-hearty-green"></use>
            </svg></a>
            </div>
            <a href="' . esc_url($article_url) . '" class="fill-div"></a>
        </div>';

        return $card_html;
    }

    // More section page Card
    public function getPageCardHtml($id)
    {
        $page_data = ACF::getPostMeta($id);
        $page_title = get_the_title($id);
        $page_url = get_permalink($id);
        $page_body = ACF::getField('article_excerpt', $page_data, null);
        $card_html = '';

        $page_body = $page_body ?? ACF::getField('article_body', $page_data, null) ?? ACF::getField('section-content', $page_data);

        // TODO page_body

        if (strlen($page_body) > 75) {
            $page_body = $this->getTrimmedText($page_body, 75);
        }

        $card_html = '
        <div class="uk-card uk-card-body boxes-wrap__boxes-inner-wrap__box boxes-wrap__boxes-inner-wrap__articles-box">
            <div class="boxes-wrap__boxes-inner-wrap__topic">' . __("Page", "kmag") . '
            </div>
            <a class="uk-card-title boxes-wrap__boxes-inner-wrap__topic-hd" href="' . esc_url($page_url) . '">'
            . esc_html(strip_tags($page_title)) . '</a>
            <div class="boxes-wrap__boxes-inner-wrap__topic-desc">' . esc_html(strip_tags($page_body)) . '</div>
            <div class="boxes-wrap__boxes-inner-wrap__go-btn"><a href="' . esc_url($page_url) . '">' . __("Go", "kmag") . '<svg class="icon icon-arrow-go-hearty-green">
            <use xlink:href="#icon-arrow-go-hearty-green"></use>
            </svg></a>
            </div>
            <a href="' . esc_url($page_url) . '" class="fill-div"></a>
        </div>';

        return $card_html;
    }

    // Robust Article / Trending Topic Html
    public function getRobustArticleCardHtml($id)
    {
        $trending_topic_title = get_the_title($id);

        $trending_topic_url = get_permalink($id);

        $data = ACF::getPostMeta($id);

        // ACF Fields -> Hero Images
        $hero_image = ACF::getField('hero_image', $data);
        $has_hero_image = !empty($hero_image);
        $image_attachment = $has_hero_image ? Media::getAttachmentByID($hero_image) : false;
        $src = $image_attachment ? ACF::getField('full', $image_attachment->sizes, $image_attachment->url) : null;

        if ($has_hero_image) {
            $desktop_styles = 'background-image: url(' . esc_html($src) . ');';
        } else {
            $desktop_styles = "";
        }

        $card_html = '<div
    class="uk-card uk-card-body boxes-wrap__boxes-inner-wrap__box overlay boxes-wrap__boxes-inner-wrap__trending-topic-box border-0" style="' . $desktop_styles . '">
    <div class="boxes-wrap__boxes-inner-wrap__topic white--txt">' . __("Trending Topic", "kmag") . '</div>
    <a href="' . esc_url($trending_topic_url) . '" class="boxes-wrap__boxes-inner-wrap__topic-hd m-h1 white--txt">' . esc_html(strip_tags($trending_topic_title)) . '</a>
    <div class="boxes-wrap__boxes-inner-wrap__go-btn white--txt boxes-wrap__boxes-inner-wrap__go-btn-white">
    <a href="' . esc_url($trending_topic_url) . '">' . __("Go", "kmag") . '<svg class="icon icon-arrow-go-white">
    <use xlink:href="#icon-arrow-go-white"></use></svg></a>
    </div>
    <a href="' . esc_url($trending_topic_url) . '" class="fill-div"></a>
    </div>';

        return $card_html;
    }


    // Agrifact Card Html
    public function getAgrifactCardHtml($id)
    {
        $meta = ACF::getPostMeta($id);

        $fact = get_post($id);

        $fact_data = [];

        // This will get the year or years that the data
        // was collected. This is the data in the Lower Right
        // corner of the card.
        $trial_years = ACF::getField('trial_years', $meta);
        $trial_years_list = explode('-', $trial_years);
        if (count($trial_years_list) === 2) {
            $trial_years = intval($trial_years_list[1]) - intval($trial_years_list[0]) + 1;
            $trial_years = sprintf(
                _n('%d Year of data', '%d Years of data', $trial_years, 'kmag'),
                $trial_years
            );
        }
        $fact_data['trial_years'] = $trial_years;


        $yield_stats = ACF::getField('yield_stats', $meta, []);
        // the function convertJsonQuotes will be provided below
        // It is helpful for pulling out the JSON data
        $yield_stats = Util::convertJsonQuotes($yield_stats);

        if (isset($yield_stats[0])) {
            $fact_data['unit'] = esc_html($yield_stats[0]['unit'] ?? '-');
            $fact_data['amount'] = esc_html($yield_stats[0]['amount'] ?? '-');
            $fact_data['description'] = $yield_stats[0]['description'] ? esc_html($yield_stats[0]['description']) : "";
        } else {
            $fact_data['unit'] = "";
            $fact_data['amount'] = "";
            $fact_data['description'] = "";
        }


        // title is the card's title
        $original_title = get_the_title($id);
        $trimmed_title = $this->getTrimmedText($original_title, 40);
        $fact_data['title'] = $trimmed_title ?? '';

        // url is the URL of the agrifact in the resource-library
        $fact_data['url'] = esc_url(get_permalink($id));

        // crop icon
        $crop_obj = wp_get_post_terms($id, 'crop');

        $crop_names = [];

        if (count($crop_obj)) {
            foreach ($crop_obj as $crop) {
                $crop_names[] = strtolower($crop->slug);
            }
        }

        if (isset($crop_names[0])) {
            $crop_icon = $crop_names[0];
        } else {
            $crop_icon = "";
        }

        // getting the logo
        $product_terms = $fact->products ?? wp_get_object_terms($id, 'performance-product', array("order" => "ASC", 'orderby' => 'term_id'));
        $product_terms_slugs = [];
        $product_icon_html = '';
        if ($product_terms && count($product_terms) > 0) {
            $product_terms_slugs = array_map(function ($term) {
                return $term->slug;
            }, $product_terms);
            $product_icon_html = Util::getIconHTML($product_terms[0]->slug);
        }

        $card_html = '
        <div class="uk-card uk-card-body boxes-wrap__boxes-inner-wrap__box agrifacts-box">
        <div class="boxes-wrap__boxes-inner-wrap__topic-hd-wrap1">
        <div class="boxes-wrap__boxes-inner-wrap__topic-l">
            <div class="boxes-wrap__boxes-inner-wrap__topic-hd">
                <a class="boxes-wrap__boxes-inner-wrap__topic-hd" href="' . esc_url($fact_data['url']) . '">' .
            esc_html(strip_tags($fact_data["title"])) . '</a>
            </div>
            <div class="boxes-wrap__boxes-inner-wrap__topic-desc">' . esc_html(strip_tags($fact_data["description"])) . '</div>
        </div>
        <div class="crop-icon-holder">
        <svg class="icon icon-' . $crop_icon . '">
                                                <use xlink:href="#icon-' . $crop_icon . '"></use>
                                            </svg>
                                            </div>
        </div>
        <div class="af-info-wrapper">
        <div class="boxes-wrap__boxes-inner-wrap__product-info">
        <div class="boxes-wrap__boxes-inner-wrap__product-info__up-arrow"><svg
                class="icon icon-arrow-up product-info__up-arrow__icon" aria-hidden="true">
                <use xlink:href="#icon-arrow-up"></use>
            </svg></div>
        <div class="boxes-wrap__boxes-inner-wrap__product-info__points">' . esc_html($fact_data['amount']) . '</div>
        <div class="boxes-wrap__boxes-inner-wrap__product-info__bu-ac">' . esc_html($fact_data['unit']) . '</div>
        </div>
        <div class="boxes-wrap__boxes-inner-wrap__data-info">
        <div class="boxes-wrap__boxes-inner-wrap__data-info__logo">' . $product_icon_html . '
        </div>
        <div class="boxes-wrap__boxes-inner-wrap__data-info__data-yrs">' . esc_html($fact_data['trial_years']) . '
        </div>
        </div>
        </div>
        <a href="' . esc_url($fact_data['url']) . '" class="fill-div"></a>
        </div>';

        return $card_html;
    }


    // Agrisight Card html
    public function getAgrisightCardHtml($id)
    {
        $agrisight_data = ACF::getPostMeta($id);
        $agrisight_title = get_the_title($id);
        $agrisight_url = get_permalink($id);
        $agrisight_body = strip_shortcodes(ACF::getField('article-body', $agrisight_data));

        if (strlen($agrisight_body) > 108) {
            $agrisight_body = mb_strimwidth($agrisight_body, 0, 108, '...');
        }

        $card_html = '
        <div class="uk-card uk-card-body boxes-wrap__boxes-inner-wrap__box agrisight-box border-0">
            <div class="boxes-wrap__boxes-inner-wrap__topic icon-wrapper"><svg class="icon icon-agrisight-trimmed" aria-hidden="true">
            <use xlink:href="#icon-agrisight-trimmed"></use>
            </svg></div>
            <a class="boxes-wrap__boxes-inner-wrap__topic-hd" href="' . esc_url($agrisight_url) . '">' . esc_html(strip_tags($agrisight_title)) . '</a>
            <div class="boxes-wrap__boxes-inner-wrap__topic-desc">
            ' . esc_html(strip_tags($agrisight_body)) . '</div>
            <a href="' . esc_url($agrisight_url) . '" class="fill-div"></a>
        </div>';

        return $card_html;
    }


    // Calculator Card html
    public function getCalculatorCardHtml($id)
    {
        $calculator_data = ACF::getPostMeta($id);
        $title = ACF::getField('title', $calculator_data);
        $description = ACF::getField('description', $calculator_data);
        $link = ACF::getField('link', $calculator_data);
        $calculator = ACF::getField('calculator', $calculator_data);

        $paths = ['microessentials' => 'microessentials-roi-calculator', 'aspire' => 'aspire-roi-calculator', 'nutrient' => 'nutrient-removal-calculator', 'bio-calculator' => 'powercoat-impregnation-calculator-request-form'];

        $calculator_html = '<div class="uk-card uk-card-body boxes-wrap__boxes-inner-wrap__box calculator-box ' . esc_html($calculator) . '">
                                <h2>' . esc_html($title) . '</h2>
                                <div class="uk-grid-collapse uk-child-width-1-2@m column-wrapper" uk-grid>
                                    <div class="left-side  ' . esc_html($calculator) . '-calculator">
                                        <p class="paragraph">' . esc_html($description) . '</p>';
        if ($calculator === 'bio-calculator') {
            $calculator_html .= '<a class="calculator-btn" href="/' . $paths[$calculator] . '/">
                                            Calculate
                                            <svg class="icon icon-arrow-right">
                                                <use xlink:href="#icon-arrow-right"></use>
                                            </svg>
                                        </a>';
        } else {
            $calculator_html .= '<a class="calculator-btn" href="/resource-library/' . $paths[$calculator] . '/">
                                            Calculate
                                            <svg class="icon icon-arrow-right">
                                                <use xlink:href="#icon-arrow-right"></use>
                                            </svg>
                                        </a>';
        }
        $calculator_html .= '</div>
                        <div class="right-side ' . esc_html($calculator) . '-calculator">';

        if ($calculator === 'nutrient') {
            $calculator_html .= '<p class="big-number">' . __('3.5', 'kmag') . '</p>
                                    <p class="units">' . __('Tons/Ac', 'kmag') . '</p>
                                    <svg class="icon icon-bar-graph">
                                            <use xlink:href="#icon-bar-graph"></use>
                                    </svg>';
        } else if ($calculator === 'bio-calculator') {
            $calculator_html .= '<div class="icon-wrapper">
                                        <div class="inner-wrapper retail-value-icon">
                                            <svg class="icon icon-powercoat-logo" style="max-width:100%;">
                                                <use xlink:href="#icon-powercoat-logo"></use>
                                            </svg>
                                        </div>
                                    </div>';
        } else {
            $calculator_html .=   '<div class="icon-wrapper">
                                        <div class="inner-wrapper">
                                            <svg class="icon icon-' . esc_html($calculator) . '">
                                                <use xlink:href="#icon-' . esc_html($calculator) . '"></use>
                                            </svg>
                                            <p>' . __('ROI increase', 'kmag') . '</p>
                                        </div>
                                    </div>';
        }
        if ($calculator === 'bio-calculator') {
            $calculator_html .= '<a class="calculator-btn" href="/' . $paths[$calculator] . '/">
                                        Calculate
                                        <svg class="icon icon-arrow-right">
                                            <use xlink:href="#icon-arrow-right"></use>
                                        </svg>
                                    </a>
                                    </div>
                                </div>
                                <a href="/' . $paths[$calculator] . '/" class="fill-div"></a>';
        } else {
            $calculator_html .= '<a class="calculator-btn" href="/resource-library/' . $paths[$calculator] . '/">
                                    Calculate
                                    <svg class="icon icon-arrow-right">
                                        <use xlink:href="#icon-arrow-right"></use>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <a href="/resource-library/' . $paths[$calculator] . '/" class="fill-div"></a>';
        }
        $calculator_html .= '
                        </div>';

        return $calculator_html;
    }


    // Audio / Video Card Html
    public function getAudioVideoCardHtml($id)
    {
        $video_data = ACF::getPostMeta($id);
        $audio_video_flag =  $video_data['article_type'];
        $video_title = get_the_title($id);
        $video_url = get_permalink($id);

        $video_body = ACF::getField('article_body', $video_data);

        if (strlen($video_body) > 75) {
            $video_body = mb_strimwidth($video_body, 0, 75, '...');
        }

        // ACF Fields -> Hero Images
        $hero_image = ACF::getField('video_preview', $video_data);
        $has_hero_image = !empty($hero_image);
        $image_attachment = $has_hero_image ? Media::getAttachmentByID($hero_image) : false;
        $src = $image_attachment ? ACF::getField('full', $image_attachment->sizes, $image_attachment->url) : null;

        if ($has_hero_image) {
            $desktop_styles = 'background-image: url(' . esc_html($src) . ');';
        } else {
            $desktop_styles = "";
        }

        if ($audio_video_flag === "video") {
            $card_html = '<div class="uk-card uk-card-body boxes-wrap__boxes-inner-wrap__box overlay video-box video--bg3 border-0" style="' . $desktop_styles . '">
                    <div class="boxes-wrap__video-box-wrap__video-hd">
                    
                        <div class="video-btn"><a href="' . esc_url($video_url) . '"><svg class="icon icon-video">
                        <use xlink:href="#icon-video"></use>
                    </svg></a>
                        </div>
                    <div>
                    <div class="boxes-wrap__boxes-inner-wrap__topic white--txt">' . __("Video", "kmag") . '</div>
                        <a class="boxes-wrap__boxes-inner-wrap__topic-hd m-h1 white--txt"
                    href="' . esc_url($video_url) . '">' . esc_html(strip_tags($video_title)) . '</a>
                    </div>
                    </div>
                        <div class="boxes-wrap__boxes-inner-wrap__go-btn white--txt boxes-wrap__boxes-inner-wrap__go-btn-white">
                        <a href="' . esc_url($video_url) . '">' . __("Go", "kmag") . '<svg class="icon icon-arrow-go-white">
                        <use xlink:href="#icon-arrow-go-white"></use></svg></a>
                    </div>
                    <a href="' . esc_url($video_url) . '" class="fill-div"></a>
                </div>';
        } elseif ($audio_video_flag === "audio") {

            // Audios
            $audio_data = ACF::getPostMeta($id);
            $audio_title = get_the_title($id);
            $audio_url = get_permalink($id);
            $audio_body = ACF::getField('article_body', $audio_data);

            if (strlen($audio_body) > 75) {
                $audio_body = mb_strimwidth($audio_body, 0, 75, '...');
            }

            $card_html = '<div
            class="uk-card uk-card-body boxes-wrap__boxes-inner-wrap__box listen-now-box border-0 gradiant-green">
            <div class="boxes-wrap__boxes-inner-wrap__topic">' . __("Audio", "kmag") . '</div>
            <a class="boxes-wrap__boxes-inner-wrap__topic-hd m-h1"
                href="' . esc_url($audio_url) . '">' . esc_html(strip_tags($audio_title)) . '</a>
    
            <div class="audio-btn"><a href="' . esc_url($audio_url) . '"><svg class="icon icon-audio">
            <use xlink:href="#icon-audio"></use>
            </svg></a>
            </div>
            <div class="boxes-wrap__boxes-inner-wrap__go-btn"><a
                    href="' . esc_url($audio_url) . '">' . __("Listen Now", "kmag") . '<svg class="icon icon-arrow-go-hearty-green">
                    <use xlink:href="#icon-arrow-go-hearty-green"></use>
                </svg></a>
            </div>
            <a href="' . esc_url($audio_url) . '" class="fill-div"></a>
        </div>';
        }

        return $card_html;
    }


    // Documents and Labels Card Html
    public function getDocumentsCardHtml($id)
    {
        $document = get_post($id);

        $document_label_data = ACF::getPostMeta($id);
        $document_label_title = get_the_title($id);
        $document_label_url = get_permalink($id);
        $document_label_body = ACF::getField('article_body', $document_label_data);

        $document_label_data_type = get_post_type($id);

        $document_label_data_type_label = "";

        switch ($document_label_data_type) {
            case "ghs-label":
                $document_label_data_type_label = "GHS Label";
                break;
            case "spec-sheets":
                $document_label_data_type_label = "Technical Data Sheet";
                break;
            case "directions-for-use":
                $document_label_data_type_label = "Directions For Use";
                break;
            case "sds-pages":
                $document_label_data_type_label = "Safety Data Sheet";
                break;
        }

        if (strlen($document_label_body) > 75) {
            $document_label_body = mb_strimwidth($document_label_body, 0, 75, '...');
        }

        // getting the logo
        $product_terms = $document->products ?? get_the_terms($id, 'performance-product');
        $product_terms_slugs = [];
        $product_icon_html = '';
        if ($product_terms && count($product_terms) > 0) {
            $product_terms_slugs = array_map(function ($term) {
                return $term->slug;
            }, $product_terms);
            $product_icon_html = Util::getIconHTML($product_terms[0]->slug);
        }

        $card_html = '<div
                class="uk-card uk-card-body boxes-wrap__boxes-inner-wrap__box boxes-wrap__boxes-inner-wrap__documents-labels-box p-0">
                <div class="boxes-wrap__boxes-inner-wrap__topic">' . __($document_label_data_type_label, "kmag") . '</div>
                <div class="padding-wrap">
                    <div class="boxes-wrap__boxes-inner-wrap__documents-logo">' . $product_icon_html . '</div>
                    <div class="boxes-wrap__boxes-inner-wrap__topic-hd">
                        <a class="boxes-wrap__boxes-inner-wrap__topic-hd m-h1"
                            href="' . esc_url($document_label_url) . '">' . esc_html(strip_tags($document_label_title)) . '</a>
                    </div>
                    <div class="boxes-wrap__boxes-inner-wrap__go-btn"><a
                            href="' . esc_url($document_label_url) . '">' . __("Go", "kmag") . '<svg class="icon icon-arrow-go-hearty-green">
                            <use xlink:href="#icon-arrow-go-hearty-green"></use>
                        </svg></a>
                    </div>
                </div>
                <a href="' . esc_url($document_label_url) . '" class="fill-div"></a>
            </div>';

        return $card_html;
    }


    // Success Story Card Html
    public function getSuccessStoryCardHtml($id)
    {
        $success_story_data = ACF::getPostMeta($id);
        $success_story_title = get_the_title($id);
        $success_story_url = get_permalink($id);
        $success_story_body = ACF::getField('article_body', $success_story_data);

        if (strlen($success_story_body) > 75) {
            $success_story_body = mb_strimwidth($success_story_body, 0, 75, '...');
        }

        $card_html = '<div
                        class="uk-card uk-card-body boxes-wrap__boxes-inner-wrap__box boxes-wrap__boxes-inner-wrap__success-story-box border-0 gradiant-green">
                        <div class="boxes-wrap__boxes-inner-wrap__topic white--txt">' . __("Success Story", "kmag") . '</div>
                        <a class="boxes-wrap__boxes-inner-wrap__topic-hd m-h1 white--txt"
                            href="' . esc_url($success_story_url) . '">' . esc_html(strip_tags($success_story_title)) . '</a>
                        <div
                            class="boxes-wrap__boxes-inner-wrap__go-btn white--txt boxes-wrap__boxes-inner-wrap__go-btn-white">
                            <a
                                href="' . esc_url($success_story_url) . '">' . __("Go", "kmag") . '<svg class="icon icon-arrow-go-white">
                                <use xlink:href="#icon-arrow-go-white"></use></svg></a>
                        </div>
                        <a href="' . esc_url($success_story_url) . '" class="fill-div"></a>

                    </div>';

        return $card_html;
    }


    // search results Html
    public function getSearchResults($value)
    {
        $this->global_site_search_array = $value;

        $global_site_search_array = $this->global_site_search_array;

        $search_category_param = $global_site_search_array['search_category_param'];
        $has_search_category_params = $global_site_search_array['has_search_category_params'];
        $search_query = $global_site_search_array['search_query'];
        $has_search_query = $global_site_search_array['has_search_query'];
        $is_ajax_loadmore_request = $global_site_search_array['is_ajax_loadmore_request'];


        $page_num = isset($global_site_search_array['page_num']) ? $global_site_search_array['page_num'] : 1;

        $all_filter_groups_combined_array = [];
        $all_filter_groups_combined_array["relation"] = "AND";


        if ($has_search_query) {

            if ($has_search_category_params) { // if resource type is present, display cards

                if ($is_ajax_loadmore_request == "yes") {
                    $result_html = "";
                } else {
                    $result_html = '<div class="ss-cards-wrapper">';
                }

                $post_types_arg = "";

                switch ($search_category_param) {
                    case "products":
                        $post_types_arg = "performance-products";
                        break;
                    case "documents":
                        $post_types_arg = array("ghs-label", "spec-sheets", "directions-for-use", "sds-pages");
                        break;
                    case "agrifacts":
                        $post_types_arg = "agrifacts";
                        break;
                    case "resources":
                        $post_types_arg = array("standard-articles", "robust-articles", "calculators", "agrisights", "video-articles", "success-story");
                        break;
                    case "more":
                        $post_types_arg = "page";
                        break;
                }

                // Initializing values for query args
                $args = [
                    'posts_per_page' => ARCHIVE_RESULTS_PER_PAGE, // todo
                    'orderby' => "rand",
                    'post_status' => 'publish',
                    'post_type' => $post_types_arg,
                    'paged' => $page_num,
                    's' => $search_query
                ];

                $site_search_query = new \WP_Query($args);

                $results_count = $site_search_query->found_posts;

                if ($site_search_query->have_posts()) {

                    while ($site_search_query->have_posts()) {

                        $site_search_query->the_post();
                        $post_type = get_post_type();
                        $post_id = get_the_ID();

                        switch ($post_type) {

                                // Standard Article ==================================================
                            case "standard-articles":
                            case "page":

                                $standard_article_card_html = $this->getStandardArticleCardHtml($post_id);

                                $result_html .= $standard_article_card_html;

                                break;


                                // RObust Articles / Trending Topics ===============================
                            case "robust-articles":

                                $robust_article_card_html = $this->getRobustArticleCardHtml($post_id);

                                $result_html .= $robust_article_card_html;

                                break;

                                // Agrisights ==================================================
                            case "agrisights":

                                $agrisight_card_html = $this->getAgrisightCardHtml($post_id);

                                $result_html .= $agrisight_card_html;

                                break;

                                // Agrifacts ==================================================
                            case "agrifacts":

                                $agrifact_card_html = $this->getAgrifactCardHtml($post_id);

                                $result_html .= $agrifact_card_html;

                                break;

                                // Video & Audio Articles ==========================================
                            case "video-articles":

                                $audio_video_card_html = $this->getAudioVideoCardHtml($post_id);

                                $result_html .= $audio_video_card_html;

                                break;

                                // Document & Labels ==================================================
                            case "documents":
                            case "ghs-label":
                            case "spec-sheets":
                            case "directions-for-use":
                            case "sds-pages":

                                $documents_card_html = $this->getDocumentsCardHtml($post_id);

                                $result_html .= $documents_card_html;

                                break;

                                // Success Story ==================================================

                            case "success-story":

                                $success_story_card_html = $this->getSuccessStoryCardHtml($post_id);

                                $result_html .= $success_story_card_html;

                                break;

                                // Calculators  ==================================================

                            case "calculators":

                                $calculator_card_html = $this->getCalculatorCardHtml($post_id);

                                $result_html .= $calculator_card_html;

                                break;

                            default:
                                $result_html .= "";
                        }
                    }

                    if ($site_search_query->post_count >= $args['posts_per_page']) {

                        $result_html .= '<div class="load-more-wrapper"><a href="#" class="load-more-button" data-page="1">' . __('View More', 'kmag') . '</a></div>';
                    }

                    wp_reset_query();
                }

                if ($is_ajax_loadmore_request != "yes") {
                    $result_html .= '</div>';
                }

                $this->setSearchCountGlobally($results_count);

                $output = [
                    'results_html' => $result_html,
                    'results_count' => $results_count
                ];
            } else { // if resource type is NOT there, categorywise search results

                //setup for simple search
                $results_html = "";
                $results_count = 0;

                // ===================================================
                // Performance section
                // ===================================================

                $performace_products_post_types = array("performance-products");

                $performace_products_args = array(
                    'post_type' => $performace_products_post_types,
                    'post_status' => 'publish',
                    'posts_per_page' => 6,
                    's' => $search_query,
                    'orderby' => 'rand'
                );

                $performace_products_query = new \WP_Query($performace_products_args);

                $performace_products_count = $performace_products_query->found_posts;

                $results_count = $results_count + $performace_products_count;

                $viewAllLink = '';

                if ($performace_products_count > 6) {
                    $viewAllLink = '<a class="category-results" href="?q=' . esc_html($search_query) . '&searchCategory=performance-products">' . __("View All", "kmag") . '
                        <svg class="icon icon-arrow-go-hearty-green">
                            <use xlink:href="#icon-arrow-go-hearty-green  "></use>
                        </svg></a>';
                }

                if ($performace_products_query->have_posts()) {

                    $performance_product_cards = "";

                    foreach ($performace_products_query->posts as $performance_product) {
                        $performance_product_cards .= $this->getPerformanceProductCard($performance_product->ID);
                    }

                    $perfromance_product_results_html = '<section class="rl-default-content__performance-products-sec rl-default-content__rl-section">
                        <div class="container"><h2 class="heading2">' . __("Products", "kmag") . '<span class="view-btn">' .
                        $viewAllLink
                        . '</span>
                            </h2><div class="boxes-wrap">
                                <div class="boxes-wrap__boxes-inner-wrap uk-grid  uk-grid-small uk-grid-match boxes-wrap__performance-products-box-wrap">' .
                        $performance_product_cards
                        . '</div>
                            </div>
                        </div>
                    </section>';

                    $results_html .= $perfromance_product_results_html;

                    wp_reset_query();
                }

                // ===================================================
                // Documents & labels section
                // ===================================================

                $document_labels_post_types = array("ghs-label", "spec-sheets", "directions-for-use", "sds-pages");


                $document_labels_args = array(
                    'post_type' => $document_labels_post_types,
                    'post_status' => 'publish',
                    'posts_per_page' => 6,
                    's' => $search_query,
                    'orderby' => 'rand'
                );

                $document_labels_query = new \WP_Query($document_labels_args);

                $document_labels_count = $document_labels_query->found_posts;

                $results_count = $results_count + $document_labels_count;

                $viewAllLink = '';

                if ($document_labels_count > 6) {
                    $viewAllLink = '<a  href="?q=' . esc_html($search_query) . '&searchCategory=documents">' . __("View All", "kmag") . '
                        <svg class="icon icon-arrow-go-hearty-green">
                            <use xlink:href="#icon-arrow-go-hearty-green  "></use>
                        </svg></a>';
                }

                if ($document_labels_query->have_posts()) {

                    $document_cards = "";

                    foreach ($document_labels_query->posts as $document_label) {
                        $document_cards .= $this->getDocumentsCardHtml($document_label->ID);
                    }

                    $document_results_html = '<section class="rl-default-content__documents-labels-sec  rl-default-content__rl-section">
                        <div class="container"><h2 class="heading2">' . __("Documents & Labels", "kmag") . '<span class="view-btn">' .
                        $viewAllLink
                        . '</span>
                            </h2><div class="boxes-wrap">
                                <div class="boxes-wrap__boxes-inner-wrap uk-grid  uk-grid-small uk-grid-match boxes-wrap__documents-labels-box-wrap">' .
                        $document_cards
                        . '</div>
                            </div>
                        </div>
                    </section>';

                    $results_html .= $document_results_html;

                    wp_reset_query();
                }

                // ===================================================
                // Agrifacts section
                // ===================================================

                $agrifacts_args = array(
                    'post_type' => 'agrifacts',
                    'post_status' => 'publish',
                    'posts_per_page' => 6,
                    's' => $search_query,
                    'orderby' => 'rand'
                );
                $agrifacts_query = new \WP_Query($agrifacts_args);

                $agrifacts_count = $agrifacts_query->found_posts;

                $results_count = $results_count + $agrifacts_count;

                $viewAllLink = '';

                if ($agrifacts_count > 6) {
                    $viewAllLink = '<a href="?q=' . esc_html($search_query) . '&searchCategory=agrifacts">' . __("View All", "kmag") . '
                                <svg class="icon icon-arrow-go-hearty-green">
                                    <use xlink:href="#icon-arrow-go-hearty-green"></use>
                                </svg>
                            </a>';
                }

                if ($agrifacts_query->have_posts()) {
                    $agrifact_cards = "";

                    foreach ($agrifacts_query->posts as $fact) {
                        $agrifact_cards .= $this->getAgrifactCardHtml($fact->ID);
                    }

                    $agrifact_results_html = ' <section class="rl-default-content__agrifacts-sec  rl-default-content__rl-section">
                        <div class="container"><h2 class="heading2">' . __("AgriFacts", "kmag") . '<span class="view-btn">' .
                        $viewAllLink
                        . '</span>
                            </h2><div class="boxes-wrap">
                                <div class="boxes-wrap__boxes-inner-wrap uk-grid  uk-grid-small uk-grid-match boxes-wrap__agrifacts-box-wrap">' .
                        $agrifact_cards
                        . '</div>
                                </div>
                            </div>
                        </section>';

                    $results_html .= $agrifact_results_html;

                    wp_reset_query();
                }

                // ===================================================
                // Resources
                // ===================================================
                //All resources that are not “Documentation and Labels”, or Agrifacts

                $resources_post_types = array("standard-articles", "robust-articles", "calculators", "agrisights", "video-articles", "success-story");


                $resources_args = array(
                    'post_type' => $resources_post_types,
                    'post_status' => 'publish',
                    'posts_per_page' => 6,
                    's' => $search_query,
                    'orderby' => 'rand'
                );
                $resources_query = new \WP_Query($resources_args);

                $resources_count = $resources_query->found_posts;

                $results_count = $results_count + $resources_count;

                $viewAllLink = '';

                if ($resources_count > 6) {
                    $viewAllLink = '<a class="category-results" href="?q=' . esc_html($search_query) . '&searchCategory=resources"><span class="view-all-desktop">' . __("See All Category Matches", "kmag") . '</span><span class=view-all-mobile>' . __("View All", "kmag") . '</span>
                        <svg class="icon icon-arrow-go-hearty-green">
                            <use xlink:href="#icon-arrow-go-hearty-green"></use>
                        </svg></a>';
                }

                if ($resources_query->have_posts()) {
                    $resources_cards = "";

                    foreach ($resources_query->posts as $resource) {

                        $post_type = get_post_type($resource->ID);

                        switch ($post_type) {

                            case "robust-articles":
                                $resources_cards .= $this->getRobustArticleCardHtml($resource->ID);
                                break;
                            case "calculators":
                                $resources_cards .= $this->getCalculatorCardHtml($resource->ID);
                                break;
                            case "agrisights":
                                $resources_cards .= $this->getAgrisightCardHtml($resource->ID);
                                break;
                            case "video-articles":
                                $resources_cards .= $this->getAudioVideoCardHtml($resource->ID);
                                break;

                            case "success-story":
                                $resources_cards .= $this->getSuccessStoryCardHtml($resource->ID);
                                break;
                            case "standard-articles":
                            case "default":
                                $resources_cards .= $this->getStandardArticleCardHtml($resource->ID);
                                break;
                        }
                    }

                    $resources_results_html = '<section class="rl-default-content__agrifacts-sec  rl-default-content__rl-section">
                        <div class="container"><h2 class="heading2">' . __("Resources", "kmag") . '<span class="view-btn">' .
                        $viewAllLink
                        . '</span>
                            </h2><div class="boxes-wrap">
                            <div class="boxes-wrap__boxes-inner-wrap boxes-wrap__articles-box-wrap uk-grid  uk-grid-small uk-grid-match">' .
                        $resources_cards
                        . '</div>
                                </div>
                            </div>
                        </section>';

                    $results_html .= $resources_results_html;

                    wp_reset_query();
                }

                // ===================================================
                // More
                // ===================================================

                $core_pages_args = array(
                    'post_type' => 'page',
                    'post_status' => 'publish',
                    'posts_per_page' => 6,
                    's' => $search_query,
                    'orderby' => 'rand'
                );
                $core_pages_query = new \WP_Query($core_pages_args);

                $core_pages_count = $core_pages_query->found_posts;

                $results_count = $results_count + $core_pages_count;

                $viewAllLink = '';

                if ($core_pages_count > 6) {
                    $viewAllLink = '<a class="category-results" href="?q=' . esc_html($search_query) . '&searchCategory=more"><span class="view-all-desktop">' . __("See All Category Matches", "kmag") . '</span><span class=view-all-mobile>' . __("View All", "kmag") . '</span>
                        <svg class="icon icon-arrow-go-hearty-green">
                            <use xlink:href="#icon-arrow-go-hearty-green"></use>
                        </svg></a>';
                }

                if ($core_pages_query->have_posts()) {
                    $core_pages_cards = "";

                    foreach ($core_pages_query->posts as $page) {
                        $core_pages_cards .= $this->getPageCardHtml($page->ID);
                    }

                    $core_pages_results_html = '<section class="rl-default-content__agrifacts-sec  rl-default-content__rl-section">
                        <div class="container"><h2 class="heading2">' . __("More", "kmag") . '<span class="view-btn">' .
                        $viewAllLink
                        . '</span>
                            </h2><div class="boxes-wrap">
                            <div class="boxes-wrap__boxes-inner-wrap boxes-wrap__articles-box-wrap uk-grid  uk-grid-small uk-grid-match">' .
                        $core_pages_cards
                        . '</div>
                                </div>
                            </div>
                        </section>';

                    $results_html .= $core_pages_results_html;

                    wp_reset_query();
                }


                $this->setSearchCountGlobally($results_count);

                $output = [
                    'results_html' => $results_html,
                    'results_count' => $results_count
                ];
            }
        }

        return $output;
    }

    //default state html
    public function setSearchCountGlobally($results_count)
    {
        $this->global_site_search_array['results_count'] = $results_count;
    }

    // Search and Filter main function
    public function getSiteSearchFormHtml()
    {
        // search query related variables
        $search_query = filter_input(INPUT_GET, 'q', FILTER_SANITIZE_SPECIAL_CHARS);
        $has_search_query = (isset($search_query) && !empty($search_query)) ? true : false;

        $global_site_search_array = $this->global_site_search_array;

        $search_category_param = $global_site_search_array['search_category_param'];
        $has_search_category_params = $global_site_search_array['has_search_category_params'];

        if ($has_search_query) {
            $search_close_icon_class = "show";
            $search_icon_class = "hide";
        } else {
            $search_close_icon_class = "hide";
            $search_icon_class = "show";
        }

        $this->cnSiteSearchScripts();

        ob_start(); ?>

        <div id="ss-search-container" class="prevent-select" data-form="site-search">
            <form action="" method="get">

                <div class="search-box">
                    <div class="search-input">
                        <input name="s" id="ss-search" value="<?php echo esc_html($search_query) ?>" class="ss-search-bar" placeholder="<?php echo __("Search Advanced K-Mag, Resources & More", "kmag") ?>">
                        <div class="search-close-icon-wrapper <?php echo $search_close_icon_class ?>">
                            <input type="button" class="close-icon" name="closebtn" value="">
                            <svg class="icon icon-close-search">
                                <use xlink:href="#icon-close-search"></use>
                            </svg>
                        </div>
                        <div class="search-icon-wrapper <?php echo $search_icon_class ?>">
                            <input type="submit" class="search-submit-btn search-icon show" name="submit" value="">
                            <svg class="icon icon-search">
                                <use xlink:href="#icon-search"></use>
                            </svg>
                        </div>
                        <div class="validation-msg"></div>
                    </div>

                    <?php if ($global_site_search_array['results_count'] > 0 && ($has_search_query || $has_search_category_params)) {

                        $category_text = "";

                    ?>

                        <?php if ($has_search_category_params) {

                            $labelText = "";

                            switch ($search_category_param) {
                                case "products":
                                    $labelText = "Products";
                                    break;
                                case "documents":
                                    $labelText = "Documentation & Labels";
                                    break;
                                case "agrifacts":
                                    $labelText = "AgriFacts";
                                    break;
                                case "resources":
                                    $labelText = "Resources";
                                    break;
                                case "more":
                                    $labelText = "More";
                                    break;
                            }

                            $category_text = 'in "' . $labelText . '" category';
                        } ?>

                        <div class="ss-results-info-wrapper">
                            <div class="results-count">
                                <?php echo $global_site_search_array['results_count'] . " " . __("Results for ", "kmag") . '"' . esc_html($search_query) . '" ' . $category_text; ?>

                            </div>
                        </div>

                    <?php } elseif ($global_site_search_array['results_count'] == 0  && ($has_search_query)) { ?>
                        <div class="ss-results-info-wrapper">
                            <div class="results-count">
                                <?php echo __("No Results found for ", "kmag") . '"' . esc_html($search_query) . '"'; ?></div>
                        </div>
                    <?php } ?>

                </div>
            </form>
        </div>



<?php

        return ob_get_clean();
    }


    // Scripts for Ajax Filter Search
    public function cnSiteSearchScripts()
    {
        wp_localize_script('cn-theme', 'ajax_info', array(
            'ajax_url' => admin_url('admin-ajax.php')
        ));
    }

    // ajax callback
    public function cn_ajax_site_search_callback()
    {

        header("Content-Type: application/json");

        $this->setGlobalSiteSearchArray();

        $global_site_search_array = $this->global_site_search_array;

        $resultsOutput = $this->getSearchResults($global_site_search_array);
        $filterOutputHtml = $this->getSiteSearchFormHtml($global_site_search_array);

        echo json_encode(array(
            'results_html' => $resultsOutput['results_html'],
            'searchbox_html' => $filterOutputHtml,
            'results_count' => $resultsOutput['results_count']
        ));

        wp_die();
    }
}
