<?php

namespace CN\App\Fields\Layouts\Partials;

use CN\App\Fields\Layouts\Layouts;
use Extended\ACF\Fields\ButtonGroup;
use Extended\ACF\Fields\Image;
use Extended\ACF\Fields\Layout;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\Group;
use Extended\ACF\Fields\Checkbox;
use Extended\ACF\ConditionalLogic;
use Extended\ACF\Fields\Select;

/**
 * Class VideoFiftyFifty
 *
 * @package CN\App\Fields\Layouts\Partials
 */
class VideoFiftyFifty extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'cn/layout/video-fifty-fifty',
            Layout::make(__('Video Fifty Fifty', 'kmag'))
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                    Text::make(__('Video Id', 'kmag'))
                        ->instructions(__('Add only the Vimeo video Id.', 'kmag'))
                        ->required(),
                    Image::make(__('Video Image Mobile', 'kmag'))
                        ->required(),
                    Image::make(__('Video Image Desktop', 'kmag'))
                        ->required(),
                    $this->optionsTab(),
                    ButtonGroup::make(__('Theme Color', 'kmag'))
                        ->choices([
                            'light' => __('Light', 'kmag'),
                            'dark'  => __('Dark', 'kmag')
                        ])
                        ->defaultValue('light')
                        ->wrapper([
                            'width' => '50'
                        ]),
                    ButtonGroup::make(__('Image Shape', 'kmag'))
                        ->choices([
                            'rectangle' => __('Rectangle', 'kmag'),
                            'round'  => __('Round', 'kmag')
                        ])
                        ->defaultValue('rectangle')
                        ->wrapper([
                            'width' => '50'
                        ]),
                    Group::make(__('Image Corner Rounding', 'kmag'), 'image-corner-rounding')
                        ->layout('block')
                        ->fields([
                            Checkbox::make(__('Desktop Rounding', 'kmag'), 'desktop-rounding')
                                ->instructions(__('Select which corners, if any, have rounding on larger screens', 'kmag'))
                                ->choices([
                                    'top-left' => __('Top Left', 'kmag'),
                                    'top-right' => __('Top Right', 'kmag'),
                                    'bottom-left' => __('Bottom Left', 'kmag'),
                                    'bottom-right' => __('Bottom Right', 'kmag'),
                                ])
                                ->returnFormat('value')
                                ->layout('horizontal'),
                            Checkbox::make(__('Mobile Rounding', 'kmag'), 'mobile-rounding')
                                ->instructions(__('Select which corners, if any, have rounding on mobile screens', 'kmag'))
                                ->choices([
                                    'top-left' => __('Top Left', 'kmag'),
                                    'top-right' => __('Top Right', 'kmag'),
                                    'bottom-left' => __('Bottom Left', 'kmag'),
                                    'bottom-right' => __('Bottom Right', 'kmag'),
                                ])
                                ->returnFormat('value')
                                ->layout('horizontal'),
                        ])
                        ->conditionalLogic([
                            ConditionalLogic::where('image-shape', '==', 'rectangle')
                        ]),
                    Select::make(__('Desktop Image Size', 'kmag'), 'desktop-image-size')
                        ->choices([
                            'auto auto' => __('Auto', 'kmag'),
                            'cover'     => __('Cover', 'kmag'),
                            'contain'   => __('Contain', 'kmag'),
                            'inherit'   => __('Inherit', 'kmag'),
                        ])
                        ->defaultValue('cover')
                        ->returnFormat('value')
                        ->wrapper([
                            'width' => '50'
                        ]),
                    Select::make(__('Mobile Image Size', 'kmag'), 'mobile-image-size')
                        ->choices([
                            'auto auto' => __('Auto', 'kmag'),
                            'cover'     => __('Cover', 'kmag'),
                            'contain'   => __('Contain', 'kmag'),
                            'inherit'   => __('Inherit', 'kmag'),
                        ])
                        ->defaultValue('cover')
                        ->returnFormat('value')
                        ->wrapper([
                            'width' => '50'
                        ])
                ])
        );
    }
}
