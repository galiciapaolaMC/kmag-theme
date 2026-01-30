<?php

namespace CN\App\Fields;

use CN\App\Fields\Layouts\Accordion;
use CN\App\Fields\Layouts\AccordionPost;
use CN\App\Fields\Layouts\AdvancedCNPlant;
use CN\App\Fields\Layouts\AgrifactFilter;
use CN\App\Fields\Layouts\AnchorLink;
use CN\App\Fields\Layouts\BackgroundGradient;
use CN\App\Fields\Layouts\BentoBox;
use CN\App\Fields\Layouts\Bios;
use CN\App\Fields\Layouts\Calculator;
use CN\App\Fields\Layouts\Carousel;
use CN\App\Fields\Layouts\CarouselHero;
use CN\App\Fields\Layouts\ChilipiperForm;
use CN\App\Fields\Layouts\ColumnContent;
use CN\App\Fields\Layouts\ContentArea;
use CN\App\Fields\Layouts\ContentBlock;
use CN\App\Fields\Layouts\DealerLocator;
use CN\App\Fields\Layouts\DiDAgent;
use CN\App\Fields\Layouts\EpisodeFiltering;
use CN\App\Fields\Layouts\ExploreMore;
use CN\App\Fields\Layouts\FarmerEpisodes;
use CN\App\Fields\Layouts\FarmerSliderBlock;
use CN\App\Fields\Layouts\FieldStudyPage;
use CN\App\Fields\Layouts\FrontierFieldTrialDataBlock;
use CN\App\Fields\Layouts\FullWidthGraphic;
use CN\App\Fields\Layouts\Hero;
use CN\App\Fields\Layouts\Image as ImageLayout;
use CN\App\Fields\Layouts\JumpToNavigation;
use CN\App\Fields\Layouts\MediaAssetBanner;
use CN\App\Fields\Layouts\MinimalCampaignFooter;
use CN\App\Fields\Layouts\ModalForm;
use CN\App\Fields\Layouts\NutrientDeficiencies;
use CN\App\Fields\Layouts\NutrientSlider;
use CN\App\Fields\Layouts\NutrientKnowledge;
use CN\App\Fields\Layouts\NutrientTable;
use CN\App\Fields\Layouts\PerformanceAcrePlusBanner;
use CN\App\Fields\Layouts\PerformanceMap;
use CN\App\Fields\Layouts\ProductBanner;
use CN\App\Fields\Layouts\ProductCards;
use CN\App\Fields\Layouts\ProductPanel;
use CN\App\Fields\Layouts\Quote;
use CN\App\Fields\Layouts\ShortHero;
use CN\App\Fields\Layouts\Slider;
use CN\App\Fields\Layouts\SplitBanner;
use CN\App\Fields\Layouts\Video;
use CN\App\Fields\Layouts\Wysiwyg;
use Extended\ACF\ConditionalLogic;
use Extended\ACF\Fields\ButtonGroup;
use Extended\ACF\Fields\Group;
use Extended\ACF\Fields\Image;
use Extended\ACF\Fields\Range;
use Extended\ACF\Fields\Select;
use Extended\ACF\Fields\Checkbox;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\Textarea;
use Extended\ACF\Fields\TrueFalse;
use Extended\ACF\Fields\WysiwygEditor;
use Extended\ACF\Fields\Repeater;
use Extended\ACF\Fields\Link;
use Extended\ACF\Fields\PageLink;
use Extended\ACF\Fields\FlexibleContent;

