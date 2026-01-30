<?php

namespace CN\App\SalesForce;

use CN\App\Interfaces\WordPressHooks;
use CN\App\Fields\ACF;
use CN\App\Fields\Options;

/**
 * Class Api
 *
 * @package CN\App\SalesForce
 */
class Api implements WordPressHooks
{
    private $auth_token;
    private $gate_auth_token;

    /**
     * Add class hooks.
     */
    public function addHooks()
    {
        add_action('wp_enqueue_scripts', [$this, 'localizeRestJs']);
        add_action('rest_api_init', [$this, 'gatedContentEndpoint']);
    }


    /**
     * Gated Content endpoints init
     */
    public function gatedContentEndpoint()
    {
        // Endpoint to get News and Resources data
        register_rest_route('gated_content/v1', '/send', [
            'methods'             => 'POST',
            'callback'            => [$this, 'setUpTriggeredSend'],
            'permission_callback' => '__return_true'
        ]);
        register_rest_route('score_page/v1', '/send', [
            'methods'             => 'POST',
            'callback'            => [$this, 'scorePages'],
            'permission_callback' => '__return_true'
        ]);
    }


    /**
     * Pass nonce to admin as js to pass to endpoint
     */
    public function localizeRestJs()
    {
        wp_localize_script(
            'cn-theme',
            'gated_content_api',
            [
                'apiNonce' => wp_create_nonce('wp_rest')
            ]
        );
    }

    /**
     * Get the auth token from Salesforce and set as a class property.
     *
     * @return void
     */
    private function getAuthToken()
    {
        $options = Options::getSiteOptions();
        $args = [
            'client_id' => ACF::getField('gda-test-gate_client-id', $options),
            'client_secret' => ACF::getField('gda-test-gate_client-secret', $options),
            'account_id' => ACF::getField('gda-test-gate_account-id', $options),
            'endpoint' => ACF::getField('gda-test-gate_token-endpoint', $options)
        ];

        // Validate all necessary fields have values
        foreach (REQUIRED_GDA_GATE_AUTH_TOKEN_FIELDS as $value) {
            if (!array_key_exists($value, $args) || empty($args[$value])) {
                _e('Request failed: Missing a required field.', 'kmag');
                return;
            }
        }

        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Accept' => 'application/json'
        ];

        // SF Auth token endpoint wants the body to be urlencoded
        $body = http_build_query([
            'grant_type' => 'client_credentials',
            'client_id' => $args['client_id'],
            'client_secret' => $args['client_secret'],
            'account_id' => $args['account_id']
        ]);

        $auth_response = $this->getApiToken($args['endpoint'], $headers, $body);

        if ($auth_response === null) {
            return;
        }

