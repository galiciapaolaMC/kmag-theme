<?php

namespace CN\App\Fields\Options;

use Extended\ACF\Fields\Tab;
use Extended\ACF\Fields\Group;
use Extended\ACF\Fields\Image;
use Extended\ACF\Fields\Link;
use Extended\ACF\Fields\Textarea;
use Extended\ACF\Fields\WysiwygEditor;

/**
 * Class ModuleSettings
 *
 * @package CN\App\Fields\Options
 */
class ModuleSettings
{
    /**
     * Defines fields used within Options tab.
     *
     * @return array
     */
    public function fields()
    {
        return apply_filters(
            'cn/options/module-settings',
            [
                Tab::make(__('Module Settings', 'kmag'))
                    ->placement('left'),
                Group::make(__('Performand Acre+ Banner', 'kmag'), 'settings-performance-acre-plus-banner')
                    ->fields([
                        Image::make(__('Background Image (Mobile)', 'kmag'), 'background-image-mobile-id')
                            ->returnFormat('id'),
                        Image::make(__('Background Image (Desktop)', 'kmag'), 'background-image-desktop-id')
                            ->returnFormat('id'),
                        Textarea::make(__('Headline', 'kmag'), 'headline')
                            ->rows(2),
                        WysiwygEditor::make(__('Content', 'kmag'), 'content')
                            ->mediaUpload(false),
                        Link::make(__('CTA Link', 'kmag'), 'cta-link'),
                    ]),
            ]
        );
    }
}
