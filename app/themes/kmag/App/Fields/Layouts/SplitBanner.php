<?php

namespace CN\App\Fields\Layouts;

use Extended\ACF\ConditionalLogic;

use CN\App\Fields\Common;
use Extended\ACF\Fields\Layout;
use Extended\ACF\Fields\ButtonGroup;
use Extended\ACF\Fields\ColorPicker;
use Extended\ACF\Fields\Image as WPImage;
use Extended\ACF\Fields\Group;
use Extended\ACF\Fields\Link;
use Extended\ACF\Fields\Repeater;
use Extended\ACF\Fields\Select;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\TrueFalse;
use Extended\ACF\Fields\WysiwygEditor;

/**
 * Class SplitBanner
 *
 * @package CN\App\Fields\Layouts
 */
class SplitBanner extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'cn/layout/split-banner',
            Layout::make(__('Split Banner', 'kmag'), 'split-banner')
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                    ButtonGroup::make(__('Type', 'kmag'), 'type')
                        ->choices([
                            'large-banner' => __('Large Banner', 'kmag'),
                            'short-media-banner' => __('Short Media Banner', 'kmag'),
                            'short-content-banner' => __('Short Content Banner', 'kmag'),
                            'short-content-split-banner' => __('Short Content Split Banner', 'kmag'),
                            'short-location-banner' => __('Short Location Banner', 'kmag'),
                            'video-banner' => __('Video Banner', 'kmag')
                        ])
                        ->defaultValue('large-banner'),
                    ButtonGroup::make(__('Image Position', 'kmag'), 'image-position')
                        ->choices([
                            'left' => __('Left', 'kmag'),
                            'right' => __('Right', 'kmag')
                        ])
                        ->defaultValue('left')
                        ->wrapper([
                            'width' => '15'
                        ])
                        ->conditionalLogic([
                            ConditionalLogic::where('type', '!=', 'short-content-banner')
                                ->and('type', '!=', 'short-content-split-banner')
                                ->and('type', '!=', 'video-banner')
                        ]),
                    WPImage::make(__('Image', 'kmag'), 'image')
                        ->returnFormat('array')
                        ->wrapper([
                            'width' => '25'
                        ])
                        ->conditionalLogic([
                            ConditionalLogic::where('type', '!=', 'short-content-banner')
                                ->and('type', '!=', 'video-banner')
                                ->and('type', '!=', 'short-content-split-banner')
                        ]),
                    WPImage::make(__('Video Thumbnail', 'kmag'), 'video-thumbnail')
                        ->returnFormat('array')
                        ->wrapper([
                            'width' => '25'
                        ])
                        ->conditionalLogic([
                            ConditionalLogic::where('type', '==', 'video-banner')
                        ]),
                    WPImage::make(__('Mobile Image', 'kmag'), 'mobile-image')
                        ->returnFormat('array')
                        ->wrapper([
                            'width' => '25'
                        ])
                        ->conditionalLogic([
                            ConditionalLogic::where('type', '!=', 'short-content-banner')
                                ->and('type', '!=', 'video-banner')
                                ->and('type', '!=', 'short-content-split-banner')
                        ]),
                    WPImage::make(__('Left Image', 'kmag'), 'left-image')
                        ->returnFormat('array')
                        ->wrapper([
                            'width' => '25'
                        ])
                        ->conditionalLogic([
                            ConditionalLogic::where('type', '==', 'short-content-split-banner')
                        ]),
                    WPImage::make(__('Left Mobile Image', 'kmag'), 'left-mobile-image')
                        ->returnFormat('array')
                        ->wrapper([
                            'width' => '25'
                        ])
                        ->conditionalLogic([
                            ConditionalLogic::where('type', '==', 'short-content-split-banner')
                        ]),
                    WPImage::make(__('Left Content Logo', 'kmag'), 'left-content-logo')
                        ->returnFormat('array')
                        ->wrapper([
                            'width' => '15'
                        ])
                        ->conditionalLogic([
                            ConditionalLogic::where('type', '==', 'short-content-split-banner')
                        ]),
                    ColorPicker::make(__('Content Background Color', 'kmag'), 'content-background-color')
                        ->defaultValue('#161E10')
                        ->wrapper([
                            'width' => '15'
                        ]),
                    ButtonGroup::make(__('Font Color', 'kmag'), 'font-color')
                        ->choices([
                            'black' => __('Black', 'kmag'),
                            'white' => __('White', 'kmag')
                        ])
                        ->defaultValue('black')
                        ->wrapper([
                            'width' => '15'
                        ]),
                    Common::performanceProductPickList('Performance Product', __('The performance product that pre-populates the where-to-buy filter dropdown', 'kmag'))
                        ->conditionalLogic([
                            ConditionalLogic::where('type', '==', 'short-location-banner')
                        ]),
                    Text::make(__('Subtitle', 'kmag'), 'subtitle')
                        ->conditionalLogic([
                            ConditionalLogic::where('type', '==', 'large-banner')
                        ]),
                    Text::make(__('Video Link', 'kmag'), 'video-link')
                        ->conditionalLogic([
                            ConditionalLogic::where('type', '==', 'video-banner')
                        ]),
                    Text::make(__('Headline', 'kmag'), 'headline')
                        ->conditionalLogic([
                            ConditionalLogic::where('type', '!=', 'short-content-split-banner')
                        ]),
                    WysiwygEditor::make(__('Content', 'kmag'), 'content')
                        ->mediaUpload(false),
                    Link::make(__('Link Button', 'kmag'), 'link-button')
                        ->wrapper([
                            'width' => '60'
                        ])
                        ->conditionalLogic([
                            ConditionalLogic::where('type', '!=', 'short-location-banner')
                                ->where('type', '!=', 'video-banner')
                        ]),
                    Link::make(__('Download Button', 'kmag'), 'download-button')
                        ->wrapper([
                            'width' => '40'
                        ])
                        ->conditionalLogic([
                            ConditionalLogic::where('type', '==', 'large-banner')
                        ]),
                    WPImage::make(__('Right Image', 'kmag'), 'right-image')
                        ->returnFormat('array')
                        ->wrapper([
                            'width' => '50'
                        ])
                        ->conditionalLogic([
                            ConditionalLogic::where('type', '==', 'short-content-split-banner')
                        ]),
                    WPImage::make(__('Right Mobile Image', 'kmag'), 'right-mobile-image')
                        ->returnFormat('array')
                        ->wrapper([
                            'width' => '50'
                        ])
                        ->conditionalLogic([
                            ConditionalLogic::where('type', '==', 'short-content-split-banner')
                        ]),
                    WPImage::make(__('Right Content Logo', 'kmag'), 'right-content-logo')
                        ->returnFormat('array')
                        ->wrapper([
                            'width' => '50'
                        ])
                        ->conditionalLogic([
                            ConditionalLogic::where('type', '==', 'short-content-split-banner')
                        ]),
                    Text::make(__('Headline Right Column', 'kmag'), 'headline-right-column')
                        ->conditionalLogic([
                            ConditionalLogic::where('type', '!=', 'large-banner')
                                ->and('type', '!=', 'short-media-banner')
                                ->and('type', '!=', 'video-banner')
                                ->and('type', '!=', 'short-location-banner')
                        ]),
                    WysiwygEditor::make(__('Content Right Column', 'kmag'), 'content-right-column')
                        ->mediaUpload(false)
                        ->conditionalLogic([
                            ConditionalLogic::where('type', '!=', 'large-banner')
                                ->and('type', '!=', 'short-media-banner')
                                ->and('type', '!=', 'video-banner')
                                ->and('type', '!=', 'short-location-banner')
                        ]),
                    Link::make(__('Link Button Right Column', 'kmag'), 'link-button-right-column')
                        ->conditionalLogic([
                            ConditionalLogic::where('type', '!=', 'large-banner')
                                ->and('type', '!=', 'short-media-banner')
                                ->and('type', '!=', 'video-banner')
                                ->and('type', '!=', 'short-location-banner')
                        ]),
                    $this->optionsTab(),
                    Select::make(__('Button Color', 'kmag'), 'button-color')
                        ->choices([
                            'primary' => __('Primary', 'kmag'),
                            'secondary' => __('Secondary', 'kmag'),
                            'tertiary' => __('Tertiary', 'kmag'),
                            'white-outline' => __('White Outline', 'kmag'),
                            'orange' => __('Orange', 'kmag'),
                            'blue' => __('Blue', 'kmag')
                        ])
                        ->defaultValue('primary')
                        ->returnFormat('value'),
                    Group::make(__('Button Icons', 'kmag'), 'button-icons')
                        ->layout('block')
                        ->fields([
                            Common::iconOptions('Left Icon')
                                ->wrapper([
                                    'width' => '50'
                                ]),
                            Common::iconOptions('Right Icon')
                                ->wrapper([
                                    'width' => '50'
                                ])
                        ])
                        ->conditionalLogic([
                            ConditionalLogic::where('type', '!=', 'short-location-banner')
                        ]),
                    TrueFalse::make(__('Region Crop CTA', 'kmag'), 'region-crop-cta')
                        ->instructions('Checking the box will change the button behavior to open the Region Crop selector.', 'kmag'),
                    Select::make(__('Location Icon Color', 'kmag'), 'location-icon-color')
                        ->choices([
                            'white' => __('White', 'kmag'),
                            'black' => __('Black', 'kmag'),
                            'green' => __('Green', 'kmag')
                        ])
                        ->defaultValue('white')
                        ->returnFormat('value')
                        ->conditionalLogic([
                            ConditionalLogic::where('type', '==', 'short-location-banner')
                        ]),
                    Select::make(__('Second Button Color', 'kmag'), 'second-button-color')
                        ->choices([
                            'primary' => __('Primary', 'kmag'),
                            'secondary' => __('Secondary', 'kmag'),
                            'tertiary' => __('Tertiary', 'kmag'),
                            'white-outline' => __('White Outline', 'kmag')
                        ])
                        ->defaultValue('primary')
                        ->returnFormat('value')
                        ->conditionalLogic([
                            ConditionalLogic::where('type', '==', 'large-banner')
                        ]),
                    Group::make(__('Second Button Icons', 'kmag'), 'second-button-icons')
                        ->layout('block')
                        ->fields([
                            Common::iconOptions('Left Icon')
                                ->wrapper([
                                    'width' => '50'
                                ]),
                            Common::iconOptions('Right Icon')
                                ->wrapper([
                                    'width' => '50'
                                ])
                        ])
                        ->conditionalLogic([
                            ConditionalLogic::where('type', '==', 'large-banner')
                        ]),
                    $this->styleTab(),
                    Common::paddingGroup(DEFAULT_SPLIT_BANNER_PADDING)
                ])
        );
    }
}