        $this->auth_token = $auth_response->access_token;
    }

    /**
     * Get the auth token from Salesforce and set as a class property.
     *
     * @return void
     */
    private function getGateAuthToken()
    {
        $options = Options::getSiteOptions();
        $args = [
            'token' => ACF::getField('default-gate_token', $options),
            'username' => ACF::getField('default-gate_username', $options),
            'password' => ACF::getField('default-gate_password', $options),
            'client_id' => ACF::getField('default-gate_client-id', $options),
            'client_secret' => ACF::getField('default-gate_client-secret', $options),
            'endpoint' => ACF::getField('default-gate_token-endpoint', $options)
        ];

        // Validate all necessary fields have values
        foreach (REQUIRED_GATE_AUTH_TOKEN_FIELDS as $value) {
            if (!array_key_exists($value, $args) || empty($args[$value])) {
                _e('Request failed: Missing a required field.', 'kmag');
                return;
            }
        }

        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Accept' => 'application/json'
        ];

        // SF Auth token endpoint wants the body to be urlencoded
        $body = http_build_query([
            'grant_type' => 'password',
            'username' => $args['username'],
            'password' => "{$args['password']}{$args['token']}",
            'client_id' => $args['client_id'],
            'client_secret' => $args['client_secret']
        ], '', '&', PHP_QUERY_RFC3986);

        $auth_response = $this->getApiToken($args['endpoint'], $headers, $body);

        if ($auth_response === null) {
            return;
        }

        $this->gate_auth_token = $auth_response->access_token;
    }

    /**
     * Format GDA Test Gate Form data
     *
     * @param object $data
     *
     * @return void
     */
    private function formatGDAFormSend($data)
    {
        $options = Options::getSiteOptions();
        $gated_content_endpoint = ACF::getField('gda-test-gate_content-endpoint', $options);

        $this->getAuthToken();

        if (empty($this->auth_token)) {
            _e('Could not get token to send to SF.', 'kmag');
            return;
        }

        $headers = [
            'Content-Type' => 'application/json;charset=UTF-8',
            'Authorization' => "Bearer {$this->auth_token}"
        ];

        $body = json_encode([
            "items" => [
                [
                    'First_Name' => $data->form->firstName ?? 'UNDEFINED',
                    'Last_Name' => $data->form->lastName ?? 'UNDEFINED',
                    'Company_Name' => $data->form->companyName ?? 'UNDEFINED',
                    'Work_Email' => $data->form->email ?? 'UNDEFINED',
                    'Work_Phone' => $data->form->phone ?? 'UNDEFINED',
                    'Role' => $data->form->role ?? 'UNDEFINED'
                ]
            ]
        ]);

       $response = $this->postToSalesforce($gated_content_endpoint, $headers, $body);
    }


    /**
     * Format the Brief Gate Form data
     *
     * @return void
     *
     * @param object $data
     */
    private function formatGateFormSend($data)
    {
        $post_id = $data->form->pageId;
        $meta_campaign_id = null;
        if (isset($post_id)) {
            $meta_campaign_id = get_post_meta($post_id, 'scored-content_campaign', true);
        }

        $options = Options::getSiteOptions();
        $gated_content_endpoint = ACF::getField('default-gate_content-endpoint', $options);
        // fallback to options-level campaign id if the campaign id at the post level doesn't exist
        $campaign_id = !empty($meta_campaign_id) ? $meta_campaign_id : ACF::getField('default-gate_campaign-id', $options);

        $this->getGateAuthToken();

        if (empty($this->gate_auth_token)) {
            _e('Could not get token to send to SF.', 'kmag');
            return;
        }

        $headers = [
            'Content-Type' => 'application/json;charset=UTF-8',
            'Authorization' => "Bearer {$this->gate_auth_token}"
        ];

        // SF form submit endpoint wants the body to be JSON
        $body = json_encode([
            'Campaign' => $campaign_id,
            'FirstName' => $data->form->firstName ?? 'UNDEFINED',
            'LastName' => $data->form->lastName ?? 'UNDEFINED',
            'Email' => $data->form->email ?? 'UNDEFINED',
            'Occupation' => $data->form->occupation ?? 'UNDEFINED',
            'Acreage' => $data->form->acreage ?? 'UNDEFINED',
            'Crops' => implode(';', $data->form->crops) ?? 'UNDEFINED',
            'Zipcode' => $data->form->postalCode ?? 'UNDEFINED',
            'Phone' => $data->form->phone ?? 'UNDEFINED',
            'MobilePhone' => $data->form->mobilePhone ?? 'UNDEFINED',
            'SmsOptin' => $data->form->smsOptin ?? 'UNDEFINED'
        ]);
        error_log('Request Body: ' . print_r($body, true));

       $response = $this->postToSalesforce($gated_content_endpoint, $headers, $body);
    }


    /**
     * Set Up Send For Particular Form
     *
     * @param array $request
     *
     * @return void
     */
    public function setUpTriggeredSend($request)
    {
        $data = json_decode($request->get_body());

        if ($data->action === 'gda-gate') {
            $this->formatGDAFormSend($data);
        } else {
            $this->formatGateFormSend($data);
        }
    }


    /**
     * Post to Salesforce
     *
     * @param string $endpoint
     * @param array $headers
     * @param array $body
     *
     * @return object|null $response - response body object on success, null on failure
     */
    public function postToSalesforce($endpoint, $headers, $body)
    {
        $response = null;

        try {
            $response = wp_remote_post($endpoint, array(
                'headers' => $headers,
                'body' => $body
            ));

            if (is_wp_error($response)) {
                wp_send_json_error('Error sending to Salesforce');
            } else {
                wp_send_json_success($response['body']);
            }
        } catch (Exception $e) {
            wp_send_json_error('Error sending to Salesforce');
        }
    }


    /**
     * Get Salesforce Token
     *
     * @param string $endpoint
     * @param array $headers
     * @param array $body
     *
     * @return object|null $response - response body object on success, null on failure
     */
    public function getApiToken($endpoint, $headers, $body)
    {
        $response = null;

        try {
            $api_response = wp_remote_post($endpoint, array(
                'headers' => $headers,
                'body' => $body
            ));

            if (is_wp_error($api_response)) {
                throw new Exception(__('WP Error.', 'kmag'), 401);
            } else {
                $response = json_decode($api_response["body"]);
            }
        } catch (Exception $e) {
            printf(
                __('Request failed: %1$s. Code: %2$s.', 'kmag'),
                $e->getMessage(),
                $e->getCode()
            );
        }

        return $response;
    }

    /**
     * Api to handle scoring of pages
     * @param $request
     * @return void
     */
    public function scorePages($request)
    {
        $options = Options::getSiteOptions();
        $scoring_endpoint_url = ACF::getField('default-gate_scoring-endpoint', $options);
        $this->getGateAuthToken();
        $data = json_decode($request->get_body());
        if (empty($this->gate_auth_token)) {
            _e('Could not get token to send to SF.', 'kmag');
            return;
        }
        $headers = [
            'Content-Type' => 'application/json;charset=UTF-8',
            'Authorization' => "Bearer {$this->gate_auth_token}"
        ];
        $post_id = $data->page_id;
        if (empty($post_id)) {
            _e('Could not get post id.', 'kmag');
            return;
        }
        $meta_content_score_id = get_post_meta($post_id, 'scored-content_score-id', true);
        $meta_campaign_id = get_post_meta($post_id, 'scored-content_campaign', true);
        if ($meta_content_score_id && ($data->Campaign__c || $meta_campaign_id) && $data->Lead__c) {
            $body = json_encode([
                'Campaign__c' => $meta_campaign_id ?: $data->Campaign__c,
                'Lead__c' => $data->Lead__c,
                'Name' => $meta_content_score_id,
                'Engagement_Time__c' => time(),
            ]);
            $response = $this->postToSalesforce($scoring_endpoint_url, $headers, $body);
        }
    }
}
