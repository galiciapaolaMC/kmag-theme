<?php

namespace CN\App\Api;

use CN\App\Interfaces\WordPressHooks;
use CN\App\Fields\ACF;
use CN\App\Fields\Util;
use CN\App\Media;



/**
 * Class Episode Filters
 *
 * @package BP\App
 */
class EpisodeFilters implements WordPressHooks
{
    /**
     * Add class hooks.
     */
    public function addHooks()
    {
        add_action('wp_enqueue_scripts', [$this, 'localizeRestJs']);
        add_action('rest_api_init', [$this, 'episodeEndpoints']);
    }

    /**
     * Pass nonce to admin as js to pass to endpoint
     */
    public function localizeRestJs()
    {
        wp_localize_script(
            'cn-theme',
            'episode_filter',
            [
                'apiNonce' => wp_create_nonce('wp_rest')
            ]
        );
    }

    /**
     * Episode endpoints init
     */
    public function episodeEndpoints()
    {
        register_rest_route('episode-grid-rest/v1', '/search', [
            'methods'             => 'POST',
            'callback'            => [$this, 'loadEpisodeFilter'],
            'permission_callback' => '__return_true'
        ]);

        register_rest_route('farmer-grid-rest/v1', '/search', [
            'methods'             => 'POST',
            'callback'            => [$this, 'loadFarmerFilter'],
            'permission_callback' => '__return_true'
        ]);

        register_rest_route('episode-slider-rest/v1', '/search', [
            'methods'             => 'POST',
            'callback'            => [$this, 'loadEpisodeVideoSliderFilter'],
            'permission_callback' => '__return_true'
        ]);

        register_rest_route('episode-slider-audio-rest/v1', '/search', [
            'methods'             => 'POST',
            'callback'            => [$this, 'loadEpisodeAudioSliderFilter'],
            'permission_callback' => '__return_true'
        ]);
    }

    /**
     * Load scripts for the front end.
     */
    public function loadEpisodeFilter($request)
    {
        global $wpdb;

        $data = $request->get_param('data');
        $season = $data['season'] ?? [];
        $agronomy_topic = $data['agronomy_topic'] ?? [];

        $all_tax_terms = array_merge($season, $agronomy_topic);
        
        $html = '';
        
        
        $args = array(
            'post_type' => ['sherry-show-episodes'],
            'post_status' => 'publish',
            'posts_per_page' => -1
        );
        
        if (!empty($all_tax_terms)) {
            $args['tax_query'] = array(
                'relation' => 'AND'
            );

            if (!empty($season)) {
                $args['tax_query'][] = [
                    'taxonomy' => 'season-option',
                    'field'    => 'slug',
                    'terms'    => $season
                ];
            }

            if (!empty($agronomy_topic)) {
                $args['tax_query'][] = [
                    'taxonomy' => 'agronomy-topics',
                    'field'    => 'slug',
                    'terms'    => $agronomy_topic
                ];
            }
        }

        $query = new \WP_Query($args);
        
        foreach ($query->posts as $post) :
            $query->the_post();
            $post_id = $post->ID;
            
            $html .= apply_filters('cn/grid-episode/card', $post_id);
        endforeach; 

        return new \WP_REST_Response(
            ['posts' => $html],
            200
        );
    }

    /**
     * Load scripts for the front end.
     */
    public function loadFarmerFilter($request)
    {
        global $wpdb;

        $data = $request->get_param('data');
        $country = $data['countries'] ?? [];

        $all_tax_terms = array_merge($country);

        $html = '';
        
        
        $args = array(
            'post_type' => ['farmer-profiles'],
            'post_status' => 'publish',
            'posts_per_page' => -1
        );
        
        if (!empty($all_tax_terms)) {
            $args['tax_query'] = array(
                'relation' => 'AND'
            );

            if (!empty($country)) {
                $args['tax_query'][] = [
                    'taxonomy' => 'farmer-country',
                    'field'    => 'slug',
                    'terms'    => $country
                ];
            }
        }

        $query = new \WP_Query($args);
        
        foreach ($query->posts as $post) :
            $query->the_post();
            $post_id = $post->ID;
            
            $html .= apply_filters('cn/grid-farmer/card', $post_id);
        endforeach; 

        return new \WP_REST_Response(
            ['posts' => $html],
            200
        );
    }

