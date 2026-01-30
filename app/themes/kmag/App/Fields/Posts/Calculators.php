<?php

namespace CN\App\Fields\Posts;

use CN\App\Fields\Common;
use Extended\ACF\Fields\ButtonGroup;
use Extended\ACF\Fields\Link;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\TextArea;
use Extended\ACF\Fields\Select;


/**
 * Class Calculators
 *
 * @package CN\App\Fields\Posts
 */
class Calculators
{
    /**
     * Defines fields used within Calculators post type.
     *
     * @return array
     */
    public function fields()
    {
        return apply_filters(
            'cn/posts/calculators',
            [
                Text::make(__('Title', 'kmag'), 'title'),
                TextArea::make(__('Description', 'kmag'), 'description'),
                Link::make(__('Link', 'kmag'), 'link'),
                ButtonGroup::make(__('Calculator', 'kmag'), 'calculator')
                    ->choices([
                        'microessentials' => __('MicroEssentials', 'kmag'),
                        'aspire' => __('Aspire', 'kmag'),
                        'nutrient' => __('Nutrient', 'kmag'),
                        'retail-value' => __('Retail Value', 'kmag'),
                        'bio-calculator' => __('Bio Calculator', 'kmag')
                    ]),
                Select::make(__('Calculator Source', 'kmag'), 'calculator-source')
                    ->choices([
                        'wordpress'  => __('WordPress', 'kmag'),
                        'vue-plugin'  => __('Vue Plugin', 'kmag')
                    ])
                    ->defaultValue('vue-plugin')
                    ->returnFormat('value'),
            ]
        );
    }
}
