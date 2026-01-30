<?php

namespace CN\App\Fields\Options;

use Extended\ACF\Fields\Tab;
use Extended\ACF\Fields\Image;
use Extended\ACF\Fields\Link;
use Extended\ACF\Fields\Repeater;
use Extended\ACF\Fields\Textarea;
use Extended\ACF\Fields\Text;

/**
 * Class Footer
 *
 * @package CN\App\Fields\Options
 */
class Footer
{
    /**
     * Defines fields used within Options tab.
     *
     * @return array
     */
    public function fields()
    {
        return apply_filters(
            'cn/options/footer',
            [
                Tab::make(__('Footer', 'kmag'))
                    ->placement('left'),
                Image::make(__('Footer Logo', 'kmag'), 'footer-logo')
                    ->returnFormat('array')
                    ->previewSize('thumbnail')
                    ->wrapper([
                        'width' => '30'
                    ]),
                Repeater::make(__('Footer Menu', 'kmag'), 'footer-menu')
                    ->layout('block')
                    ->min(1)
                    ->max(5)
                    ->buttonLabel(__('Add Menu Item', 'kmag'), 'add-menu-item')
                    ->fields([
                        Link::make(__('Link', 'kmag'), 'link')
                    ]),
                Link::make(__('Newsletter', 'kmag'), 'newsletter-footer'),
                Repeater::make(__('Legal Menu', 'kmag'), 'legal-menu')
                    ->layout('block')
                    ->min(1)
                    ->max(2)
                    ->buttonLabel(__('Add Menu Item', 'kmag'), 'add-menu-item')
                    ->fields([
                        Link::make(__('Link', 'kmag'), 'link')
                    ]),
                Text::make(__('Copyright', 'kmag'), 'copyright'),
                Link::make(__('Facebook Link', 'kmag'), 'facebook-link')
                    ->wrapper([
                        'width' => '30'
                    ]),
                Link::make(__('Twitter Link', 'kmag'), 'twitter-link')
                    ->wrapper([
                        'width' => '30'
                    ]),
                Link::make(__('YouTube Link', 'kmag'), 'youtube-link')
                    ->wrapper([
                        'width' => '30'
                    ]),
                Link::make(__('Instagram Link', 'kmag'), 'instagram-link')
                    ->wrapper([
                        'width' => '30'
                    ])
            ]
        );
    }
}
