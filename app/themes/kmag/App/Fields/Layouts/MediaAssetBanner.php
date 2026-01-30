<?php

namespace CN\App\Fields\Layouts;

use CN\App\Fields\Common;
use Extended\ACF\Fields\Link;
use Extended\ACF\Fields\WysiwygEditor;
use Extended\ACF\Fields\Image;
use Extended\ACF\Fields\File;
use Extended\ACF\Fields\Layout;
use Extended\ACF\Fields\ButtonGroup;
use Extended\ACF\ConditionalLogic;
use Extended\ACF\Fields\Group;
use Extended\ACF\Fields\Select;
use Extended\ACF\Fields\ColorPicker;
/**
 * Class MediaAssetBanner
 *
 * @package CN\App\Fields\Layouts
 */
class MediaAssetBanner extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'cn/layout/media-asset-banner',
            Layout::make(__('Media Asset Banner', 'kmag'), 'media-asset-banner')
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                    ButtonGroup::make(__('Science of More icon', 'kmag'), 'science-of-more-icon')
                        ->choices([
                            'icon-on' => __('On', 'kmag'),
                            'icon-off' => __('Off', 'kmag')
                        ])
                        ->defaultValue('icon-off'),
                    Image::make(__('Image', 'kmag'), 'image')
                        ->previewSize('thumbnail')
                        ->wrapper([
                            'width' => '50'
                        ])
                        ->conditionalLogic([
                            ConditionalLogic::where('type', '==', 'image')
                        ]),
                    Image::make(__('Mobile Image', 'kmag'), 'mobile-image')
                        ->previewSize('thumbnail')
                        ->wrapper([
                            'width' => '50'
                        ])
                        ->conditionalLogic([
                            ConditionalLogic::where('type', '==', 'image')
                        ]),
                    WysiwygEditor::make(__('Content', 'kmag'), 'content')
                        ->mediaUpload(false),
                    Link::make(__('Link', 'kmag'), 'link'),
                    $this->optionsTab(),
                    ButtonGroup::make(__('Link Style', 'kmag'), 'link-type')
                        ->choices([
                            'inline-link' => __('Inline Link', 'kmag'),
                            'default' => __('Button', 'kmag')
                        ])
                        ->defaultValue('default')
                        ->returnFormat('value'),
                    Select::make(__('Button Color', 'kmag'), 'button-color')
                        ->choices([
                            'primary' => __('Primary', 'kmag'),
                            'secondary' => __('Secondary', 'kmag'),
                            'tertiary' => __('Tertiary', 'kmag'),
                            'biosciences' => __('Biosciences', 'kmag'),
                        ])
                        ->defaultValue('primary')
                        ->returnFormat('value')
                        ->conditionalLogic([
                            ConditionalLogic::where('link-type', '==', 'default')
                        ]),
                    Select::make(__('Button Color', 'kmag'), 'inline-button-color')
                        ->choices([
                            'primary' => __('Primary', 'kmag'),
                            'secondary' => __('Secondary', 'kmag'),
                        ])
                        ->defaultValue('primary')
                        ->returnFormat('value')
                        ->conditionalLogic([
                            ConditionalLogic::where('link-type', '==', 'inline-link')
                        ]),
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
                        ]),
                    $this->styleTab(),
                    Common::paddingGroup(DEFAULT_MEDIA_ASSET_BANNER_PADDING)
                ])
        );
    }
}