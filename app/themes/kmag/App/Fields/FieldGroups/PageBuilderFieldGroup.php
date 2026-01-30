<?php

namespace CN\App\Fields\FieldGroups;

use CN\App\Fields\Common;
use CN\App\Fields\FieldGroups\RegisterFieldGroups;
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
use CN\App\Fields\Layouts\ExploreMore;
use CN\App\Fields\Layouts\FarmerSliderBlock;
use CN\App\Fields\Layouts\FieldStudyPage;
use CN\App\Fields\Layouts\FrontierFieldTrialDataBlock;
use CN\App\Fields\Layouts\FullWidthGraphic;
use CN\App\Fields\Layouts\Hero;
use CN\App\Fields\Layouts\Image;
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
use CN\App\Fields\Layouts\StickyNavigation;
use CN\App\Fields\Layouts\Video;
use CN\App\Fields\Layouts\Wysiwyg;
use Extended\ACF\Location;
use Extended\ACF\Fields\FlexibleContent;

/**
 * Class PageBuilderFieldGroup
 *
 * @package CN\App\Fields\PageBuilderFieldGroup
 */
class PageBuilderFieldGroup extends RegisterFieldGroups
{
    /**
     * Register Field Group via Wordplate
     */
    public function registerFieldGroup()
    {
        register_extended_field_group([
            'title'    => __('Page Builder', 'kmag'),
            'fields'   => $this->getFields(),
            'location' => [
                Location::where('page_template', 'templates/page-builder.php'),
                Location::where('page_template', 'templates/retail-calculator-page-builder.php'),
                Location::where('page_template', 'templates/campaign-page-builder.php'),
                Location::where('page_template', 'templates/field-study-detail.php'),
            ],
            'style' => 'default'
        ]);

        register_extended_field_group([
            'title'    => __('Campaign 2024', 'kmag'),
            'fields'   => $this->getFieldsPF(),
            'location' => [
                Location::where('page_template', 'templates/campaign-page-builder-2024.php'),
            ],
            'style' => 'default'
        ]);
    }

    /**
     * Register the fields that will be available to this Field Group.
     *
     * @return array
     */
    public function getFields()
    {
        return apply_filters('cn/field-group/page-builder/fields', [
            FlexibleContent::make(__('Modules', 'kmag'))
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
                    (new ExploreMore())->fields(),
                    (new FrontierFieldTrialDataBlock())->fields(),
                    (new FarmerSliderBlock())->fields(),
                    (new ContentArea())->fields(),
                    (new ContentBlock())->fields(),
                    (new DealerLocator())->fields(),
                    (new DiDAgent())->fields(),
                    (new FieldStudyPage())->fields(),
                    (new FullWidthGraphic())->fields(),
                    (new Hero())->fields(),
                    (new Image())->fields(),
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
                ]),
            Common::gatedContentFields(),
            Common::scoredContentFields(),
            Common::pageAttributeName(),
            Common::dynamicContentReplacementFields(),
            Common::linkReplacementField(),
            Common::aiAgentFields(),
        ]);
    }

    /**
     * Register the fields that will be available for the Landing Page PF
     *
     * @return array
     */
    public function getFieldsPF()
    {
        return apply_filters('cn/field-group/page-builder/fields', [
            Common::stickyNavigation(),
        ]);
    }
}