class Common
{
    public static function moduleList()
    {
        return FlexibleContent::make(__('Modules', 'kmag'))
            ->buttonLabel(__('Add Module', 'kmag'))
            ->layouts([
                (new Accordion())->fields(),
                (new AccordionPost())->fields(),
                (new AdvancedCNPlant())->fields(),
                (new AgrifactFilter())->fields(),
                (new AnchorLink())->fields(),
                (new BackgroundGradient())->fields(),
                (new BentoBox())->fields(),
                (new Bios())->fields(),
                (new Calculator())->fields(),
                (new Carousel())->fields(),
                (new CarouselHero())->fields(),
                (new ChilipiperForm())->fields(),
                (new ColumnContent())->fields(),
                (new DiDAgent())->fields(),
                (new EpisodeFiltering())->fields(),
                (new ExploreMore())->fields(),
                (new FarmerEpisodes())->fields(),
                (new FrontierFieldTrialDataBlock())->fields(),
                (new FarmerSliderBlock())->fields(),
                (new ContentArea())->fields(),
                (new ContentBlock())->fields(),
                (new DealerLocator())->fields(),
                (new FieldStudyPage())->fields(),
                (new FullWidthGraphic())->fields(),
                (new Hero())->fields(),
                (new ImageLayout())->fields(),
                (new JumpToNavigation())->fields(),
                (new MinimalCampaignFooter())->fields(),
                (new MediaAssetBanner())->fields(),
                (new ModalForm())->fields(),
                (new NutrientDeficiencies())->fields(),
                (new NutrientKnowledge())->fields(),
                (new NutrientSlider())->fields(),
                (new NutrientTable())->fields(),
                (new PerformanceMap())->fields(),
                (new PerformanceAcrePlusBanner())->fields(),
                (new ProductBanner())->fields(),
                (new ProductCards())->fields(),
                (new ProductPanel())->fields(),
                (new Quote())->fields(),
                (new ShortHero())->fields(),
                (new Slider())->fields(),
                (new SplitBanner())->fields(),
                (new Video())->fields(),
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
                        'image_set' => __('Image Set', 'kmag'),
                        'individual'  => __('Individual', 'kmag')
                    ])
                    ->defaultValue('image_set')
                    ->wrapper([
                        'width' => '50'
                    ]),
                Select::make(__('Set Number', 'kmag'))
                    ->choices([
                        '1' => __('Image Set 1', 'kmag'),
                        '2' => __('Image Set 2', 'kmag'),
                        '3' => __('Image Set 3', 'kmag'),
                        '4' => __('Image Set 4', 'kmag'),
                        '5' => __('Image Set 5', 'kmag')
                    ])
                    ->returnFormat('value')
                    ->conditionalLogic([
                        ConditionalLogic::where('image_type', '==', 'image_set')
                    ]),
                Image::make(__('Image Mobile', 'kmag'))
                    ->conditionalLogic([
                        ConditionalLogic::where('image_type', '==', 'individual')
                    ]),
                Image::make(__('Image Desktop', 'kmag'))
                    ->conditionalLogic([
                        ConditionalLogic::where('image_type', '==', 'individual')
                    ])
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
     * Generates a Checkbox group filled with crop options
     *
     * @param string $field_name - name of the ACF field
     * @param string $field_type - type of ACF field
     * @return Checkbox
     */
    public static function cropChoice($field_name = 'crops', $field_type = 'picklist')
    {
        $args = array(
            'post_type' => 'crops',
            'posts_per_page' => -1
        );
        $crop_posts = new \WP_Query($args);

        $crops = array();
        if ($crop_posts->have_posts()) {
            foreach ($crop_posts->posts as $crop_post) {
                $crop_key = strtolower($crop_post->post_name);
                $crops[$crop_key] =  __($crop_post->post_title, 'kmag');
            }
        }

        asort($crops);
        if ($field_type === 'select') {
            return Select::make(__($field_name, 'kmag'))
                ->instructions(__('Select a crop', 'kmag'))
                ->choices($crops)
                ->returnFormat('value');
        }
        return Checkbox::make(__($field_name, 'kmag'))
            ->instructions(__('Select one or more crops', 'kmag'))
            ->choices($crops)
            ->returnFormat('value');
    }

    public static function nutrientChoice($field_name = 'nutrients', $field_type = 'picklist')
    {
        $args = array(
            'post_type' => 'nutrients',
            'posts_per_page' => -1
        );
        $nutrient_posts = new \WP_Query($args);

        $nutrients = array();
        if ($nutrient_posts->have_posts()) {
            foreach ($nutrient_posts->posts as $nutrient_post) {
                $nutrient_key = strtolower($nutrient_post->post_name);
                $nutrients[$nutrient_key] =  __($nutrient_post->post_title, 'kmag');
            }
        }

        asort($nutrients);
        if ($field_type === 'select') {
            return Select::make(__($field_name, 'kmag'))
                ->instructions(__('Select a nutrient', 'kmag'))
                ->choices($nutrients)
                ->returnFormat('value');
        }
        return Checkbox::make(__($field_name, 'kmag'))
            ->instructions(__('Select one or more nutrients', 'kmag'))
            ->choices($nutrients)
            ->returnFormat('value');
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

    public static function pageAnnouncementBar()
    {
        return Group::make(__('Announcement Bar', 'kmag'), 'announcement-bar')
            ->layout('block')
            ->fields([
                ButtonGroup::make(__('Background Color', 'kmag'), 'background-color')
                    ->choices([
                        'background-black' => __('Black', 'kmag'),
                        'background-teal' => __('Teal', 'kmag'),
                    ])
                    ->defaultValue('background-black'),
                WysiwygEditor::make(__('Content', 'kmag'), 'content')
                    ->mediaUpload(false),
            ]);
    }

    public static function stickyNavigation()
    {
        return Group::make(__('Page Navigation', 'kmag'), 'page-navigation')
            ->layout('block')
            ->fields([
                ButtonGroup::make(__('Desktop Navigtion', 'kmag'), 'desktop-navigation')
                    ->choices([
                        'true' => __('True', 'kmag'),
                        'false'  => __('False', 'kmag')
                    ])
                    ->defaultValue('false')
                    ->wrapper([
                        'width' => '50'
                    ]),
                ButtonGroup::make(__('Mobile Navigtion', 'kmag'), 'mobile-navigation')
                    ->choices([
                        'true' => __('True', 'kmag'),
                        'false'  => __('False', 'kmag')
                    ])
                    ->defaultValue('true')
                    ->wrapper([
                        'width' => '50'
                    ]),
                Repeater::make(__('Navigation', 'kmag'), 'navigation')
                    ->min(1)
                    ->layout('block')
                    ->fields([
                        Text::make(__('Section Name', 'kmag'), 'section-name')
                            ->wrapper([
                                'width' => '25'
                            ]),
                        Text::make(__('Section ID', 'kmag'), 'section-id')
                            ->wrapper([
                                'width' => '25'
                            ]),
                        Link::make(__('External Link', 'kmag'), 'external-link')
                            ->wrapper([
                                'width' => '25'
                            ]),
                        PageLink::make(__('Internal Link', 'kmag'), 'internal-link')
                            ->wrapper([
                                'width' => '25'
                            ])
                    ])
            ]);
    }
}
