<?php

namespace CN\App\API;

use CN\App\Interfaces\WordPressHooks;
use CN\App\API\AuthSalesforce;

/**
 * Class ResourceLibrary
 *
 * @package CN\App\API
 */
class ResourceLibrary implements WordPressHooks
{
    /**
     * Add class hooks.
     */
    public function addHooks()
    {
        add_action('wp_enqueue_scripts', [$this, 'localizeRestJs']);
        add_action('rest_api_init', [$this, 'resourceLibraryEndpoints']);
        add_action('parse_request', [$this, 'overwriteRequest'], 10, 1);
    }

    /**
     * Pass nonce to admin as js to pass to endpoint
     */
    public function localizeRestJs()
    {
        wp_localize_script(
            'cn-theme',
            'resource_library',
            [
                'apiNonce' => wp_create_nonce('wp_rest')
            ]
        );
    }

    /**
     * CN endpoints init
     */
    public function resourceLibraryEndpoints()
    {
        // Endpoint to send data to resource library
        register_rest_route('cn/v1', '/resource-library', [
            'methods'             => \WP_REST_Server::EDITABLE,
            'callback'            => [$this, 'sendLibraryData'],
            'permission_callback' => '__return_true'
        ]);
    }

    /**
     * Send Data to Salesforce or SFMC
     */
    public function sendLibraryData($request)
    {
        $token = AuthSalesforce::getToken();
        
        /**************************************************************\
            The AuthSFMC class is successfully returning a token.
            The AuthSalesforce class is returning 'bad request' error.

            TODO: Handle Resource Library rest events here.
        \**************************************************************/

        return new \WP_REST_Response(
            $res,
            200
        );

        wp_reset_postdata();

        die();
    }

    /**
     * Review post type of single page and do an overwrite
     */
    public function overwriteRequest($query) {
        // Check if the query is for a single page with a post type of resource library
        if (!empty($query->query_vars['name']) && !empty($query->query_vars['post_type'])) {

            // Check if the post type that is being returned is part of the resource library
            if (in_array($query->query_vars['post_type'], RESOURCE_POST_TYPES)) {
                global $wpdb;

                // Get the slug of the page
                $page_name = $query->query_vars['name'];
    
                // Get the post type from database
                $post_type = $wpdb->get_var("SELECT post_type FROM $wpdb->posts WHERE post_name = '$page_name'");
                
                // Overwrite the query to show the correct template, if there is another post with the same slug it will return the first one
                $new_query = array(
                    'post_type' => $post_type,
                    'name' => $page_name
                );
    
                $query->query_vars = $new_query;

                return $query;
            }
        }
    }
}
