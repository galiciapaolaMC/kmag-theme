<?php

namespace CN\App\Fields\Layouts;

use CN\App\Fields\Common;
use CN\App\Fields\Layouts\Partials\FrontierFieldCards;
use Extended\ACF\ConditionalLogic;
use CN\App\Fields\Layouts\Partials\Card;
use CN\App\Fields\Layouts\Partials\ImageFiftyFifty;
use CN\App\Fields\Layouts\Partials\LinkableCard;
use CN\App\Fields\Layouts\Partials\TextFiftyFifty;
use CN\App\Fields\Layouts\Partials\VideoFiftyFifty;

use Extended\ACF\Fields\ButtonGroup;
use Extended\ACF\Fields\ColorPicker;
use Extended\ACF\Fields\File;
use Extended\ACF\Fields\FlexibleContent;
use Extended\ACF\Fields\Group;
use Extended\ACF\Fields\Image;
use Extended\ACF\Fields\Layout;
use Extended\ACF\Fields\Link;
use Extended\ACF\Fields\Repeater;
use Extended\ACF\Fields\Select;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\Textarea;
use Extended\ACF\Fields\TrueFalse;
use Extended\ACF\Fields\WysiwygEditor;

/**
 * Class ColumnContent
 *
 * @package CN\App\Fields\Layouts
 */
class FarmerSliderBlock extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'cn/layout/farmer-slider-block',
            Layout::make(__('Farmer Slider Block', 'kmag'), 'farmer-slider-block')
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                    Text::make(__('Section Class', 'kmag')),
                    Group::make(__('Slides', 'kmag'), 'slides')
                        ->layout('block')
                        ->fields([
                            Repeater::make(__('FarmerDetails', 'kmag'), 'farmer_details')
                                ->layout('block')
                                ->min(1)
                                ->buttonLabel(__('Add Bio'))
                                ->fields([
                                    File::make(__('Image', 'kmag'), 'image')->mimeTypes(['jpeg', 'jpg', 'png'])->library('all')->wrapper(['width' => '50']),
                                    File::make(__('Farmer Logo', 'kmag'), 'farmer_logo')->mimeTypes(['jpeg', 'jpg', 'png'])->library('all')->wrapper(['width' => '50']),
                                    Text::make(__('Title', 'kmag'), 'title'),
                                    Text::make(__('Sub Title', 'kmag'), 'sub_title'),
                                    WysiwygEditor::make(__('Body', 'kmag'), 'body')->mediaUpload(false),
                                    Link::make(__('Link', 'kmag'), 'link'),
                                    Group::make(__('Crop Linked', 'kmag'), 'crop_details')
                                        ->layout('block')
                                        ->wrapper(['width' => '40'])
                                        ->fields([
                                            Select::make(__('Crops', 'kmag'), 'crops')->allowMultiple()
                                                ->choices($this->getAllCropPosts()),
                                            File::make(__('Background Image', 'kmag'), 'background_image')
                                                ->mimeTypes(['jpeg', 'jpg', 'png'])->library('all')
                                        ]),
                                    Group::make(__('Acres Details', 'kmag'), 'acres_details')
                                        ->layout('block')
                                        ->wrapper(['width' => '30'])
                                        ->fields([
                                            Text::make(__('Acres', 'kmag'), 'acres'),
                                            ColorPicker::make(__('Background Color', 'kmag'), 'background_color'),
                                            ColorPicker::make(__('Font Color', 'kmag'), 'font_color'),
                                        ]),
                                    TextArea::make(__('Tillage', 'kmag'), 'tillage')->rows(10)->wrapper(['width' => '30']),
                                    Group::make(__('Social Media', 'kmag'), 'social_media')
                                        ->layout('block')
                                        ->instructions(__('Enter Social Media Link If Any.', 'kmag'))
                                        ->fields([
                                            Text::make(__('Facebook Page', 'kmag'), 'facebook_link')->wrapper(['width' => '50']),
                                            Text::make(__('Twitter Page', 'kmag'), 'twitter_link')->wrapper(['width' => '50']),
                                            Text::make(__('Instagram Page', 'kmag'), 'instagram_link')->wrapper(['width' => '50']),
                                            Text::make(__('TikTok Page', 'kmag'), 'tiktok_link')->wrapper(['width' => '50']),
                                        ]),
                                ])

                        ]),
                    $this->optionsTab(),
                    ColorPicker::make(__('Background Color', 'kmag'), 'background_color')
                        ->defaultValue('transparent')
                        ->instructions(__('Default color is transparent', 'kmag')),
                    $this->styleTab(),
                    Common::paddingGroup(DEFAULT_FRONTIER_FIELD_PADDING)
                ])
        );
    }

    /**
     * Return all the post type [CROPS]
     * @return array
     */
    private function getAllCropPosts()
    {
        $posts = get_posts(array(
            'post_type' => 'crops',
            'numberposts' => -1,
        ));
        $choices = array();
        foreach ($posts as $post) {
            $choices[$post->post_name] = $post->post_title;
        }
        return $choices;
    }
}
