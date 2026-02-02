<?php

namespace CN\App\Fields;

use CN\App\Fields\Layouts\Accordion;
use CN\App\Fields\Layouts\AgrifactFilter;
use CN\App\Fields\Layouts\BackgroundGradient;
use CN\App\Fields\Layouts\BentoBox;
use CN\App\Fields\Layouts\ColumnContent;
use CN\App\Fields\Layouts\ContentArea;
use CN\App\Fields\Layouts\ContentBlock;
use CN\App\Fields\Layouts\Hero;
use CN\App\Fields\Layouts\SplitBanner;
use CN\App\Fields\Layouts\Wysiwyg;
use Extended\ACF\Fields\ButtonGroup;
use Extended\ACF\Fields\Group;
use Extended\ACF\Fields\Image;
use Extended\ACF\Fields\Range;
use Extended\ACF\Fields\Select;
use Extended\ACF\Fields\Checkbox;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\Textarea;
use Extended\ACF\Fields\FlexibleContent;

class Common
{
    public static function moduleList()
    {
        return FlexibleContent::make(__('Modules', 'kmag'))
            ->buttonLabel(__('Add Module', 'kmag'))
            ->layouts([
                (new Accordion())->fields(),
                (new AgrifactFilter())->fields(),
                (new BackgroundGradient())->fields(),
                (new BentoBox())->fields(),
                (new ColumnContent())->fields(),
                (new ContentArea())->fields(),
                (new ContentBlock())->fields(),
                (new Hero())->fields(),
                (new SplitBanner())->fields(),
                (new Wysiwyg())->fields()
            ]);
    }

    /**
     * Image Set Selector
     *
     * @return Select
     */
    public static function imageSet()
    {
        return Group::make(__('Image Set', 'kmag'))
            ->layout('block')
            ->fields([
                ButtonGroup::make(__('Image Type', 'kmag'))
                    ->choices([
                        'individual'  => __('Individual', 'kmag')
                    ])
                    ->defaultValue('individual')
                    ->wrapper([
                        'width' => '50'
                    ]),
                Image::make(__('Image Mobile', 'kmag')),
                Image::make(__('Image Desktop', 'kmag'))
            ]);
    }

    /**
     * Padding Options Group
     *
     * @param array $defaults [mpt, mpb, dpt, dpb]
     * @return Group
     */
    public static function paddingGroup($defaults = [0, 0, 0, 0])
    {
        return Group::make(__('Padding', 'kmag'), 'padding')
            ->layout('block')
            ->fields([
                Group::make(__('Mobile', 'kmag'), 'mobile')
                    ->layout('block')
                    ->fields([
                        Range::make(__('Top', 'kmag'), 'top')
                            ->min(0)
                            ->max(200)
                            ->step(8)
                            ->DefaultValue($defaults[0])
                            ->wrapper([
                                'width' => '50'
                            ])
                            ->append('px'),
                        Range::make(__('Bottom', 'kmag'), 'bottom')
                            ->min(0)
                            ->max(200)
                            ->step(8)
                            ->DefaultValue($defaults[1])
                            ->wrapper([
                                'width' => '50'
                            ])
                            ->append('px')
                    ]),
                Group::make(__('Desktop', 'kmag'), 'desktop')
                    ->layout('block')
                    ->fields([
                        Range::make(__('Top', 'kmag'), 'top')
                            ->min(0)
                            ->max(200)
                            ->step(8)
                            ->DefaultValue($defaults[2])
                            ->wrapper([
                                'width' => '50'
                            ])
                            ->append('px'),
                        Range::make(__('Bottom', 'kmag'), 'bottom')
                            ->min(0)
                            ->max(200)
                            ->step(8)
                            ->DefaultValue($defaults[3])
                            ->wrapper([
                                'width' => '50'
                            ])
                            ->append('px')
                    ]),
            ]);
    }

