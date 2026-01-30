<?php

/**
 * Functions and definitions
 *
 * @package CN
 */

use CN\App\Core\Init;
use CN\App\Setup;
use CN\App\Scripts;
use CN\App\Media;
use CN\App\Shortcodes;
use CN\App\PerformanceProductsLayouts;
use CN\App\Api\ResourceLibrary;
use CN\App\Api\EpisodeFilters;
use CN\App\Core\Transients;
use CN\App\Fields\ACF;
use CN\App\Fields\Options;
use CN\App\Fields\Modules;
use CN\App\Fields\ResourceLibraryUtil;
use CN\App\Fields\SiteSearchUtil;
use CN\App\Fields\FieldGroups\SiteOptionsFieldGroup;
use CN\App\Fields\FieldGroups\PageBuilderFieldGroup;
use CN\App\Fields\FieldGroups\ScoredBuilderFieldGroup;
use CN\App\Fields\FieldGroups\CustomPostTypeFieldGroups;
use CN\App\Posts\Types\Agrifacts;
use CN\App\Posts\Types\Agrisights;
use CN\App\Posts\Types\Crops;
use CN\App\Posts\Types\Campaigns;
use CN\App\Posts\Types\Experts;
use CN\App\Posts\Types\Material;
use CN\App\Posts\Types\Nutrients;
use CN\App\Posts\Types\NutrientDeficits;
use CN\App\Posts\Types\NutrientsTagTaxonomy;
use CN\App\Posts\Types\Products;
use CN\App\Posts\Types\ProductGroups;
use CN\App\Posts\Types\PerformanceProducts;
use CN\App\Posts\Types\Regions;
use CN\App\Posts\Types\SDSPages;
use CN\App\Posts\Types\RobustArticles;
use CN\App\Posts\Types\ArticleTagsTaxonomy;
use CN\App\Posts\Types\VideoArticles;
use CN\App\Posts\Types\ColumnContent;
use CN\App\Posts\Types\CropsTaxonomy;
use CN\App\Posts\Types\SpecSheets;
use CN\App\Posts\Types\AppRateSheets;
use CN\App\Posts\Types\ProductSheets;
use CN\App\Posts\Types\ProductLabel;
use CN\App\Posts\Types\SuccessStory;
use CN\App\Posts\Types\GHSLabel;
use CN\App\Posts\Types\Calculators;
use CN\App\Posts\Types\PerformanceProductsTaxonomy;
use CN\App\Posts\Types\StandardArticles;
use CN\App\Posts\Types\DirectionsForUse;
use CN\App\Posts\Types\FarmerProfiles;
use CN\App\Posts\Types\FrontierFieldsEpisodes;
use CN\App\Posts\Types\SherryShowEpisodes;
use CN\App\Posts\Types\AgronomyTopicsTaxonomy;
use CN\App\Posts\Types\ShowSeasonsTaxonomy;
use CN\App\Posts\Types\SeasonOptionTaxonomy;
use CN\App\Posts\Types\TruResponseInsights;
use CN\App\Posts\Types\TruResTrialData;
use CN\App\SalesForce\Api as SalesForceApi;

/**
 * Define Theme Version
 * Define Theme directories
 */
define('THEME_VERSION', '1.2.6');
define('CN_THEME_DIR', trailingslashit(get_template_directory()));
define('CN_THEME_PATH_URL', trailingslashit(get_template_directory_uri()));

require __DIR__ . '/constants.php';

// Require Autoloader
require_once CN_THEME_DIR . 'vendor/autoload.php';

/**
 * Theme Setup
 */
add_action('after_setup_theme', function () {

    (new Init())
        ->add(new Setup())
        ->add(new Transients())
        ->add(new Scripts())
        ->add(new Media())
        ->add(new Shortcodes())
        ->add(new PerformanceProductsLayouts())
        ->add(new ResourceLibrary())
        ->add(new EpisodeFilters())
        ->add(new ACF())
        ->add(new Options())
        ->add(new Modules())
        ->add(new Agrifacts())
        ->add(new Agrisights())
        ->add(new VideoArticles())
        ->add(new SuccessStory())
        ->add(new Campaigns())
        ->add(new Crops())
        ->add(new Experts())
        ->add(new Material())
        ->add(new Nutrients())
        ->add(new NutrientDeficits())
        ->add(new NutrientsTagTaxonomy())
        ->add(new Products())
        ->add(new ProductGroups())
        ->add(new PerformanceProducts())
        ->add(new Regions())
        ->add(new SDSPages())
        ->add(new RobustArticles())
        // set up the tag taxonomy for all resource library post (article) types
        ->add(new ArticleTagsTaxonomy())
        ->add(new FarmerProfiles())
        ->add(new FrontierFieldsEpisodes())
        ->add(new SherryShowEpisodes())
        ->add(new PerformanceProductsTaxonomy())
        ->add(new AgronomyTopicsTaxonomy())
        ->add(new ShowSeasonsTaxonomy())
        ->add(new SeasonOptionTaxonomy())
        ->add(new CropsTaxonomy())
        ->add(new SiteOptionsFieldGroup())
        ->add(new PageBuilderFieldGroup())
        ->add(new ScoredBuilderFieldGroup())
        ->add(new CustomPostTypeFieldGroups())
        ->add(new GHSLabel())
        ->add(new Calculators())
        ->add(new SpecSheets())
        ->add(new AppRateSheets())
        ->add(new ProductSheets())
        ->add(new ProductLabel())
        ->add(new SalesForceApi())
        ->add(new StandardArticles())
        ->add(new ColumnContent())
        ->add(new DirectionsForUse())
        ->add(new TruResponseInsights())
        ->add(new TruResTrialData())
        // ->add(new RegisterBlocks())
        ->add(new ResourceLibraryUtil)
        ->add(new SiteSearchUtil)
        ->initialize();

    // Translation setup
    load_theme_textdomain('kmag', CN_THEME_DIR . '/languages');

    // Let WordPress manage the document title.
    add_theme_support('title-tag');

    // Add automatic feed links in header
    add_theme_support('automatic-feed-links');

    // Add Post Thumbnail Image sizes and support
    add_theme_support('post-thumbnails');

    // Switch default core markup to output valid HTML5.
    add_theme_support('html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption'
    ]);
});
