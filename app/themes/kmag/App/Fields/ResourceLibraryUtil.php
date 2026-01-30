<?php

namespace CN\App\Fields;

use CN\App\Media;
use CN\App\Fields\ACF;
use CN\App\Fields\Util;
use CN\App\Interfaces\WordPressHooks;
use Extended\ACF\Fields\Group;
use Extended\ACF\Fields\PostObject;
use Extended\ACF\Fields\Relationship;
use Extended\ACF\Fields\Select;
use Extended\ACF\Location;

/**
 * Class ResourceLibraryUtil
 *
 * @package CN\App\Fields
 */
class ResourceLibraryUtil implements WordPressHooks
{

    var $global_resource_library_array;

    public function __construct()
    {
        $this->setGlobalResourceLibraryArray();
    }

    /**
     * Add class hooks.
     */
    public function addHooks()
    {
        add_action('wp_enqueue_scripts', [$this, 'cnSearchFilterScripts']);
        add_action('acf/init', [$this, 'setUpResourceLibraryACF']);

        // Ajax Callback
        add_action('wp_ajax_cn_ajax_filter_search', [$this, 'cn_ajax_filter_search_callback']);
        add_action('wp_ajax_nopriv_cn_ajax_filter_search', [$this, 'cn_ajax_filter_search_callback']);
    }

    /**
     * Return Nutrient terms as [{ id: slug, label: name, count: term.count }]
     */
    private function getNutrientFilterItems(): array {
        $terms = get_terms([
            'taxonomy'   => 'nutrients-tag',
            'hide_empty' => true, // or false, if you want to show all even with 0 posts
        ]);

        if (is_wp_error($terms) || empty($terms)) return [];

        $items = [];
        foreach ($terms as $t) {
            $items[] = [
                'id'    => $t->slug,     // IMPORTANT: use slug as the stable id/value
                'label' => $t->name,
                'count' => (int) $t->count,
            ];
        }
        // Optional: sort alphabetically
        usort($items, fn($a, $b) => strcasecmp($a['label'], $b['label']));
        return $items;
    }



    public function setGlobalResourceLibraryArray()
    {
        // get all performance products posts
        $performance_products_query = new \WP_Query([
            'post_type' => 'performance-products',
            'posts_per_page' => -1,
            'order' => 'ASC'
        ]);

        $performance_products_array = [];
        if ($performance_products_query->have_posts()) {
            foreach ($performance_products_query->posts as $product) {
                $meta = ACF::getPostMeta($product->ID);
                $performance_products_array[$product->post_name] = array(
                    'slug' => $product->slug,
                    'name' => ACF::getField('name', $meta, ''),
                    'black-logo' => ACF::getField('black-logo', $meta, ''),
                );
            }
        }


        // setting tags related variables
        $tags_values = filter_input(INPUT_GET, 'tags', FILTER_SANITIZE_SPECIAL_CHARS);
        $tags_param_array = isset($tags_values) ? explode(',', $tags_values) : [];
        $has_tags_params = (isset($tags_values) && !empty($tags_values)) ? true : false;

        // resource type related variables
        $resource_type_values = filter_input(INPUT_GET, 'resourceType', FILTER_SANITIZE_SPECIAL_CHARS);
        $resource_type_param_array = isset($resource_type_values) ? explode(',', $resource_type_values) : [];
        $has_resource_type_params = (($resource_type_values) && !empty($resource_type_values)) ?  true : false;

        // search query related variables
        $search_query = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_SPECIAL_CHARS);
        $has_search_query = (isset($search_query) && !empty($search_query)) ? true : false;