    /**
     * Product Colors Group
     *
     * fetches all performance products and creates a select field group with their values as options
     *
     * @param array $additional_colors [color_key => color_name, color_1_key, => color_1_name]
     * @return Group
     */
    public static function productColors($additional_colors = [])
    {
        $args = array(
            'post_type' => 'performance-products',
            'posts_per_page' => -1
        );
        $products = new \WP_Query($args);

        $colors = array();

        if (!empty($additional_colors)) {
            foreach ($additional_colors as $color_value => $color_name) {
                $colors[$color_value] = __($color_name, 'kmag');
            }
        }

        if ($products->have_posts()) {
            foreach ($products->posts as $product) {
                $product_key = strtolower($product->post_name);
                $colors[$product_key] =  __($product->post_title, 'kmag');
            }
        }

        return Group::make(__('Button Options', 'kmag'), 'button-options')
            ->layout('block')
            ->fields([
                Select::make(__('Button Color', 'kmag'))
                    ->choices($colors)
            ]);
    }

    /**
     * Generates a Select dropdown of icons from a white list
     *
     * @param string $field_name - name of the ACF field
     * @param array $icon_white_list - an array of allowed icons
     * @return Select
     */
    public static function iconOptions($field_name = 'Icon', $icon_white_list = ['arrow-right', 'download', 'arrow-left', 'expand'])
    {
        // Array to store the combined ACF field options
        $options = [
            'none' => __('None', 'kmag')
        ];

        foreach ($icon_white_list as $icon) {
            $human_readable_name = ucwords(str_replace('-', ' ', $icon));
            $options[$icon] = __($human_readable_name, 'kmag');
        }

        return Select::make(__($field_name, 'kmag'))
            ->choices($options)
            ->defaultValue('none');
    }

   

    /**
     * Returns an associative array of performance product titles associated with their key
     * @return array
     */
    private static function getPerformanceProductOptions()
    {
        $args = array(
            'post_type' => 'performance-products',
            'posts_per_page' => -1
        );
        $performance_product_posts = new \WP_Query($args);
        $performance_products = array();

        if ($performance_product_posts->have_posts()) {
            foreach ($performance_product_posts->posts as $performance_product_post) {
                $product_key = strtolower($performance_product_post->post_name);
                $performance_products[$product_key] =  __($performance_product_post->post_title, 'kmag');
            }
        }
        asort($performance_products);
        return $performance_products;
    }

    /**
     * Generates a Checkbox group filled with performance products
     *
     * @param string $field_name - name of the ACF field
     * @return Select
     */
    public static function performanceProductDropdown($field_name = 'Performance Product', $instructions = null)
    {
        if ($instructions === null) {
            $instructions = __('Select a performance product', 'kmag');
        }
        $performance_products = Common::getPerformanceProductOptions();
        return Select::make(__($field_name, 'kmag'), 'performance-product')
            ->instructions($instructions)
            ->choices($performance_products)
            ->returnFormat('value');
    }

    /**
     * Generates a Checkbox group filled with performance products
     *
     * @param string $field_name - name of the ACF field
     * @return Checkbox
     */
    public static function performanceProductPickList($field_name = 'Performance Products', $instructions = null)
    {
        if ($instructions === null) {
            $instruction = __('Select one or more performance products', 'kmag');
        }
        $performance_products = Common::getPerformanceProductOptions();
        return Checkbox::make(__($field_name, 'kmag'), 'performance-product')
            ->instructions($instructions)
            ->choices($performance_products)
            ->returnFormat('value');
    }

    /**
     * Generates an author field group
     * 
     * @param string
     */
    public static function authorFields()
    {
        return Group::make(__('Author', 'kmag'), 'author')
            ->layout('block')
            ->fields([
                Text::make(__('Author ID', 'kmag'), 'author-id')
                    ->instructions(__('The ID from contentful exports (optional)', 'kmag')),
                Image::make(__('Author Thumbnail', 'kmag'), 'author-thumbnail'),
                Text::make(__('Author Name', 'kmag'), 'author-name'),
                Text::make(__('Author Title', 'kmag'), 'author-title')
                    ->instructions(__('The author\'s formal title', 'kmag')),
                Textarea::make(__('Author Bio', 'kmag'), 'author-bio'),
            ]);
    }

}
