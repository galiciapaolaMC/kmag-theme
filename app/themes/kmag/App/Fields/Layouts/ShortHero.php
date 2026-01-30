<?php

namespace CN\App\Fields\Layouts;

use CN\App\Fields\Common;
use Extended\ACF\Fields\Link;
use Extended\ACF\Fields\Group;
use Extended\ACF\Fields\Image;
use Extended\ACF\Fields\File;
use Extended\ACF\Fields\Layout;
use Extended\ACF\Fields\Select;
use Extended\ACF\Fields\Textarea;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\ButtonGroup;
use Extended\ACF\Fields\Relationship;
use Extended\ACF\Fields\Oembed;
use Extended\ACF\ConditionalLogic;

/**
 * Class ShortHero
 *
 * @package CN\App\Fields\Layouts
 */
class ShortHero extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'cn/layout/short-hero',
            Layout::make(__('Short Hero', 'kmag'), 'short-hero')
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                    ButtonGroup::make(__('Type', 'kmag'), 'type')
                        ->choices([
                            'short-hero' => __('Short Hero', 'kmag')
                        ])
                        ->defaultValue('full-hero'),
                    ButtonGroup::make(__('Hero Media', 'kmag'), 'hero-media')
                        ->choices([
                            'image-hero' => __('Image Hero', 'kmag'),
                            'video-hero' => __('Video Hero', 'kmag')
                        ])
                        ->defaultValue('image-hero')
                        ->wrapper([
                            'width' => '25'
                        ]),
                    ButtonGroup::make(__('Image Overlay', 'kmag'), 'image-overlay')
                        ->choices([
                            'true' => __('True', 'kmag'),
                            'false' => __('False', 'kmag')
                        ])
                        ->defaultValue('true')
                        ->wrapper([
                            'width' => '25'
                        ])
                        ->conditionalLogic([
                            ConditionalLogic::where('hero-media', '==', 'image-hero')
                        ]),
                    ButtonGroup::make(__('Text Color', 'kmag'), 'text-color')
                        ->choices([
                            'white' => __('White', 'kmag'),
                            'black' => __('Black', 'kmag')
                        ])
                        ->defaultValue('white')
                        ->wrapper([
                            'width' => '25'
                        ]),
                    Select::make(__('Mobile Text Size', 'kmag'), 'mobile-text-size')
                        ->choices([
                            'big' => __('Big', 'kmag'),
                            'medium' => __('Medium', 'kmag'),
                            'small' => __('Small', 'kmag')
                        ])
                        ->defaultValue('big')
                        ->wrapper([
                            'width' => '25'
                        ]),
                    Textarea::make(__('Headline', 'kmag'), 'headline')
                        ->rows(2),
                    Link::make(__('Link', 'kmag'), 'link'),
                    Image::make(__('Image', 'kmag'), 'image')
                        ->previewSize('thumbnail')
                        ->wrapper([
                            'width' => '50'
                        ])
                        ->conditionalLogic([
                            ConditionalLogic::where('hero-media', '==', 'image-hero')
                        ]),
                    Image::make(__('Mobile Image', 'kmag'), 'mobile-image')
                        ->previewSize('thumbnail')
                        ->wrapper([
                            'width' => '50'
                        ])
                        ->conditionalLogic([
                            ConditionalLogic::where('hero-media', '==', 'image-hero')
                        ]),
                    File::make(__('Video', 'kmag'), 'video-file')
                        ->wrapper([
                            'width' => '50'
                        ])
                        ->conditionalLogic([
                            ConditionalLogic::where('hero-media', '==', 'video-hero')
                        ]),
                    File::make(__('Mobile Video', 'kmag'), 'mobile-video-file')
                        ->wrapper([
                            'width' => '50'
                        ])
                        ->conditionalLogic([
                            ConditionalLogic::where('hero-media', '==', 'video-hero')
                        ]),
                    Text::make(__('Vimeo Link ID', 'kmag'), 'vimeo-link-id')
                        ->conditionalLogic([
                            ConditionalLogic::where('hero-media', '==', 'video-hero')
                        ]),
                    $this->optionsTab(),
                    Group::make(__('Background', 'kmag'), 'background')
                        ->layout('block')
                        ->fields([
                            Select::make(__('Repeat', 'kmag'), 'background-repeat')
                                ->choices([
                                    'no-repeat' => __('No Repeat', 'kmag'),
                                    'repeat'    => __('Repeat', 'kmag'),
                                    'repeat-x'  => __('Repeat (X)', 'kmag'),
                                    'repeat-y'  => __('Repeat (Y)', 'kmag'),
                                ])
                                ->defaultValue('no-repeat')
                                ->returnFormat('value')
                                ->wrapper([
                                    'width' => '33.33'
                                ]),
                            Select::make(__('Position', 'kmag'), 'background-position')
                                ->choices([
                                    'left top'      => __('Left / Top', 'kmag'),
                                    'left center'   => __('Left / Center', 'kmag'),
                                    'left bottom'   => __('Left / Bottom', 'kmag'),
                                    'right top'     => __('Right / Top', 'kmag'),
                                    'right center'  => __('Right / Center', 'kmag'),
                                    'right bottom'  => __('Right / Bottom', 'kmag'),
                                    'center top'    => __('Center / Top', 'kmag'),
                                    'center center' => __('Center / Center', 'kmag'),
                                    'center bottom' => __('Center / Bottom', 'kmag'),
                                ])
                                ->defaultValue('center center')
                                ->returnFormat('value')
                                ->wrapper([
                                    'width' => '33.33'
                                ]),
                            Select::make(__('Size', 'kmag'), 'background-size')
                                ->choices([
                                    'auto auto' => __('Auto', 'kmag'),
                                    'cover'     => __('Cover', 'kmag'),
                                    'contain'   => __('Contain', 'kmag'),
                                    'inherit'   => __('Inherit', 'kmag'),
                                ])
                                ->defaultValue('cover')
                                ->returnFormat('value')
                                ->wrapper([
                                    'width' => '33.33'
                                ])
                        ]),
                    $this->styleTab(),
                    Common::paddingGroup(DEFAULT_HERO_PADDING)
                ])
        );
    }
}
