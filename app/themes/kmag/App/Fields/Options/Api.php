<?php

namespace CN\App\Fields\Options;

use Extended\ACF\Fields\Group;
use Extended\ACF\Fields\Password;
use Extended\ACF\Fields\Tab;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\Url;

/**
 * Class APi
 *
 * @package CN\App\Fields\Options
 */
class APi
{
    /**
     * Defines fields used within Options tab.
     *
     * @return array
     */
    public function fields()
    {
        return apply_filters(
            'cn/options/api',
            [
                Tab::make(__('API', 'kmag'))
                    ->placement('left'),
                Group::make(__('Default Gate', 'kmag'), 'default-gate')
                    ->layout('block')
                    ->fields([
                        Text::make(__('Campaign ID', 'kmag'), 'campaign-id'),
                        Text::make(__('Username', 'kmag'), 'username'),
                        Password::make(__('Password', 'kmag'), 'password'),
                        Text::make(__('Client ID', 'kmag'), 'client-id'),
                        Password::make(__('Client Secret', 'kmag'), 'client-secret'),
                        Text::make(__('Token', 'kmag'), 'token'),
                        Text::make(__('Account ID', 'kmag'), 'account-id'),
                        Url::make(__('Token Endpoint', 'kmag'), 'token-endpoint'),
                        Url::make(__('Content Endpoint', 'kmag'), 'content-endpoint'),
                        Text::make(__('Scoring Endpoint', 'kmag'), 'scoring-endpoint'),
                    ]),
                Group::make(__('GDA Test Gate', 'kmag'), 'gda-test-gate')
                    ->layout('block')
                    ->fields([
                        Text::make(__('Campaign ID', 'kmag'), 'campaign-id'),
                        Text::make(__('Username', 'kmag'), 'username'),
                        Password::make(__('Password', 'kmag'), 'password'),
                        Text::make(__('Client ID', 'kmag'), 'client-id'),
                        Password::make(__('Client Secret', 'kmag'), 'client-secret'),
                        Text::make(__('Token', 'kmag'), 'token'),
                        Text::make(__('Account ID', 'kmag'), 'account-id'),
                        Url::make(__('Token Endpoint', 'kmag'), 'token-endpoint'),
                        Url::make(__('Content Endpoint', 'kmag'), 'content-endpoint'),
                    ]),
            ]
        );
    }
}