        // ajax search request
        $get_action_param = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_SPECIAL_CHARS);
        $is_ajax_search_request = ($get_action_param === "cn_ajax_filter_search");

        // ajax clearall request
        $get_clearall_param = filter_input(INPUT_GET, 'clearall', FILTER_SANITIZE_SPECIAL_CHARS);
        $is_ajax_clearall_request = ($get_clearall_param === "yes") ? true : false;

        // results count
        $results_count = 0;

        // global crop cookie
        $is_global_crop_cookie_set = (isset($_COOKIE['crop_cookie']) && !empty($_COOKIE['crop_cookie'])) ? true : false;

        $global_crop_cookie_value = $is_global_crop_cookie_set ? $_COOKIE['crop_cookie'] : '';
        $global_crop_cookie_value_title = "";

        $filters_group_array = RESOURCE_LIBRARY_FILTERS;

        foreach ($filters_group_array as $filer_group) {
            foreach ($filer_group['filters'] as $filter) {
                if ($filer_group['id'] === 'crops') {
                    if ($filter['id'] === $global_crop_cookie_value) {
                        $global_crop_cookie_value_title = $filter['value'];
                    }
                }
            }
        }

        $global_resource_library_array = array(
            'tags_param_array' => $tags_param_array,
            'has_tags_params' => $has_tags_params,
            'resource_type_param_array' => $resource_type_param_array,
            'has_resource_type_params' => $has_resource_type_params,
            'search_query' => $search_query,
            'has_search_query' => $has_search_query,
            'is_ajax_search_request' => $is_ajax_search_request,
            'is_ajax_clearall_request' => $is_ajax_clearall_request,
            'results_count' => $results_count,
            'global_crop_cookie_value' => $global_crop_cookie_value,
            'global_crop_cookie_value_title' => $global_crop_cookie_value_title,
            'is_global_crop_cookie_set' => $is_global_crop_cookie_set,
            'performance_products' => $performance_products_array
        );

        $this->global_resource_library_array = $global_resource_library_array;
    }

    //get global resource library array
    public function getGlobalResourceLibraryArray()
    {
        $global_resource_library_array = $this->global_resource_library_array;
        return $global_resource_library_array;
    }


    // get trimmed text
    public function getTrimmedText($text, $chars)
    {
        return mb_strimwidth($text, 0, $chars, '...');
    }

    // Standard Article Card
    public  function getStandardArticleCardHtml($id)
    {
        $article_data = ACF::getPostMeta($id);
        $article_title = get_the_title($id);
        $article_url = get_permalink($id);
        $article_body = ACF::getField('article_excerpt', $article_data);
        $card_html = '';

        if (strlen($article_body) > 75) {
            $article_body = $this->getTrimmedText($article_body, 75);
        }

        $card_html = '
    <div class="uk-card uk-card-body boxes-wrap__boxes-inner-wrap__box1 boxes-wrap__boxes-inner-wrap__articles-box">
            <div class="boxes-wrap__boxes-inner-wrap__topic">' . __("Article", "kmag") . '
            </div>
            <a class="uk-card-title boxes-wrap__boxes-inner-wrap__topic-hd" href="' . esc_url($article_url) . '">'
            . esc_html(strip_tags($article_title)) . '</a>
    <div class="boxes-wrap__boxes-inner-wrap__topic-desc">' . esc_html(strip_tags(strip_tags($article_body))) . '</div>
    <div class="boxes-wrap__boxes-inner-wrap__go-btn"><a href="' . esc_url($article_url) . '">' . __("Go", "kmag") . '<svg class="icon icon-arrow-go-hearty-green">
    <use xlink:href="#icon-arrow-go-hearty-green"></use>
    </svg></a>
    </div>
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
    class="uk-card uk-card-body boxes-wrap__boxes-inner-wrap__box1 overlay boxes-wrap__boxes-inner-wrap__trending-topic-box border-0" style="' . $desktop_styles . '">
    <div class="boxes-wrap__boxes-inner-wrap__topic white--txt">' . __("Trending Topic", "kmag") . '</div>
    <a href="' . esc_url($trending_topic_url) . '" class="boxes-wrap__boxes-inner-wrap__topic-hd m-h1 white--txt">' . esc_html(strip_tags($trending_topic_title)) . '</a>
    <div class="boxes-wrap__boxes-inner-wrap__go-btn white--txt boxes-wrap__boxes-inner-wrap__go-btn-white">
    <a href="' . esc_url($trending_topic_url) . '">' . __("Go", "kmag") . '<svg class="icon icon-arrow-go-white">
    <use xlink:href="#icon-arrow-go-white"></use></svg></a>
    </div>
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

        // unit is the unit string after the big number
        if (isset($yield_stats[0])) {
            $fact_data['unit'] = esc_html($yield_stats[0]['unit'] ?? '-');
        } else {
            $fact_data['unit'] = "";
        }

        // amount is the Big Number before the units
        if (isset($yield_stats[0])) {
            $fact_data['amount'] = esc_html($yield_stats[0]['amount'] ?? '-');
        } else {
            $fact_data['amount'] = "";
        }

        // description is the small print description under the title
        if (isset($yield_stats[0])) {
            $fact_data['description'] = $yield_stats[0]['description'] ? esc_html($yield_stats[0]['description']) : "";
        } else {
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
        $product_terms = has_term('', 'performance-product', $id) ? wp_get_object_terms($id, 'performance-product', array("order" => "ASC", 'orderby' => 'term_id')) : [];
        $product_icon_html = '';

        $product_slugs = array_map(function ($term) {
            return $term->slug;
        }, $product_terms);
        foreach ($product_slugs as $product_name) {
            $product = $this->getGlobalResourceLibraryArray()['performance_products'][$product_name] ?? null;
            if (!is_null($product_name) && !is_null($product)) {
                $product_logo_id = $product['black-logo'];
                // get image from $product_logo_id
                $product_logo_image = wp_get_attachment_image_src($product_logo_id, 'full');
                if ($product_logo_image) {
                    $product_icon_html = '<img class="icon icon-performance-product" src="' . esc_html($product_logo_image[0]) . '" alt="product logo" />';
                }
            }
        }

        $card_html = '<div class="uk-card uk-card-body boxes-wrap__boxes-inner-wrap__box1 agrifacts-box">
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
    <div class="uk-card uk-card-body boxes-wrap__boxes-inner-wrap__box1 agrisight-box border-0">
    <div class="boxes-wrap__boxes-inner-wrap__topic icon-wrapper"><svg class="icon icon-agrisight-trimmed" aria-hidden="true">
    <use xlink:href="#icon-agrisight-trimmed"></use>
    </svg></div>
    <a class="boxes-wrap__boxes-inner-wrap__topic-hd" href="' . esc_url($agrisight_url) . '">' . esc_html(strip_tags($agrisight_title)) . '</a>
    <div class="boxes-wrap__boxes-inner-wrap__topic-desc">
    ' . esc_html(strip_tags($agrisight_body)) . '</div>
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

        $paths = ['microessentials' => 'microessentials-roi-calculator', 'aspire' => 'aspire-roi-calculator', 'nutrient' => 'nutrient-removal-calculator', 'retail-value' => 'retail-value-calculator', 'bio-calculator' => 'powercoat-impregnation-calculator-request-form'];

        $calculator_html = '<div class="uk-card uk-card-body boxes-wrap__boxes-inner-wrap__box1 calculator-box ' . esc_html($calculator) . '">
                                <h2>' . esc_html($title) . '</h2>
                                <div class="uk-grid-collapse uk-child-width-1-2@m column-wrapper" uk-grid>
                                    <div class="left-side  ' . esc_html($calculator) . '-calculator">
                                        <p class="paragraph">' . esc_html($description) . '</p>';

        if ($calculator === 'retail-value') {
            $calculator_html .= '<a class="calculator-btn" href="' . esc_url($link['url']) . '">
                                                ' . __('Request access', 'kmag') . '
                                                <svg class="icon icon-arrow-right">
                                                    <use xlink:href="#icon-arrow-right"></use>
                                                </svg>
                                            </a>';
        } else if ($calculator === 'bio-calculator') {
            $calculator_html .= '<a class="calculator-btn" href="/' . $paths[$calculator] . '/">
                                                ' . __('Request access', 'kmag') . '
                                                <svg class="icon icon-arrow-right">
                                                    <use xlink:href="#icon-arrow-right"></use>
                                                </svg>
                                            </a>';
        } else {
            $calculator_html .= '<a class="calculator-btn" href="/resource-library/' . $paths[$calculator] . '/">
                                                ' . __('Calculate', 'kmag') . '
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
        } else if ($calculator === 'retail-value') {
            $calculator_html .= '<div class="icon-wrapper">
                                        <div class="inner-wrapper retail-value-icon">
                                            <svg class="icon icon-microessentials">
                                                <use xlink:href="#icon-microessentials"></use>
                                            </svg>
                                            <p>' . __('Retail Value Calculator', 'kmag') . '</p>
                                        </div>
                                    </div>';
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

        if ($calculator === 'retail-value') {
            $calculator_html .= '<a class="calculator-btn" href="' . esc_url($link['url']) . '">
                                        ' . __('Request access', 'kmag') . '
                                        <svg class="icon icon-arrow-right">
                                            <use xlink:href="#icon-arrow-right"></use>
                                        </svg>
                                    </a>
                                    </div>
                                </div>
                            </div>';
        } else if ($calculator === 'bio-calculator') {
            $calculator_html .= '<a class="calculator-btn" href="/' . $paths[$calculator] . '/">
                                        ' . __('Request access', 'kmag') . '
                                        <svg class="icon icon-arrow-right">
                                            <use xlink:href="#icon-arrow-right"></use>
                                        </svg>
                                    </a>
                                    </div>
                                </div>
                            </div>';
        } else {
            $calculator_html .= '<a class="calculator-btn" href="/resource-library/' . $paths[$calculator] . '/">
                                        ' . __('Calculate', 'kmag') . '
                                        <svg class="icon icon-arrow-right">
                                            <use xlink:href="#icon-arrow-right"></use>
                                        </svg>
                                    </a>
                                    </div>
                                </div>
                            </div>';
        }

        return $calculator_html;
    }


    // TruResponse Trial Detail Card Html
    public function getTruResTrialDataCardHtml($id)
    {
        $meta = ACF::getPostMeta($id);

        $fact = get_post($id);

        $fact_data = [];


        $trial_data_topic = ACF::getField('trial-data-topic', $meta);
        $fact_data['description'] = esc_html($trial_data_topic);

        $trial_data_code = ACF::getField('trial-data-code', $meta);
        $trial_data_code = explode(" ", $trial_data_code);
        $fact_data['code-unit'] = esc_html($trial_data_code[0]);
        $fact_data['code-text'] = '';
        if (isset($trial_data_code[1])) {
            $fact_data['code-text'] = esc_html($trial_data_code[1]);
        }

        // title is the card's title
        $original_title = get_the_title($id);
        $trimmed_title = $this->getTrimmedText($original_title, 100);
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
        $product_terms = has_term('', 'performance-product', $id) ? get_the_terms($id, 'performance-product') : [];
        $product_icon_html = '';

        $product_slugs = array_map(function ($term) {
            return $term->slug;
        }, $product_terms);
        foreach ($product_slugs as $product_name) {
            $product = $this->getGlobalResourceLibraryArray()['performance_products'][$product_name] ?? null;
            if (!is_null($product_name) && !is_null($product)) {
                $product_logo_id = $product['black-logo'];
                // get image from $product_logo_id
                $product_logo_image = wp_get_attachment_image_src($product_logo_id, 'full');
                if ($product_logo_image) {
                    $product_icon_html = '<img class="icon icon-performance-product" src="' . esc_html($product_logo_image[0]) . '" alt="product logo" />';
                }
            }
        }
        $box_slug_class_suffix =  $product_terms && count($product_terms) > 0 ? $product_terms[0]->slug : 'no-product';

        $card_html = '<div class="uk-card uk-card-body boxes-wrap__boxes-inner-wrap__box1 trures-trial-data-box box-' . $box_slug_class_suffix . '">
            <div class="boxes-wrap__boxes-inner-wrap__topic-hd-wrap2">
                <div class="uk-grid uk-grid-large uk-child-width-1-2" uk-grid>
                    <div>
                        <svg class="icon icon-trial-data-small">
                            <use xlink:href="#icon-trial-data-small"></use>
                        </svg>
                    </div>

                    <div class="icon-align-right">
                        ' . $product_icon_html . '
                    </div>
                </div>
            </div>
            
            <div class="boxes-wrap__boxes-inner-wrap__topic-hd-wrap1">
                <div class="crop-icon-holder">
                    <svg class="icon icon-' . $crop_icon . '">
                        <use xlink:href="#icon-' . $crop_icon . '"></use>
                    </svg>
                </div>

                <div class="boxes-wrap__boxes-inner-wrap__topic-l">
                    <div class="boxes-wrap__boxes-inner-wrap__topic-hd">
                        <a class="boxes-wrap__boxes-inner-wrap__topic-hd" href="' . esc_url($fact_data['url']) . '">
                            ' . esc_html(strip_tags($fact_data["title"])) . '
                        </a>
                    </div>
                </div>
            </div>

            <div class="boxes-wrap__boxes-inner-wrap__topic-hd-wrap3">
                <div class="trures-space"></div>

                <div class="boxes-wrap__boxes-inner-wrap__topic-l">
                    <div class="boxes-wrap__boxes-inner-wrap__topic-hd">
                        <div class="boxes-wrap__boxes-inner-wrap__topic-code">
                            <p class="unit">' . esc_html(strip_tags($fact_data["code-unit"])) . '</p>
                            <p class="text">' . esc_html(strip_tags($fact_data["code-text"])) . '</p>
                        </div>
                        
                        <div class="boxes-wrap__boxes-inner-wrap__topic-desc">
                            ' . esc_html(strip_tags($fact_data["description"])) . '
                        </div>
                    </div>
                </div>
            </div>
            <a href="' . esc_url($fact_data['url']) . '" class="fill-div"></a>
        </div>';

        return $card_html;
    }

    // TruResponse Insights Card html
    public function getTruResInsightsCardHtml($id)
    {
        $trueres_insights_data = ACF::getPostMeta($id);
        $trueres_insights_title = get_the_title($id);
        $trueres_insights_url = get_permalink($id);
        $trueres_insights_body = strip_shortcodes(ACF::getField('article-body', $trueres_insights_data));

        if (strlen($trueres_insights_body) > 108) {
            $trueres_insights_body = mb_strimwidth($trueres_insights_body, 0, 108, '...');
        }

        $card_html = '<div class="uk-card uk-card-body boxes-wrap__boxes-inner-wrap__box1 trures-insights-box border-0">
            <div class="boxes-wrap__boxes-inner-wrap__topic icon-wrapper">
                <svg class="icon icon-insights-small" aria-hidden="true">
                    <use xlink:href="#icon-insights-small"></use>
                </svg>
            </div>

            <a class="boxes-wrap__boxes-inner-wrap__topic-hd" href="' . esc_url($trueres_insights_url) . '">
                ' . esc_html(strip_tags($trueres_insights_title)) . '
            </a>

            <div class="boxes-wrap__boxes-inner-wrap__topic-desc">
                ' . esc_html(strip_tags($trueres_insights_body)) . '
            </div>
        </div>';

        return $card_html;
    }


    // Audion / Video Card Html
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
            $card_html = '<div class="uk-card uk-card-body boxes-wrap__boxes-inner-wrap__box1 overlay video-box video--bg3 border-0" style="' . $desktop_styles . '">
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
            class="uk-card uk-card-body boxes-wrap__boxes-inner-wrap__box1 listen-now-box border-0 gradiant-green">
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
        $product_terms = has_term('', 'performance-product', $id) ?  get_the_terms($id, 'performance-product') : [];
        $product_icon_html = '';

        $product_slugs = array_map(function ($term) {
            return $term->slug;
        }, $product_terms);
        foreach ($product_slugs as $product_name) {
            $product = $this->getGlobalResourceLibraryArray()['performance_products'][$product_name] ?? null;
            if (!is_null($product_name) && !is_null($product)) {
                $product_logo_id = $product['black-logo'];
                // get image from $product_logo_id
                $product_logo_image = wp_get_attachment_image_src($product_logo_id, 'full');
                if ($product_logo_image) {
                    $product_icon_html = '<img class="icon icon-performance-product" src="' . esc_html($product_logo_image[0]) . '" alt="product logo" />';
                }
            }
        }

        $card_html = '<div
                class="uk-card uk-card-body boxes-wrap__boxes-inner-wrap__box1 boxes-wrap__boxes-inner-wrap__documents-labels-box p-0">
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
                        class="uk-card uk-card-body boxes-wrap__boxes-inner-wrap__box1 boxes-wrap__boxes-inner-wrap__success-story-box border-0 gradiant-green">
                        <div class="boxes-wrap__boxes-inner-wrap__topic white--txt">' . __("Success Story", "kmag") . '</div>
                        <a class="boxes-wrap__boxes-inner-wrap__topic-hd m-h1 white--txt"
                            href="' . esc_url($success_story_url) . '">' . esc_html(strip_tags($success_story_title)) . '</a>
                        <div
                            class="boxes-wrap__boxes-inner-wrap__go-btn white--txt boxes-wrap__boxes-inner-wrap__go-btn-white">
                            <a
                                href="' . esc_url($success_story_url) . '">' . __("Go", "kmag") . '<svg class="icon icon-arrow-go-white">
                                <use xlink:href="#icon-arrow-go-white"></use></svg></a>
                        </div>
                    </div>';

        return $card_html;
    }


    public function getSearchResults($value)
    {
        $this->global_resource_library_array = $value;

        $global_resource_library_array = $this->global_resource_library_array;

        $tags_param_array = $global_resource_library_array['tags_param_array'];
        $has_tags_params = $global_resource_library_array['has_tags_params'];
        $resource_type_param_array = $global_resource_library_array['resource_type_param_array'];
        $has_resource_type_params = $global_resource_library_array['has_resource_type_params'];
        $search_query = $global_resource_library_array['search_query'];
        $has_search_query = $global_resource_library_array['has_search_query'];
        $is_ajax_clearall_request = $global_resource_library_array['is_ajax_clearall_request'];
        $global_crop_cookie_value = $global_resource_library_array['global_crop_cookie_value'];
        $global_crop_cookie_value_title = $global_resource_library_array['global_crop_cookie_value_title'];
        $is_global_crop_cookie_set = $global_resource_library_array['is_global_crop_cookie_set'];
        $page_num = isset($global_resource_library_array['page_num']) ? $global_resource_library_array['page_num'] : 1;

        $audio_video = [];
        $audio_count = 0;
        $video_count = 0;
        $result_html = "";

        $tax_query = [];

        $filters_group_array = RESOURCE_LIBRARY_FILTERS;
        $resource_library_tags_taxonomies = RESOURCE_LIBRARY_TAGS_TAXONOMIES;

        if ($is_global_crop_cookie_set && !($has_tags_params || $has_resource_type_params)) {

            $tax_query["relation"] = "OR";

            foreach ($resource_library_tags_taxonomies as $taxonomy) {

                $filter_group_query_array = [
                    'taxonomy' => $taxonomy,
                    'field' => 'slug',
                    'operator' => 'IN',
                    "terms" =>  $global_crop_cookie_value_title
                ];

                $tax_query[] = $filter_group_query_array;
            }
        } else {
            $all_filter_groups_combined_array = [];
            $all_filter_groups_combined_array["relation"] = "AND";

            foreach ($filters_group_array as $filer_group) {
                $filter_group_query_array = [];

                if ($filer_group['id'] == 'resource-type') {
                    continue;
                } else {
                    $filter_group_active_values = [];

                    foreach ($filer_group['filters'] as $filter) {
                        // preparing tax_query for results
                        if (in_array($filter['value'], $tags_param_array) || in_array($filter['id'], $tags_param_array)) {
                            $filter_group_active_values[] =  $filter['value'];
                        }
                    }

                    if (!empty($filter_group_active_values)) {
                        foreach ($resource_library_tags_taxonomies as $taxonomy) {
                            $filter_group_query_array[] = [
                                'taxonomy' => $taxonomy,
                                'field' => 'slug',
                                'operator' => 'IN',
                                "terms" => $filter_group_active_values
                            ];
                        }
                    }
                }

                if (isset($filter_group_query_array) && !empty($filter_group_query_array)) {
                    $filter_group_query_array["relation"] = "OR";
                    $all_filter_groups_combined_array[] = $filter_group_query_array;
                }
            }

            $tax_query = $all_filter_groups_combined_array;
        }

        /**
         * STEP 2 — Enforce nutrients filter via `nutrients-tag` taxonomy when selected
         *
         * We intersect the incoming tags with existing nutrient terms and, if any match,
         * we ensure the final tax_query includes an explicit clause for taxonomy `nutrients-tag`.
         * If an existing $tax_query is present, we wrap it in an AND with the nutrients clause.
         */
        $selected_nutrients = [];
        if (!empty($tags_param_array)) {
            $existing_nutrient_terms = get_terms([
                'taxonomy'   => 'nutrients-tag',
                'hide_empty' => false,
                'slug'       => $tags_param_array, // intersect by slug
                'fields'     => 'slugs',
            ]);

            if (!is_wp_error($existing_nutrient_terms) && !empty($existing_nutrient_terms)) {
                $selected_nutrients = $existing_nutrient_terms; // array of slugs
            }
        }

        if (!empty($selected_nutrients)) {
            $nutrients_clause = [
                'taxonomy' => 'nutrients-tag',
                'field'    => 'slug',
                'terms'    => $selected_nutrients,
                'operator' => 'IN',
            ];

            if (!empty($tax_query)) {
                // Preserve your existing logic but require nutrients as an additional AND constraint
                $tax_query = [
                    'relation' => 'AND',
                    $tax_query,         // keep prior (may contain its own relation)
                    $nutrients_clause,  // enforce nutrients-tag
                ];
            } else {
                // Only nutrients selected
                $tax_query = [ $nutrients_clause ];
            }
        }
        // END STEP 2

        // Initializing values for query args
        $args = [
            'posts_per_page' => ARCHIVE_RESULTS_PER_PAGE,
            'tax_query'      => $tax_query,
            'orderby'        => "post_date",
            'order'          => "DESC",
            'post_status'    => 'publish',
            'post_type'      => [],
            'paged'          => $page_num,
            's'              => ""
        ];

        // for ajax clear all requests, we want to load all post types
        if ($has_resource_type_params && !$is_ajax_clearall_request) {
            foreach ($resource_type_param_array as $resource_type) {

                if ($resource_type === "audio-articles") {
                    array_push($audio_video, "audio");
                } elseif ($resource_type === "video-articles") {
                    array_push($audio_video, "video");
                }

                if ($resource_type === "audio-articles") {
                    array_push($args['post_type'], "video-articles");
                } elseif ($resource_type === "documents") {
                    array_push($args['post_type'], 'ghs-label', 'spec-sheets', 'directions-for-use', 'sds-pages');
                } else {
                    array_push($args['post_type'], $resource_type);
                }
            }
        } else {
            $args['post_type'] =  array('standard-articles', 'robust-articles', 'trending-topics', 'agrisights', 'agrifacts', 'video-articles', 'ghs-label', 'spec-sheets', 'directions-for-use', "sds-pages", 'success-stories', 'trures-trial-data', 'trures-insights','app-rate-sheets');
        }

        if ($has_search_query) {
            $args['s'] = $search_query;
        }

        $search_filter_query = new \WP_Query($args);
        $results_count = $search_filter_query->found_posts;

        // ========================== AVAILABILITY & COUNTS ===========================

        // Taxonomies we facet on
        $taxonomies = ['crop', 'nutrients-tag', 'performance-product', 'article-tag'];

        // resource type → post type map (adjust if yours differs)
        $resource_type_map = [
            'standard-articles' => ['standard-articles'],
            'robust-articles'   => ['robust-articles'],
            'trending-topics'   => ['trending-topics'],
            'agrisights'        => ['agrisights'],
            'agrifacts'         => ['agrifacts'],
            'video-articles'    => ['video-articles'],
            'documents'         => ['ghs-label','spec-sheets','directions-for-use','sds-pages','app-rate-sheets'],
            'success-stories'   => ['success-story'],
            'trures-trial-data' => ['trures-trial-data'],
            'trures-insights'   => ['trures-insights'],
            'app-rate-sheets'   => ['app-rate-sheets'],
        ];

        // init structures
        $available_terms_by_tax        = ['crop'=>[], 'nutrients-tag'=>[], 'performance-product'=>[], 'article-tag'=>[]];
        $available_term_counts_by_tax  = ['crop'=>[], 'nutrients-tag'=>[], 'performance-product'=>[], 'article-tag'=>[]];
        $available_post_types          = [];
        $available_post_type_counts    = [];

        /**
         * IMPORTANT: Treat "initial load for counts" as "no user-applied filters or search".
         * Ignore AJAX/page/cookie flags for counts. This guarantees global DB counts on first visit.
         */
        $is_initial_load_for_counts = (!$has_tags_params && !$has_resource_type_params && !$has_search_query);

        // ------------- CASE A: initial load => GLOBAL COUNTS (ignore current $args entirely) -------------
        if ($is_initial_load_for_counts) {

            // Global term counts per taxonomy
            foreach ($taxonomies as $tx) {
                $terms = get_terms([
                    'taxonomy'   => $tx,
                    'hide_empty' => false, // show full catalog; UI logic decides disabled/hidden
                ]);
                if (is_wp_error($terms) || empty($terms)) continue;

                foreach ($terms as $t) {
                    $slug = (string) $t->slug;
                    $cnt  = (int) $t->count; // sitewide published posts on that term
                    $available_term_counts_by_tax[$tx][$slug] = $cnt;
                }
                $available_terms_by_tax[$tx] = array_keys($available_term_counts_by_tax[$tx]);
            }

            // Global post type counts
            $all_pts = array_unique(array_merge(...array_values($resource_type_map)));
            foreach ($all_pts as $pt) {
                $counts = wp_count_posts($pt, 'readable');
                $pub    = $counts && isset($counts->publish) ? (int) $counts->publish : 0;
                if ($pub > 0) {
                    $available_post_types[$pt]       = true;
                    $available_post_type_counts[$pt] = $pub;
                } else {
                    $available_post_type_counts[$pt] = 0;
                }
            }

        // ------------- CASE B: filters/search applied => CONDITIONAL COUNTS (AND within each taxonomy) -------------
        } else {

            // IDs-only query across the whole filtered set (not just current page)
            $ids_args = $args;
            $ids_args['fields']         = 'ids';
            $ids_args['no_found_rows']  = true;
            $ids_args['posts_per_page'] = -1;
            $ids_args['paged']          = 1;

            $all_ids_query = new \WP_Query($ids_args);
            $post_ids = !empty($all_ids_query->posts) ? $all_ids_query->posts : [];

            if (!empty($post_ids)) {
                // Post type counts & availability in the filtered set
                foreach ($post_ids as $pid) {
                    $pt = get_post_type($pid);
                    if (!$pt) continue;
                    $available_post_types[$pt] = true;
                    if (!isset($available_post_type_counts[$pt])) $available_post_type_counts[$pt] = 0;
                    $available_post_type_counts[$pt]++;
                }

                // Per-post term slugs for each taxonomy
                $post_terms_by_tax = [
                    'crop' => [], 'nutrients-tag' => [], 'performance-product' => [], 'article-tag' => [],
                ];
                foreach ($taxonomies as $tx) {
                    foreach ($post_ids as $pid) {
                        $slugs = wp_get_post_terms($pid, $tx, ['fields' => 'slugs']);
                        $post_terms_by_tax[$tx][$pid] = (is_wp_error($slugs) || empty($slugs))
                            ? []
                            : array_values(array_unique(array_map('strval', $slugs)));
                    }
                }

                // Selected terms per taxonomy (by intersecting with known slugs)
                $selected_by_tax = [
                    'crop'=>[], 'nutrients-tag'=>[], 'performance-product'=>[], 'article-tag'=>[]
                ];
                if (!empty($tags_param_array)) {
                    foreach ($taxonomies as $tx) {
                        $known = [];
                        foreach ($post_terms_by_tax[$tx] as $pid => $slugs) {
                            foreach ($slugs as $s) $known[$s] = true;
                        }
                        if (!empty($known)) {
                            foreach ($tags_param_array as $maybe_slug) {
                                if (isset($known[$maybe_slug])) $selected_by_tax[$tx][] = $maybe_slug;
                            }
                            $selected_by_tax[$tx] = array_values(array_unique($selected_by_tax[$tx]));
                        }
                    }
                }

                // For each taxonomy, BASE SET = posts containing *all* selected terms IN THAT TAXONOMY
                foreach ($taxonomies as $tx) {
                    $selected_slugs = $selected_by_tax[$tx];

                    $base_ids_for_tx = [];
                    if (empty($selected_slugs)) {
                        $base_ids_for_tx = $post_ids;
                    } else {
                        foreach ($post_ids as $pid) {
                            $post_slugs = $post_terms_by_tax[$tx][$pid] ?? [];
                            $has_all = true;
                            foreach ($selected_slugs as $need) {
                                if (!in_array($need, $post_slugs, true)) { $has_all = false; break; }
                            }
                            if ($has_all) $base_ids_for_tx[] = $pid;
                        }
                    }

                    // Conditional counts from the BASE SET
                    $term_counts  = [];
                    $presence_set = [];
                    foreach ($base_ids_for_tx as $pid) {
                        $post_slugs = $post_terms_by_tax[$tx][$pid] ?? [];
                        foreach ($post_slugs as $slug) {
                            if ($slug === '') continue;
                            if (!isset($term_counts[$slug])) $term_counts[$slug] = 0;
                            $term_counts[$slug]++;
                            $presence_set[$slug] = true;
                        }
                    }

                    $available_term_counts_by_tax[$tx] = $term_counts;
                    $available_terms_by_tax[$tx]       = array_keys($presence_set);
                }
            } else {
                // filtered set empty
                $available_post_types         = [];
                $available_post_type_counts   = [];
                $available_term_counts_by_tax = ['crop'=>[], 'nutrients-tag'=>[], 'performance-product'=>[], 'article-tag'=>[]];
                $available_terms_by_tax       = ['crop'=>[], 'nutrients-tag'=>[], 'performance-product'=>[], 'article-tag'=>[]];
            }
        }

        // Persist for HTML renderer
        $this->global_resource_library_array['available_terms_by_tax']        = $available_terms_by_tax;
        $this->global_resource_library_array['available_term_counts_by_tax']  = $available_term_counts_by_tax;
        $this->global_resource_library_array['available_post_types']          = array_keys(array_filter($available_post_types));
        $this->global_resource_library_array['available_post_type_counts']    = $available_post_type_counts;


        $are_there_audios = in_array("audio", $audio_video) ? true : false;
        $are_there_videos = in_array("video", $audio_video) ? true : false;

        // on page load (redirection), we don't have audio/video checkboxes selected. can pass count directly.
        if ((!$are_there_audios && !$are_there_videos) || ($is_global_crop_cookie_set && !$is_ajax_clearall_request)) {
            $this->setSearchCountGlobally($results_count);
        }

        if ($search_filter_query->have_posts()) {

            while ($search_filter_query->have_posts()) {
                $search_filter_query->the_post();

                $post_type = get_post_type();
                $post_id = get_the_ID();

                switch ($post_type) {

                    // Standard Article ==================================================
                    case "standard-articles":

                        $standard_article_card_html = $this->getStandardArticleCardHtml($post_id);

                        $result_html .= $standard_article_card_html;

                        break;

                    // Robust Articles / Trending Topics ===============================
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

                        $type = get_field('article_type', $post_id);

                        if ($type == "audio") {
                            $audio_count++;
                        } elseif ($type == "video") {
                            $video_count++;
                        }

                        if (in_array($type, $audio_video)) {

                            $audio_video_card_html = $this->getAudioVideoCardHtml($post_id);

                            $result_html .= $audio_video_card_html;
                        } else {
                            break;
                        }

                        break;

                    // Document & Labels ==================================================
                    case "documents":
                    case "ghs-label":
                    case "spec-sheets":
                    case "directions-for-use":
                    case "sds-pages":
                    case "app-rate-sheets":

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

                    // TruResponse Trial Data  ==================================================
                    case "trures-trial-data":

                        $trures_trial_data_card_html = $this->getTruResTrialDataCardHtml($post_id);

                        $result_html .= $trures_trial_data_card_html;

                        break;

                    // TruResponse Insights  ==================================================
                    case "trures-insights":

                        $trures_insights_card_html = $this->getTruResInsightsCardHtml($post_id);

                        $result_html .= $trures_insights_card_html;

                        break;

                    default:
                        $result_html .= "";
                }
            }

            if ($search_filter_query->post_count >= $args['posts_per_page']) {

                $result_html .= '<div class="load-more-wrapper"><a href="#" class="load-more-button" data-page="1">' . __('View More', 'kmag') . '</a></div>';
            }

            wp_reset_query();
        }

        if ($are_there_audios && $are_there_videos) {
            if ($audio_count > $video_count) {
                $results_count -= $video_count;
            } elseif ($video_count > $audio_count) {
                $results_count -= $audio_count;
            }
        } elseif ($are_there_audios && !$are_there_videos) {
            $results_count -= $video_count;
        } elseif ($are_there_videos && !$are_there_audios) {
            $results_count -= $audio_count;
        }

        $this->setSearchCountGlobally($results_count);

        $output = [
            'results_html'  => $result_html,
            'results_count' => $results_count
        ];

        return $output;
    }

    //default state html
    public function setSearchCountGlobally($results_count)
    {
        $this->global_resource_library_array['results_count'] = $results_count;
    }

    public function getSearchFilterHtml()
    {
        $global = $this->global_resource_library_array;

        $tags_param_array             = $global['tags_param_array']            ?? [];
        $has_tags_params              = $global['has_tags_params']             ?? false;
        $resource_type_param_array    = $global['resource_type_param_array']   ?? [];
        $has_resource_type_params     = $global['has_resource_type_params']    ?? false;
        $search_query                 = $global['search_query']                ?? '';
        $has_search_query             = $global['has_search_query']            ?? false;
        $is_ajax_search_request       = $global['is_ajax_search_request']      ?? false;
        $is_ajax_clearall_request     = $global['is_ajax_clearall_request']    ?? false;
        $global_crop_cookie_value     = $global['global_crop_cookie_value']    ?? '';
        $is_global_crop_cookie_set    = $global['is_global_crop_cookie_set']   ?? false;

        $filters_group_array          = RESOURCE_LIBRARY_FILTERS;

        // Maps (may be unset/empty on first render if template order renders filters before results)
        $available_terms_by_tax       = $global['available_terms_by_tax']      ?? [];
        $available_term_counts_by_tax = $global['available_term_counts_by_tax']?? [];
        $available_post_types         = $global['available_post_types']        ?? [];
        $available_post_type_counts   = $global['available_post_type_counts']  ?? [];

        // If no user filters/search AND maps are empty, self-prime global counts here
        $is_initial_load = (!$has_tags_params && !$has_resource_type_params && !$has_search_query);
        $maps_are_empty  =
            empty($available_terms_by_tax) ||
            empty($available_term_counts_by_tax) ||
            empty($available_post_type_counts);

        if ($is_initial_load && $maps_are_empty) {
            // Taxonomies we facet on
            $taxonomies = ['crop', 'nutrients-tag', 'performance-product', 'article-tag'];

            // Global term counts
            $available_terms_by_tax       = ['crop'=>[], 'nutrients-tag'=>[], 'performance-product'=>[], 'article-tag'=>[]];
            $available_term_counts_by_tax = ['crop'=>[], 'nutrients-tag'=>[], 'performance-product'=>[], 'article-tag'=>[]];

            foreach ($taxonomies as $tx) {
                $terms = get_terms([
                    'taxonomy'   => $tx,
                    'hide_empty' => false,
                ]);
                if (!is_wp_error($terms) && !empty($terms)) {
                    foreach ($terms as $t) {
                        $available_term_counts_by_tax[$tx][(string)$t->slug] = (int)$t->count;
                    }
                    $available_terms_by_tax[$tx] = array_keys($available_term_counts_by_tax[$tx]);
                }
            }

            // Resource-type → Post-type map
            $resource_type_map = [
                'standard-articles' => ['standard-articles'],
                'robust-articles'   => ['robust-articles'],
                'trending-topics'   => ['trending-topics'],
                'agrisights'        => ['agrisights'],
                'agrifacts'         => ['agrifacts'],
                'video-articles'    => ['video-articles'],
                'documents'         => ['ghs-label','spec-sheets','directions-for-use','sds-pages','app-rate-sheets'],
                'success-stories'   => ['success-story'],
                'trures-trial-data' => ['trures-trial-data'],
                'trures-insights'   => ['trures-insights'],
                'app-rate-sheets'   => ['app-rate-sheets'],
            ];

            // Global post type counts
            $available_post_types       = [];
            $available_post_type_counts = [];
            $all_pts = array_unique(array_merge(...array_values($resource_type_map)));
            foreach ($all_pts as $pt) {
                $counts = wp_count_posts($pt, 'readable');
                $pub    = $counts && isset($counts->publish) ? (int)$counts->publish : 0;
                if ($pub > 0) $available_post_types[] = $pt;
                $available_post_type_counts[$pt] = $pub;
            }

            // Optionally stash back so subsequent calls reuse it (not required)
            $this->global_resource_library_array['available_terms_by_tax']       = $available_terms_by_tax;
            $this->global_resource_library_array['available_term_counts_by_tax'] = $available_term_counts_by_tax;
            $this->global_resource_library_array['available_post_types']         = $available_post_types;
            $this->global_resource_library_array['available_post_type_counts']   = $available_post_type_counts;
        }

        // Disable options only after user interacts
        $restrict_options = ($has_tags_params || $has_resource_type_params || $has_search_query);

        $search_close_icon_class = $has_search_query ? 'show' : 'hide';
        $search_icon_class       = $has_search_query ? 'hide' : 'show';

        // Resource-type → Post-type map (same as in results; keep in sync)
        $resource_type_map = [
            'standard-articles' => ['standard-articles'],
            'robust-articles'   => ['robust-articles'],
            'trending-topics'   => ['trending-topics'],
            'agrisights'        => ['agrisights'],
            'agrifacts'         => ['agrifacts'],
            'video-articles'    => ['video-articles'],
            'documents'         => ['ghs-label','spec-sheets','directions-for-use','sds-pages','app-rate-sheets'],
            'success-stories'   => ['success-story'],
            'trures-trial-data' => ['trures-trial-data'],
            'trures-insights'   => ['trures-insights'],
            'app-rate-sheets'   => ['app-rate-sheets'],
        ];

        // Helper: resolve taxonomy for a group
        $resolve_group_tax = function(array $group) {
            if (!empty($group['taxonomy'])) return $group['taxonomy'];
            $id = $group['id'] ?? '';
            if ($id === 'crops')               return 'crop';
            if ($id === 'nutrients')           return 'nutrients-tag';
            if ($id === 'products')            return 'performance-product';
            if ($id === 'agronomy-topics')     return 'article-tag';
            if ($id === 'article-tags')        return 'article-tag';
            return null; // resource-type, or non-tax groups
        };

        // Helper: resolve a slug for an option (constants may have label only)
        $resolve_slug = function(array $filter, ?string $taxonomy) {
            if (!empty($filter['id']))   return (string) $filter['id'];   // prefer explicit slug id
            if (!empty($filter['value'])) {
                $val = (string) $filter['value'];
                if ($taxonomy) {
                    // If it's a label, translate to slug
                    $term = get_term_by('name', $val, $taxonomy);
                    if ($term && !is_wp_error($term)) return (string) $term->slug;
                }
                return $val; // treat as slug if no taxonomy / no term found
            }
            return '';
        };

        $this->cnSearchFilterScripts();

        ob_start(); ?>
        <div id="filter-search-container" class="prevent-select">
        <form action="" method="get" data-form="resource-library">

            <div class="search-box">
            <div class="search-input">
                <input
                name="search"
                id="search"
                value="<?php echo esc_attr($search_query); ?>"
                class="search-bar"
                placeholder="<?php echo esc_attr__('Enter a topic keyword', 'kmag'); ?>"
                >
                <div class="search-close-icon-wrapper <?php echo esc_attr($search_close_icon_class); ?>">
                <input type="button" class="close-icon" name="closebtn" value="">
                <svg class="icon icon-close-search"><use xlink:href="#icon-close-search"></use></svg>
                </div>
                <div class="search-icon-wrapper <?php echo esc_attr($search_icon_class); ?>">
                <input type="submit" class="search-submit-btn search-icon show" name="submit" value="">
                <svg class="icon icon-search"><use xlink:href="#icon-search"></use></svg>
                </div>
                <div class="validation-msg"></div>
            </div>
            </div>

            <div class="filters-wrapper">
            <?php foreach ($filters_group_array as $filer_group) : ?>
                <?php
                $group_id   = $filer_group['id']    ?? '';
                $group_key  = $filer_group['key']   ?? '';
                $group_val  = $filer_group['value'] ?? '';
                $group_tax  = $resolve_group_tax($filer_group);

                // Replace Nutrients with live taxonomy terms
                if ($group_id === 'nutrients' || $group_key === 'nutrients') {
                    $nutrient_items = $this->getNutrientFilterItems(); // [{id: slug, label: name, count: int}]
                    $filer_group['filters'] = array_map(function ($item) {
                        return ['id' => $item['id'], 'value' => $item['id'], 'label' => $item['label']];
                    }, $nutrient_items);
                }

                $filters_list = $filer_group['filters'] ?? ($filer_group['items'] ?? []);
                ?>

                <div class="filter <?php echo esc_attr($group_id) . '-filter'; ?>">
                <label for="<?php echo esc_attr($group_id); ?>" class="dropdown-label form-control toggle-next ellipsis">
                    <?php echo esc_html__($group_val, 'kmag'); ?>
                    <svg class="icon icon-filter-select-dropdown"><use xlink:href="#icon-filter-select-dropdown"></use></svg>
                </label>

                <div class="dropdown-wrapper hidden">
                    <div class="apply-wrapper">
                    <input type="submit" name="submit" value="<?php echo esc_attr__('Apply', 'kmag'); ?>">
                    </div>

                    <div class="options-wrapper">
                    <?php if (!empty($filters_list)) :
                        foreach ($filters_list as $filter) :

                            if ($group_id === 'resource-type') {
                                $slug        = (string) ($filter['id'] ?? '');
                                $url_params  = $resource_type_param_array;
                                $is_selected = in_array($slug, (array)$url_params, true);

                                // Count = sum mapped post-type counts (global on first load, conditional after)
                                $pts          = $resource_type_map[$slug] ?? [$slug];
                                $option_count = 0;
                                foreach ($pts as $pt) $option_count += (int) ($available_post_type_counts[$pt] ?? 0);

                            } else {
                                $slug        = $resolve_slug($filter, $group_tax);
                                $url_params  = $tags_param_array;
                                $is_selected = in_array($slug, (array)$url_params, true)
                                            || (!empty($filter['id']) && in_array($filter['id'], (array)$url_params, true))
                                            || (!empty($filter['value']) && in_array($filter['value'], (array)$url_params, true));

                                $option_count = 0;
                                if ($group_tax) {
                                    // counts keyed by slug; try id/value as fallbacks
                                    $option_count = (int) ($available_term_counts_by_tax[$group_tax][$slug] ?? 0);
                                    if ($option_count === 0 && !empty($filter['id'])) {
                                        $option_count = (int) ($available_term_counts_by_tax[$group_tax][$filter['id']] ?? 0);
                                    }
                                    if ($option_count === 0 && !empty($filter['value'])) {
                                        $option_count = (int) ($available_term_counts_by_tax[$group_tax][$filter['value']] ?? 0);
                                    }
                                }
                            }

                            $input_id    = $slug;
                            $field_value = $slug;

                            // Crop cookie visual pre-check (unchanged)
                            $is_globally_selected_crop = false;
                            if ($group_id === 'crops') {
                                if ($input_id === $global_crop_cookie_value) {
                                    $is_globally_selected_crop = true;
                                    $global['global_crop_cookie_value_title'] = $filter['value'] ?? $input_id;
                                }
                            }

                            // Disable only after user interaction
                            $is_disabled = false;
                            if ($restrict_options && !$is_selected) {
                                $is_disabled = ((int)$option_count === 0);
                            }
                            if ($is_selected || ($group_id === 'crops' && $is_globally_selected_crop)) {
                                $is_disabled = false;
                            }

                            $base_label     = $filter['label'] ?? ($filter['value'] ?? $input_id);
                            //$label_text     = sprintf('%s (%d)', $base_label, (int)$option_count);
                            $label_text     = sprintf('%s', $base_label);
                            $disabled_attr  = $is_disabled ? ' disabled aria-disabled="true"' : '';
                            $disabled_class = $is_disabled ? ' is-disabled' : '';
                            ?>
                            <div class="select-option-wrapper<?php echo $disabled_class; ?>">
                            <input
                                class="<?php echo esc_attr($input_id); ?>"
                                type="checkbox"
                                id="<?php echo esc_attr($input_id); ?>"
                                value="<?php echo esc_attr($field_value); ?>"
                                name="<?php echo esc_attr($group_id); ?>"
                                <?php
                                if ($is_selected || ($group_id === 'crops' && $is_globally_selected_crop)) echo 'checked';
                                echo $disabled_attr;
                                ?>
                            >
                            <label class="<?php echo $is_disabled ? 'is-disabled' : ''; ?>" for="<?php echo esc_attr($input_id); ?>">
                                <?php echo esc_html__($label_text, 'kmag'); ?>
                            </label>
                            </div>
                        <?php endforeach;
                    endif; ?>
                    </div>
                </div>
                </div>
            <?php endforeach; ?>
            </div>

            <?php if ($has_tags_params || $has_resource_type_params || ($is_ajax_search_request && !$is_ajax_clearall_request) || $is_global_crop_cookie_set) : ?>
            <div class="results-info-wrapper">
                <div class="allselected-filter">
                <div class="indi-filter"></div>
                <div class="clear-filter"><a href="#" id="clear-all"><?php _e('X Clear All', 'kmag'); ?></a></div>
                </div>
                <div class="results-count">
                <?php echo esc_html($global['results_count']) . ' ' . esc_html__('Results', 'kmag'); ?>
                </div>
            </div>
            <?php endif; ?>

        </form>
        </div>
        <?php
        return ob_get_clean();
    }



    // Scripts for Ajax Filter Search
    public function cnSearchFilterScripts()
    {
        wp_localize_script('cn-theme', 'ajax_info', array(
            'ajax_url' => admin_url('admin-ajax.php')
        ));
    }

    // ajax callback
    public function cn_ajax_filter_search_callback()
    {

        header("Content-Type: application/json");

        $global_resource_library_array = $this->global_resource_library_array;

        // setting tags related variables
        $tags_values = filter_input(INPUT_GET, 'tags', FILTER_SANITIZE_SPECIAL_CHARS);
        $tags_param_array = (isset($tags_values) && !empty($tags_values)) ? explode(',', $tags_values) : [];

        $has_tags_params = (isset($tags_param_array) && !empty($tags_param_array)) ? true : false;

        // resource type related variables
        $resource_type_values = filter_input(INPUT_GET, 'resourceType', FILTER_SANITIZE_SPECIAL_CHARS);
        $resource_type_param_array = (isset($resource_type_values)  && !empty($resource_type_values))  ? explode(',', $resource_type_values) : [];
        $has_resource_type_params = (isset($resource_type_param_array) && !empty($resource_type_param_array)) ?  true : false;

        // search query related variables
        $search_query = (isset($_GET['search']) && !empty($_GET['search'])) ? $_GET['search'] : "";
        $has_search_query = (isset($search_query) && !empty($search_query)) ? true : false;

        // ajax search request
        $get_action_param = (isset($_GET['action']) && !empty($_GET['action'])) ? $_GET['action'] : "";
        $is_ajax_search_request = $get_action_param === "cn_ajax_filter_search";

        // ajax clearall request
        $get_clearall_param = (isset($_GET['clearall']) && !empty($_GET['clearall'])) ? $_GET['action'] : "";
        $is_ajax_clearall_request = ($get_clearall_param === "yes") ? true : false;

        // get page number
        $page_num_get_value = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_SPECIAL_CHARS);
        $page_num = (isset($page_num_get_value) && !empty($page_num_get_value)) ? (int)$page_num_get_value : 1;

        $global_resource_library_array = array(
            'tags_param_array' => $tags_param_array,
            'has_tags_params' => $has_tags_params,
            'resource_type_param_array' => $resource_type_param_array,
            'has_resource_type_params' => $has_resource_type_params,
            'search_query' => $search_query,
            'has_search_query' => $has_search_query,
            'is_ajax_search_request' => $is_ajax_search_request,
            'is_ajax_clearall_request' => $is_ajax_clearall_request,
            'page_num' => $page_num

        );

        $resultsOutput = $this->getSearchResults($global_resource_library_array);
        $filterOutputHtml = $this->getSearchFilterHtml($global_resource_library_array);

        echo json_encode(array(
            'results_html' => $resultsOutput['results_html'],
            'filters_html' => $filterOutputHtml,
            'results_count' => $resultsOutput['results_count']
        ));

        wp_die();
    }

    // setup resource library ACF fields
    public function setupResourceLibraryACF()
    {
        //  Using Wordplate

        if (function_exists('register_extended_field_group')) {
            register_extended_field_group([
                'key' => 'resource_library_page_fields_2',
                'title' => __('Resource Library Fields 2', 'kmag'),
                'fields' => [
                    Group::make(__('Featured Article (Standard)', 'kmag'), 'featured_article_group')
                        ->fields([
                            Select::make(__('Enable Featured Article (Standard)?', 'kmag'), 'enable_featured_article')
                                ->choices([
                                    'no' => __('No', 'kmag'),
                                    'yes' => __('Yes', 'kmag'),
                                ])
                                ->defaultValue('no')
                                ->returnFormat('value'),

                            PostObject::make(__('Please select Featured Standard Article', 'kmag'), 'featured_standard_article')
                                ->postTypes(['standard-articles'])
                                ->returnFormat('id'),

                            Relationship::make(__('Standard Articles', 'kmag'), 'standard_articles')
                                ->postTypes(['standard-articles'])
                                ->filters([
                                    'search',
                                ])
                                ->min(0)
                                ->max(3)
                                ->instructions(__('Select 3 Standard Articles to display in the Articles section', 'kmag'))
                                ->returnFormat('object'),
                        ]),

                    Group::make(__('Featured Trending Topic (Robust Article)', 'kmag'), 'featured_trending_topic_group')
                        ->fields([

                            Select::make(__('Enable Featured Trending Topic (Robust Article)?', 'kmag'), 'enable_featured_trending_topic')
                                ->choices([
                                    'no' => __('No', 'kmag'),
                                    'yes' => __('Yes', 'kmag'),
                                ])
                                ->defaultValue('yes')
                                ->returnFormat('value'),

                            PostObject::make(__('Please select Featured Trending Topic (Robust Article)', 'kmag'), 'featured_trending_topic')
                                ->postTypes(['robust-articles'])
                                ->returnFormat('id'),

                            Relationship::make(__('Robust Articles', 'kmag'), 'robust_articles')
                                ->postTypes(['robust-articles'])
                                ->filters([
                                    'search',
                                ])
                                ->min(0)
                                ->max(3)
                                ->instructions(__('Select 3 Robust Articles to display in the Trending Topics section', 'kmag'))
                                ->returnFormat('object'),
                        ]),

                    Group::make(__('Featured Video', 'kmag'), 'featured_video_group')
                        ->fields([

                            Select::make(__('Enable Featured Video?', 'kmag'), 'enable_featured_video')
                                ->choices([
                                    'no' => __('No', 'kmag'),
                                    'yes' => __('Yes', 'kmag'),
                                ])
                                ->defaultValue('yes')
                                ->returnFormat('value'),

                            PostObject::make(__('Please select Featured Video', 'kmag'), 'featured_video')
                                ->postTypes(['video-articles'])
                                ->returnFormat('id'),
                        ]),

                    Group::make(__('Featured Audio', 'kmag'), 'featured_audio_group')
                        ->fields([

                            Select::make(__('Enable Featured Audio?', 'kmag'), 'enable_featured_audio')
                                ->choices([
                                    'no' => __('No', 'kmag'),
                                    'yes' => __('Yes', 'kmag'),
                                ])
                                ->defaultValue('yes')
                                ->returnFormat('value'),

                            PostObject::make(__('Please select Featured Audio', 'kmag'), 'featured_audio')
                                ->postTypes(['video-articles'])
                                ->returnFormat('id'),
                        ]),

                    Group::make(__('Featured Success Story', 'kmag'), 'featured_success_story_group')
                        ->fields([

                            Select::make(__('Enable Featured Success Story?', 'kmag'), 'enable_featured_success_story')
                                ->choices([
                                    'no' => __('No', 'kmag'),
                                    'yes' => __('Yes', 'kmag'),
                                ])
                                ->defaultValue('no')
                                ->returnFormat('value'),

                            PostObject::make(__('Please select Featured Success Story', 'kmag'), 'featured_success_story')
                                ->postTypes(['success-story'])
                                ->returnFormat('id'),
                        ]),
                    Common::aiAgentFields()
                ],
                'location' => [
                    Location::where('post_type', 'page')->and('page_template', '==', 'templates/resource-library.php'),
                ],
            ]);
        }
    }
}