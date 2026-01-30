<?php

namespace CN\App\Fields\Posts;

use CN\App\Fields\Common;
use CN\App\Fields\Layouts\Layouts;
use Extended\ACF\Fields\Number;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\Url;
use Extended\ACF\Fields\WysiwygEditor;
use Extended\ACF\Fields\Image as WPImage;
use Extended\ACF\Fields\Relationship;

/**
 * Class FrontierFieldsEpisodes
 *
 * @package CN\App\Fields\Posts
 */
class FrontierFieldsEpisodes extends Layouts
{
    /**
     * Defines fields used within FrontierFieldsEpsisodes post type.
     *
     * @return array
     */
    public function fields()
    {
        return apply_filters(
            'cn/posts/frontier-fields-eps',
            [
                $this->contentTab(),
                Text::make(__('Episode Title', 'kmag'), 'episode-title')
                    ->wrapper([
                        'width' => '75'
                    ]),
                Number::make(__('Episode Number', 'kmag'), 'episode-number')
                    ->wrapper([
                        'width' => '25'
                    ]),
                Url::make(__('Episode Link', 'kmag'), 'episode-link'),
                WysiwygEditor::make(__('Episode Description', 'kmag'), 'episode-description'),
                WPImage::make(__('Episode Thumbnail', 'kmag'), 'episode-thumbnail')
                    ->wrapper([
                        'width' => '50'
                    ]),
                WPImage::make(__('Episode Thumbnail (Mobile)', 'kmag'), 'mobile-episode-thumbnail')
                    ->wrapper([
                        'width' => '50'
                    ]),
                Common::moduleList(),
                $this->relationshipsTab(),
                Relationship::make(__('Associated Farmers', 'kmag'), 'associated-farmers')
                    ->postTypes(['farmer-profiles'])
                    ->filters([
                        'search',
                    ])
                    ->returnFormat('id')
                    ->instructions(__('Select farmers that appear on this episode.', 'rosecrance'))
            ]
        );
    }
}