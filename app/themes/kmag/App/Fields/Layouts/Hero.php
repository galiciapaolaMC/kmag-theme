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
 * Class Hero
 *
 * @package CN\App\Fields\Layouts
 */
class Hero extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'cn/layout/hero',
            Layout::make(__('Hero', 'kmag'), 'hero')
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                    ButtonGroup::make(__('Type', 'kmag'), 'type')
                        ->choices([
                            'full-hero' => __('Full Hero', 'kmag'),
                            'short-hero' => __('Short Hero', 'kmag'),
                            'product-hero' => __('Product Hero', 'kmag'),
                            'product-campaign' => __('Product Campaign', 'kmag')
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
                        ->rows(2)
                        ->conditionalLogic([
                            ConditionalLogic::where('type', '!=', 'product-campaign')
                        ]),
                    Link::make(__('Link', 'kmag'), 'link')
                        ->conditionalLogic([
                            ConditionalLogic::where('type', '!=', 'product-hero')
                                ->and('type', '!=', 'product-campaign')
                        ]),
                    ButtonGroup::make(__('Link Image', 'kmag'), 'link-image')
                        ->choices([
                            'yes' => __('Yes', 'kmag'),
                            'no' => __('No', 'kmag')
                        ])
                        ->defaultValue('no')
                        ->conditionalLogic([
                            ConditionalLogic::where('type', '==', 'short-hero')
                        ]),
                    Text::make(__('Subtitle', 'kmag'), 'subtitle')
                        ->conditionalLogic([
                            ConditionalLogic::where('type', '==', 'product-campaign')
                        ]),
                    Textarea::make(__('Content', 'kmag'), 'content')
                        ->rows(2)
                        ->conditionalLogic([
                            ConditionalLogic::where('type', '==', 'product-campaign')
                        ]),
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
                    Relationship::make(__('Performance Products', 'kmag'), 'perfomance-product-banner')
                        ->postTypes(['performance-products'])
                        ->filters([
                            'search',
                            'taxonomy'
                        ])
                        ->min(1)
                        ->max(1)
                        ->required()
                        ->conditionalLogic([
                            ConditionalLogic::where('type', '!=', 'full-hero')
                                ->and('type', '!=', 'short-hero')
                        ]),
                    ButtonGroup::make(__('Performance Product Logo Variant', 'kmag'), 'performance-product-logo-variant')
                        ->choices([
                            'dark' => __('Dark', 'kmag'),
                            'light' => __('Light', 'kmag')
                        ])
                        ->defaultValue('dark')
                        ->conditionalLogic([
                            ConditionalLogic::where('type', '==', 'product-hero')                        
                        ])
                        ->wrapper([
                            'width' => '33'
                        ]),
                    ButtonGroup::make(__('Performance Product Logo Size', 'kmag'), 'performance-product-logo-size')
                        ->choices([
                            'small' => __('Small', 'kmag'),
                            'large' => __('Large', 'kmag')
                        ])
                        ->defaultValue('small')
                        ->conditionalLogic([
                            ConditionalLogic::where('type', '==', 'product-hero')                        
                        ])
                        ->wrapper([
                            'width' => '33'
                        ]),
                    ButtonGroup::make(__('Additional Logo', 'kmag'), 'additional-logo')
                        ->choices([
                            'show' => __('Show', 'kmag'),
                            'hide' => __('Hide', 'kmag')
                        ])
                        ->defaultValue('hide')
                        ->conditionalLogic([
                            ConditionalLogic::where('type', '==', 'product-hero')                        
                        ])
                        ->wrapper([
                            'width' => '33'
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
