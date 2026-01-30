<?php

namespace CN\App\Fields\Layouts;

use CN\App\Fields\Common;
use Extended\ACF\ConditionalLogic;
use Extended\ACF\Fields\ButtonGroup;
use Extended\ACF\Fields\File;
use Extended\ACF\Fields\Group as FieldsGroup;
use Extended\ACF\Fields\Image as WPImage;
use Extended\ACF\Fields\Layout;
use Extended\ACF\Fields\Link;
use Extended\ACF\Fields\Number;
use Extended\ACF\Fields\Oembed;
use Extended\ACF\Fields\Repeater;
use Extended\ACF\Fields\Select;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\Textarea;
use Extended\ACF\Fields\Url;

/**
 * Class CarouselHero
 *
 * @package CN\App\Fields\Layouts
 */
class CarouselHero extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'cn/layout/carousel-hero',
            Layout::make(__('Carousel Hero'), 'carousel-hero')
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                    Repeater::make(__('Carousel Slides', 'kmag'), 'carousel-items')
                        ->instructions(__('Adding only one slide below will result in a non-carousel hero.', 'kmag'))
                        ->layout('block')
                        ->min(1)
                        ->buttonLabel(__('Add Carousel Slide', 'kmag'))
                        ->fields([
                            ButtonGroup::make(__('Media Type', 'kmag'), 'media-type')
                                ->choices([
                                  'image-upload' => __('Image Upload', 'kmag'),
                                  'video-link' => __('Video Link', 'kmag'),
                                  'video-upload' => __('Video Upload', 'kmag'),
                                ])
                                ->defaultValue('image-upload'),
                            Oembed::make(__('Video Link', 'kmag'), 'video-link')
                              ->instructions(__('Enter a youtube embed link and add "?autoplay=1&mute=1&controls=0&modestbranding=1&showinfo=0&rel=0&loop=1" to the end of the link.', 'kmag'))
                              ->conditionalLogic([
                                ConditionalLogic::where('media-type', '==', 'video-link')
                              ]),
                            File::make(__('Video File', 'kmag'), 'video-file')
                              ->conditionalLogic([
                                ConditionalLogic::where('media-type', '==', 'video-upload')
                              ]),
                            WPImage::make(__('Hero Image', 'kmag'), 'hero-image')
                              ->conditionalLogic([ConditionalLogic::where('media-type', '==', 'image-upload')])
                              ->wrapper([
                                'width' => '50'
                              ]),
                            WPImage::make(__('Mobile Image', 'kmag'), 'mobile-hero-image')
                              ->conditionalLogic([ConditionalLogic::where('media-type', '==', 'image-upload')])
                              ->wrapper([
                                'width' => '50'
                              ]),
                            WPImage::make(__('logo', 'kmag'), 'logo'),
                            Textarea::make(__('Headline', 'kmag'), 'headline')
                                ->rows(3)
                                ->wrapper([
                                  'width' => '50'
                                ])
                                ->instructions(__('HTML &lt;em&gt; &lt;/em&gt; tags can be used to add emphasis.', 'kmag')),
                            FieldsGroup::make(__('Headline Styles', 'cropnutrition'), 'heading-styles')
                              ->wrapper([
                                'width' => '50'
                              ])
                              ->fields([
                                    ButtonGroup::make(__('Text Size', 'cropnutrition'), 'text-size')
                                        ->choices([
                                            'medium' => __('Medium', 'cropnutrition'),
                                            'large' => __('Large', 'cropnutrition'),
                                        ])
                                        ->returnFormat('value')
                                        ->defaultValue('medium')
                                        ->wrapper([
                                            'width' => '50'
                                        ]),
                                    Select::make(__('Emphasis Text Color', 'cropnutrition'), 'emphasis-text-color')
                                        ->choices([
                                            'light-gray' => __('Light Gray', 'cropnutrition'),
                                            'orange' => __('Orange', 'cropnutrition'),
                                        ])
                                        ->returnFormat('value')
                                ]),
                            ButtonGroup::make(__('Link Type', 'kmag'), 'link-type')
                                ->instructions(__('Internal Links are those that exist on the site. External Links are those that lead to another site, such as Pathfactory.', 'kmag'))
                                ->choices([
                                  'internal' => __('Internal', 'kmag'),
                                  'external' => __('External', 'kmag'),
                                ])
                                ->defaultValue('internal')
                                ->wrapper([
                                  'width' => '50'
                                ]),
                            ButtonGroup::make(__('Link Element', 'kmag'), 'link-element')
                                ->instructions(__('Full Banner will link the entire slide. Button will link only the button.', 'kmag'))
                                ->choices([
                                  'full-banner' => __('Full Banner', 'kmag'),
                                  'button' => __('Button', 'kmag'),
                                ])
                                ->defaultValue('internal')
                                ->wrapper([
                                  'width' => '50'
                                ]),
                            Link::make(__('Link', 'kmag'), 'link')
                                ->conditionalLogic([
                                  ConditionalLogic::where('link-type', '==', 'internal')
                                ]),
                            FieldsGroup::make(__('External Link', 'kmag'), 'external-link')
                                ->fields([
                                  Text::make(__('Link Text', 'kmag'), 'link-text')
                                    ->conditionalLogic([
                                      ConditionalLogic::where('link-element', '==', 'button')
                                    ]),
                                  Url::make(__('URL', 'kmag'), 'url')
                                ])
                                ->conditionalLogic([
                                  ConditionalLogic::where('link-type', '==', 'external')
                                ]),
                            FieldsGroup::make(__('Button Styles', 'cropnutrition'), 'button-styles')
                                ->conditionalLogic([
                                  ConditionalLogic::where('link-element', '==', 'button')
                                ])
                                ->fields([
                                  Select::make(__('Button Theme', 'cropnutrition'), 'button-theme')
                                    ->choices([
                                        'light-gray' => __('Light Gray', 'cropnutrition'),
                                        'Orange' => __('Orange', 'cropnutrition'),
                                    ])
                                    ->returnFormat('value')
                                ]),
                        ]),
                    $this->optionsTab(),
                    Number::make(__('Display Interval', 'kmag'), 'display-interval')
                        ->instructions(__('The amount of time in milliseconds (1000 milliseconds = 1 second) before the next slide is shown.', 'kmag'))
                        ->defaultValue(5000),
                    $this->styleTab(),
                    Common::paddingGroup(DEFAULT_CAROUSEL_PADDING)
                ])
        );
    }
}
