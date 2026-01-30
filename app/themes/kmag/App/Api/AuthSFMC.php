<?php

namespace CN\App\API;

use CN\App\Fields\Options;

/**
 * Class AuthSFMC
 *
 * @package CN\App\API
 */
class AuthSFMC
{
    /**********************************************************\
        This has been tested and is working. It will return
        a token from SFMC.
    \**********************************************************/

    /**
     *
     * Get Token from SFMC
     *
     */
    public static function getToken()
    {
        $sfmc_client_id = Options::getSiteOption('sfmc_client_id');
        $sfmc_client_secret = Options::getSiteOption('sfmc_client_secret');
        $sfmc_auth_url = Options::getSiteOption('sfmc_auth_url');

        $headers = array('Content-Type' => 'application/x-www-form-urlencoded', 'Accept' => 'application/json');
        $args = array('grant_type' => 'client_credentials', 'client_id' => $sfmc_client_id, 'client_secret' => $sfmc_client_secret);
        
        try {
            $res = wp_remote_post($sfmc_auth_url, array(
                'body' => $args,
                'headers' => $headers
            ));

            if (is_wp_error($res)) {
                $error_message = $res->get_error_message();
                $token = "Error: " . $error_message;
            } else {
                $token = json_decode($res["body"])->access_token;
            }
        } catch (Exception $e) {
            $token = $e->getMessage();
        }
        return $token;
    }
}
