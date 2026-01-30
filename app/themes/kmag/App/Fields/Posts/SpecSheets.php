<?php

namespace CN\App\Fields\Posts;

use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\Image;
use Extended\ACF\Fields\File;
use Extended\ACF\Fields\Repeater;
use Extended\ACF\Fields\Textarea;
use Extended\ACF\Fields\WysiwygEditor;

/**
 * Class SpecSheets
 *
 * @package CN\App\Fields\Posts
 */
class SpecSheets
{
    /**
     * Defines fields used within SpecSheets post type.
     *
     * @return array
     */
    public function fields()
    {
        return apply_filters(
            'cn/posts/SpecSheets',
            [
                Text::make(__('Contentful Import ID', 'kmag'))
                    ->instructions(__('This field is only used for importing from contentful data', 'kmag')),
                Image::make(__('Product Logo', 'kmag'), 'product_logo')->wrapper([
                    'width' => '50'
                ]),
                File::make(__('PDF File', 'kmag'), 'pdf_file')->wrapper([
                    'width' => '50'
                ])->mimeTypes(['pdf']),
                Text::make(__('Product Name', 'kmag'), 'product_name'),
                Text::make(__('Cited Date/Issue Code', 'kmag'), 'cited_date')->wrapper([
                    'width' => '50'
                ]),
                Text::make(__('Cited Revision', 'kmag'), 'cited_revision')->wrapper([
                    'width' => '50'
                ]),
                Repeater::make(__('CHEMICAL COMPOSITION', 'kmag'))
                    ->fields([
                        Text::make(__('Component', 'kmag'), 'component'),
                        Text::make(__('Symbol', 'kmag'), 'symbol'),
                        Text::make(__('Typical %', 'kmag'), 'typical'),
                        Text::make(__('Guarantee % (min.)', 'kmag'), 'guarantee_min'),
                    ]),
                Repeater::make(__('PARTICLE SIZE DISTRIBUTION CUMULATIVE', 'kmag'), 'particle_distribution')
                    ->fields([
                        Text::make(__('Tyler Mesh', 'kmag'), 'tyler_mesh'),
                        Text::make(__('US Mesh', 'kmag'), 'us_mesh'),
                        Text::make(__('Opening (mm)', 'kmag'), 'opening'),
                        Text::make(__('Typical Range', 'kmag'), 'typical_range'),
                        Text::make(__('Typical', 'kmag'), 'typical'),
                    ]),
                Repeater::make(__('PHYSICAL PROPERTIES', 'kmag'))
                    ->fields([
                        Text::make(__('Bulk Density (Loose)', 'kmag'), 'bulk_density_loose'),
                        Text::make(__('Typical', 'kmag'), 'typical'),
                    ]),
                Repeater::make(__('SIZING CHARACTERISTICS', 'kmag'))
                    ->fields([
                        Text::make(__('Tyler Mesh', 'kmag'), 'tyler_mesh'),
                        Text::make(__('Opening (mm)', 'kmag'), 'opening'),
                        Text::make(__('Parameter', 'kmag'), 'parameter'),
                        Text::make(__('Typical', 'kmag'), 'typical'),
                    ]),
                Textarea::make(__('Notice', 'kmag'))->rows(2),
                Textarea::make(__('Disclaimer', 'kmag'))->rows(5),
            ]
        );
    }
}
