<?php

namespace CN\App\API;

use CN\App\Fields\Options;

/**
 * Class AuthSalesforce
 *
 * @package CN\App\API
 */
class AuthSalesforce
{
    /**********************************************************\
     TODO: Get this Class to return a Token.
           Right now we are getting the error 'bad request'
    \**********************************************************/

    /**
     *
     * Get Token from Salesforce
     *
     */
    public static function getToken()
    {
        $sf_scoring_consumer_key = Options::getSiteOption('sf_scoring_consumer_key');
        $sf_scoring_consumer_secret = Options::getSiteOption('sf_scoring_consumer_secret');
        $sf_scoring_password = Options::getSiteOption('sf_scoring_password');
        $sf_scoring_security_token = Options::getSiteOption('sf_scoring_security_token');
        $sf_scoring_user = Options::getSiteOption('sf_scoring_user');
        $sf_scoring_url = Options::getSiteOption('sf_scoring_url');

        $headers = array('Content-Type' => 'application/x-www-form-urlencoded', 'Accept' => 'application/json');
        $args = array(
            'grant_type' => 'password', 'client_id' => $sf_scoring_consumer_key, 'client_secret' => $sf_scoring_consumer_secret, 'username' => $sf_scoring_user, 'password' => $sf_scoring_password . $sf_scoring_security_token);
        
        try {
            $res = wp_remote_post($sf_scoring_url, array(
                'headers' => $headers,
                'body' => json_encode($args)
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