    /**
     * Load scripts for the front end.
     */
    public function loadEpisodeVideoSliderFilter($request)
    {
        global $wpdb;

        $data = $request->get_param('data');
        $season = $data['season'] ?? [];
        $agronomy_topic = $data['agronomy_topic'] ?? [];
        $farmers = $data['farmers'] ?? [];
        $country = $data['countries'] ?? [];

        $all_tax_terms = array_merge($season, $agronomy_topic, $country);
        
        $html = '';
        
        
        $args = array(
            'post_type' => ['frontier-fields-eps'],
            'episode-type' => 'video',
            'post_status' => 'publish',
            'posts_per_page' => -1
        );
        
        if (!empty($all_tax_terms)) {
            $args['tax_query'] = array(
                'relation' => 'AND'
            );

            if (!empty($season)) {
                $args['tax_query'][] = [
                    'taxonomy' => 'season-option',
                    'field'    => 'slug',
                    'terms'    => $season
                ];
            }

            if (!empty($agronomy_topic)) {
                $args['tax_query'][] = [
                    'taxonomy' => 'agronomy-topics',
                    'field'    => 'slug',
                    'terms'    => $agronomy_topic
                ];
            }

            if (!empty($country)) {
                $args['tax_query'][] = [
                    'taxonomy' => 'episode-country',
                    'field'    => 'slug',
                    'terms'    => $country
                ];
            }
        }

        $query = new \WP_Query($args);
        
        foreach ($query->posts as $post) :
            $query->the_post();
            $post_id = $post->ID;
            $data = ACF::getPostMeta($post_id);
            $associated_farmers = ACF::getField('associated-farmers', $data);

            if (!empty($associated_farmers) && !empty($farmers)) {
                foreach($associated_farmers as $farmer_post) {
                    if (in_array($farmer_post, $farmers)) {
                        $html .= apply_filters('cn/slider-episode/card', $post_id);
                    }
                }
            } else {
                $html .= apply_filters('cn/slider-episode/card', $post_id);
            }
        endforeach; 

        return new \WP_REST_Response(
            ['posts' => $html],
            200
        );
    }

    /**
     * Load scripts for the front end.
     */
    public function loadEpisodeAudioSliderFilter($request)
    {
        global $wpdb;

        $data = $request->get_param('data');
        $season = $data['season'] ?? [];
        $agronomy_topic = $data['agronomy_topic'] ?? [];
        $farmers = $data['farmers'] ?? [];
        $country = $data['countries'] ?? [];

        $all_tax_terms = array_merge($season, $agronomy_topic, $country);
        
        $html = '';
        
        
        $args = array(
            'post_type' => ['frontier-fields-eps'],
            'episode-type' => 'audio',
            'post_status' => 'publish',
            'posts_per_page' => -1
        );
        
        if (!empty($all_tax_terms)) {
            $args['tax_query'] = array(
                'relation' => 'AND'
            );

            if (!empty($season)) {
                $args['tax_query'][] = [
                    'taxonomy' => 'season-option',
                    'field'    => 'slug',
                    'terms'    => $season
                ];
            }

            if (!empty($agronomy_topic)) {
                $args['tax_query'][] = [
                    'taxonomy' => 'agronomy-topics',
                    'field'    => 'slug',
                    'terms'    => $agronomy_topic
                ];
            }

            if (!empty($country)) {
                $args['tax_query'][] = [
                    'taxonomy' => 'episode-country',
                    'field'    => 'slug',
                    'terms'    => $country
                ];
            }
        }

        $query = new \WP_Query($args);
        
        foreach ($query->posts as $post) :
            $query->the_post();
            $post_id = $post->ID;
            $data = ACF::getPostMeta($post_id);
            $associated_farmers = ACF::getField('associated-farmers', $data);

            if (!empty($associated_farmers) && !empty($farmers)) {
                foreach($associated_farmers as $farmer_post) {
                    if (in_array($farmer_post, $farmers)) {
                        $html .= apply_filters('cn/slider-episode/card', $post_id);
                    }
                }
            } else {
                $html .= apply_filters('cn/slider-episode/card', $post_id);
            }
        endforeach; 

        return new \WP_REST_Response(
            ['posts' => $html],
            200
        );
    }
}