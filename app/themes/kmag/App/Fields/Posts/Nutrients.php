<?php

namespace CN\App\Fields\Posts;

use CN\App\Fields\Common;
use Extended\ACF\Fields\Image;
use Extended\ACF\Fields\PostObject;
use Extended\ACF\Fields\Repeater;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\Textarea;
use Extended\ACF\Fields\WysiwygEditor;

/**
 * Class Nutrients
 *
 * @package CN\App\Fields\Posts
 */
class Nutrients
{
    /**
     * Defines fields used within Nutrient post type.
     *
     * @return array
     */
    public function fields()
    {
        return apply_filters(
            'cn/posts/nutrients',
            [
                Text::make(__('Slug', 'kmag')),
                Text::make(__('Symbol', 'kmag')),
                Text::make(__('Atomic Number', 'kmag')),
                Textarea::make(__('Excerpt', 'kmag'))
                    ->characterLimit(50000)
                    ->rows(2),
                Textarea::make(__('Description', 'kmag'))
                    ->characterLimit(50000)
                    ->rows(2),
                Textarea::make(__('Intro Heading', 'kmag'))
                    ->characterLimit(256)
                    ->rows(2),
                Textarea::make(__('Intro Content', 'kmag'))
                    ->characterLimit(50000)
                    ->rows(2),
                Image::make(__('Benefit Image', 'kmag')),
                WysiwygEditor::make(__('Benefits', 'kmag'))
                    ->mediaUpload(false),
                Repeater::make(__('Benefit Knowledge', 'kmag'), 'benefit-knowledge')
                    ->min(1)
                    ->max(7)
                    ->layout('block')
                    ->fields([
                        Text::make(__('Headline', 'kmag'), 'headline')
                            ->wrapper([
                                'width' => '50',
                            ]),
                        Textarea::make(__('Content', 'kmag'), 'content')
                            ->rows(3)
                            ->wrapper([
                                'width' => '50',
                            ])
                    ]),
                Image::make(__('Nutrient Management Image', 'kmag')),
                Text::make(__('Nutrient Management Title', 'kmag')),
                Textarea::make(__('Nutrient Management Description', 'kmag'))
                    ->characterLimit(50000)
                    ->rows(2),
                PostObject::make(__('Nutrient Deficiencies', 'kmag'))
                    ->postTypes(['nutrient-deficits'])
                    ->allowMultiple()
            ]
        );
    }
}
