<?php

namespace CN\App\Fields\Layouts\Partials;

use CN\App\Fields\Layouts\Layouts;
use Extended\ACF\Fields\Layout;
use Extended\ACF\Fields\ButtonGroup;
use Extended\ACF\Fields\Checkbox;
use Extended\ACF\Fields\Image;
use Extended\ACF\Fields\Link;
use Extended\ACF\Fields\Textarea;
use Extended\ACF\Fields\Group;
use Extended\ACF\Fields\Select;
use Extended\ACF\Fields\TrueFalse;
use Extended\ACF\Fields\WysiwygEditor;
use Extended\ACF\ConditionalLogic;

/**
 * Class LinkableCard
 *
 * @package CN\App\Fields\Layouts
 */
class LinkableCard extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'cn/layout/linkable-card',
            Layout::make(__('Linkable Card', 'kmag'), 'linkable-card')
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                    ButtonGroup::make(__('Card Size', 'kmag'), 'card-size')
                        ->choices([
                            'large' => __('Large', 'kmag'),
                            'small' => __('Small', 'kmag'),
                        ])
                        ->defaultValue('large'),
                    Image::make(__('Image', 'kmag'), 'card-image')
                        ->previewSize('thumbnail')
                        ->wrapper([
                            'width' => '50'
                        ]),
                    Image::make(__('Mobile Image', 'kmag'), 'card-image-mobile')
                        ->previewSize('thumbnail')
                        ->wrapper([
                            'width' => '50'
                        ]),
                    Textarea::make(__('Headline', 'kmag'), 'card-headline')
                        ->instructions(__(FORMATTING_TAG_INSTRUCTIONS, 'kmag'))
                        ->rows(2),
                    WysiwygEditor::make(__('Paragraph', 'kmag'), 'card-paragraph')
                        ->mediaUpload(false)
                        ->toolbar('simple'),
                    Link::make(__('Button', 'kmag'), 'card-button'),
                    TrueFalse::make(__('Has Card Link', 'kmag'), 'has-card-link'),
                    Link::make(__('Card Link', 'kmag'), 'card-link')
                        ->required()
                        ->instructions(__('If set, the entire card will be linked.', 'kmag'))
                        ->conditionalLogic([
                            ConditionalLogic::where('has-card-link', '==', 1)
                        ]),
                    TrueFalse::make(__('Set Target Top', 'kmag'), 'set-target-top')
                        ->instructions(__('Set the link target to "top" for PathFactory pages.', 'kmag'))
                        ->conditionalLogic([
                            ConditionalLogic::where('has-card-link', '==', 1)
                        ]),
                    $this->optionsTab(),
                    Group::make(__('Button Options', 'kmag'), 'button-options')
                        ->layout('block')
                        ->fields([
                            Select::make(__('Button Color', 'kmag'), 'button-color')
                                ->choices([
                                    'primary' => __('Primary', 'kmag'),
                                    'secondary' => __('Secondary', 'kmag'),
                                    'tertiary' => __('Tertiary', 'kmag'),
                                ])
                                ->defaultValue('primary')
                                ->returnFormat('value')
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
                                ->layout('horizontal')
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
