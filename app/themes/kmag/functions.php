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
use CN\App\Core\Transients;
use CN\App\Fields\ACF;
use CN\App\Fields\Options;
use CN\App\Fields\Modules;
use CN\App\Fields\FieldGroups\SiteOptionsFieldGroup;
use CN\App\Fields\FieldGroups\PageBuilderFieldGroup;
use CN\App\Fields\FieldGroups\CustomPostTypeFieldGroups;
use CN\App\Posts\Types\Agrifacts;
use CN\App\Posts\Types\PerformanceProducts;
use CN\App\Posts\Types\SDSPages;
use CN\App\Posts\Types\SpecSheets;
use CN\App\Posts\Types\GHSLabel;
use CN\App\Posts\Types\PerformanceProductsTaxonomy;
use CN\App\Posts\Types\AgronomyTopicsTaxonomy;
use CN\App\Posts\Types\ArticleTagsTaxonomy;
use CN\App\Posts\Types\CropsTaxonomy;
use CN\App\Posts\Types\NutrientsTagTaxonomy;

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
        ->add(new ACF())
        ->add(new Options())
        ->add(new Modules())
        ->add(new Agrifacts())
        ->add(new PerformanceProducts())
        ->add(new SDSPages())
        // set up the tag taxonomy for all resource library post (article) types
        ->add(new ArticleTagsTaxonomy())
        ->add(new PerformanceProductsTaxonomy())
        ->add(new AgronomyTopicsTaxonomy())
        ->add(new CropsTaxonomy())
        ->add(new NutrientsTagTaxonomy())
        ->add(new SiteOptionsFieldGroup())
        ->add(new PageBuilderFieldGroup())
        ->add(new CustomPostTypeFieldGroups())
        ->add(new GHSLabel())
        ->add(new SpecSheets())
        // ->add(new RegisterBlocks())
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
