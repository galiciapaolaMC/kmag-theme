<?php

namespace CN\App\Fields;

use CN\App\Interfaces\WordPressHooks;
use CN\App\Media;
use CN\App\Core\Transients;
use CN\App\Fields\ACF;

/**
 * Class Modules
 *
 * @package CN\App\Fields
 */
class Modules implements WordPressHooks
{

    /**
     * Add class hooks.
     */
    public function addHooks()
    {
        add_action('cn/modules/output', [$this, 'outputFlexibleModules']);
        add_action('admin_head', [$this, 'disableClassicEditor']);
        add_filter('gutenberg_can_edit_post_type', [$this, 'disableGutenberg'], 10, 2);
        add_filter('use_block_editor_for_post_type', [$this, 'disableGutenberg'], 10, 2);
        add_filter('cn/modules/get-default-styles', [$this, 'getModuleDefaultStyles'], 10, 2);
        add_action('cn/modules/styles', [$this, 'outputModuleStyles'], 10, 2);
        add_filter('cn/modules/handle-image-set-field', [$this, 'handleImageSet'], 10, 2);
        add_action('cn/global/crop-region', [$this, 'outputCropRegionData'], 10, 1);
        add_action('cn/global/crop-images', [$this, 'outputCropImageData'], 10, 1);
        add_filter('the_title', [$this, 'textualCleanups']);
        add_filter('cn/grid-episode/card', [$this, 'outputEpisodeCard'], 10, 1);
        add_filter('cn/grid-farmer/card', [$this, 'outputFarmerCard'], 10, 1);
        add_filter('cn/slider-episode/card', [$this, 'outputEpisodeCard'], 10, 1);
        add_action('parse_request', [$this,'overwriteRequest'], 10, 1);
    }

    /**
     * Loop through flexible modules meta and include each module file to the page.
     * $data is set to the scope of just the current module, so that only relevant values are passed to each file.
     *
     * @param $post_id
     */
    public function outputFlexibleModules($post_id)
    {
        $post_id = $post_id ?: get_the_ID();
        $meta    = ACF::getPostMeta($post_id);

        if (!empty($meta['modules']) && is_array($meta['modules'])) {
            $modules = ACF::getRowsLayout('modules', $meta);

            foreach ($meta['modules'] as $index => $module) {
                $data   = $modules[$index];
                $row_id = $module . '-' . $index;
                $template = implode('-', explode('_', $module));

                $file = locate_template("components/modules/{$template}.php");
                if (file_exists($file)) {
                    include($file);
                }
            }
        }
    }

    /**
     * Disable Classic Editor by template
     */
    public function disableClassicEditor()
    {
        $post_id = filter_input(INPUT_GET, 'post', FILTER_SANITIZE_NUMBER_INT);
        $screen  = get_current_screen();
        if ('page' !== $screen->id || !isset($post_id)) {
            return;
        }
        if (!self::disableEditor($_GET['post'])) {
            remove_post_type_support('page', 'editor');
        }
    }

    /**
     * Disable Gutenberg by template
     *
     * @param $can_edit
     * @param $post_type
     *
     * @return bool
     */
    public function disableGutenberg($can_edit, $post_type)
    {
        $post_id = filter_input(INPUT_GET, 'post', FILTER_SANITIZE_NUMBER_INT);
        if (!(is_admin() && !empty($post_id))) {
            return $can_edit;
        }

        return self::disableEditor($post_id);
    }

    /**
     * Templates and Page IDs without editor
     *
     * @param bool $id
     *
     * @return bool
     */
    public static function disableEditor($id = false)
    {
        $disabled_templates = [
            'templates/page-builder.php'
        ];

        if (empty($id)) {
            return false;
        }

        $template = get_page_template_slug($id);

        return !in_array($template, $disabled_templates);
    }

    /**
     * Appends module style defaults into its $data array
     *
     * @param string $module - the module name
     * @param array $data
     *
     * @return array
     */
    public function getModuleDefaultStyles($module, $data)
    {
        $data['defaults'] = [];

        $modules = $this->getModuleDefaultValues();

        if (isset($modules[$module])) {
            $data['defaults']['padding'] = $modules[$module]['padding'];
        }

        return $data;
    }

    /**
     * Returns the array of module defaults
     *
     * @return array
     */
    public function getModuleDefaultValues()
    {
        return [
            'accordion' => [
                'padding' => DEFAULT_ACCORDION_PADDING
            ],
            'advanced-cn-plant' => [
                'padding' => DEFAULT_ADVANCED_CN_PLANT_PADDING
            ],
            'bios' => [
                'padding' => DEFAULT_BIOS_PADDING
            ],
            'calculator' => [
                'padding' => DEFAULT_CALCULATOR_PADDING
            ],
            'carousel' => [
                'padding' => DEFAULT_CAROUSEL_PADDING
            ],
            'column-content' => [
                'padding' => DEFAULT_COLUMN_CONTENT_PADDING
            ],
            'content-area' => [
                'padding' => DEFAULT_CONTENT_AREA_PADDING
            ],
            'content-block' => [
                'padding' => DEFAULT_CONTENT_BLOCK_PADDING
            ],
            'explore-more' => [
                'padding' => DEFAULT_EXPLORE_MORE_PADDING
            ],
            'full-width-graphic' => [
                'padding' => DEFAULT_FULLWIDTHGRAPHIC_PADDING
            ],
            'hero' => [
                'padding' => DEFAULT_HERO_PADDING
            ],
            'image' => [
                'padding' => DEFAULT_IMAGE_PADDING
            ],
            'jump-to-navigation' => [
                'padding' => DEFAULT_JUMP_TO_NAVIGATION_PADDING
            ],
            'media-asset-banner' => [
                'padding' => DEFAULT_MEDIA_ASSET_BANNER_PADDING
            ],
            'nutrient-deficiencies' => [
                'padding' => DEFAULT_NUTRIENT_DEFICIENCY_PADDING
            ],
            'nutrient-knowledge' => [
                'padding' => DEFAULT_NUTRIENT_KNOWLEDGE_PADDING
            ],
            'nutrient-slider-1' => [
                'padding' => DEFAULT_NUTRIENT_SLIDER_PADDING
            ],
            'nutrient-table' => [
                'padding' => DEFAULT_NUTRIENT_TABLE_PADDING
            ],
            'performance-map' => [
                'padding' => DEFAULT_PERFORMANCE_MAP_PADDING
            ],
            'product-banner' => [
                'padding' => DEFAULT_PRODUCT_BANNER_PADDING
            ],
            'split-banner' => [
                'padding' => DEFAULT_SPLIT_BANNER_PADDING
            ],
            'video' => [
                'padding' => DEFAULT_VIDEO_PADDING
            ],
            'wysiwyg' => [
                'padding' => DEFAULT_WYSIWYG_PADDING
            ]
        ];
    }

    /**
     * Print module specific styles if set
     *
     * @param string $row_id
     * @param array $data
     * @param array $defaults
     */
    public function outputModuleStyles($row_id, $data)
    {
        if (empty($row_id) || empty($data)) {
            return false;
        }

        $padding = $data['defaults']['padding'] ?? [0, 0, 0, 0];

        $padding_mobile_top  = ACF::getField('padding_mobile_top', $data, $padding[0]) . 'px';
        $padding_mobile_bottom  = ACF::getField('padding_mobile_bottom', $data, $padding[1]) . 'px';
        $padding_desktop_top = ACF::getField('padding_desktop_top', $data, $padding[2]) . 'px';
        $padding_desktop_bottom = ACF::getField('padding_desktop_bottom', $data, $padding[3]) . 'px';
       
      

        echo '<style type="text/css">';
        printf(
              '#%1$s { padding-top: %2$s; padding-bottom: %3$s;}',
            esc_html($row_id),
            esc_html($padding_mobile_top),
            esc_html($padding_mobile_bottom),
        );
        

        printf(
            '@media (min-width: 992px) {
                    #%1$s { padding-top: %2$s; padding-bottom: %3$s; }
                }',
            esc_html($row_id),
            esc_html($padding_desktop_top),
            esc_html($padding_desktop_bottom)
        );
        echo '</style>';
    }

    /**
     * This function will get the image set and localize the values inside javascript so that they
     * can be loaded dynamically.
     *
     * @param string $data
     * @param array $row_id
     *
     * @return void
     */
    private function initializeCropSetImages($data, $row_id)
    {
        $image_set_number = ACF::getField('image_set_set_number', $data);
        $crop_list = array();

        $crops = new \WP_Query([
            'post_type' => 'crops',
            'posts_per_page' => -1,
            'order' => 'ASC'
        ]);

        if ($crops->have_posts()) {
            foreach ($crops->posts as $crop) {
                $images = ACF::getPostMeta($crop->ID);

                $mobile = Media::getAttachmentByID($images["image_{$image_set_number}_mobile"]);
                $desktop = Media::getAttachmentByID($images["image_{$image_set_number}_desktop"]);

                $crop_list[$crop->post_name] = [
                    'mobile' => !empty($mobile) ? $mobile->url : '',
                    'desktop' => !empty($desktop) ? $desktop->url : ''
                ];
            }
        }

        // pass crop list to javascript for this module
        $unique_name = str_replace('-', '_', $row_id);
        wp_localize_script("cn-theme", "{$unique_name}_images", array(
            'crop_images' => $crop_list
        ));
    }

    /**
     * This will return an array containing the image object for mobile and desktop
     *
     * @param array $data
     */
    private function initializeNonCropSetImages($data)
    {
        $image_mobile = Media::getAttachmentByID(ACF::getField('image_set_image_mobile', $data));
        $image_desktop = Media::getAttachmentByID(ACF::getField('image_set_image_desktop', $data));

        return array(
            "image_mobile" => $image_mobile,
            "image_desktop" => $image_desktop
        );
    }

    /**
     * Depending on the value of the image_type field, this function will execute one of two
     * Private methods that initialize images and then return image data depending
     *
     * @param string $data
     * @param array $row_id
     *
     * @return array
     * @return array[image_mobile] - image object for mobile
     * @return array[image_desktop] - image object for desktop
     */
    public function handleImageSet($data, $row_id)
    {
        $image_type = ACF::getField('image_set_image_type', $data);

        if ($image_type === 'image_set') {
            $this->initializeCropSetImages($data, $row_id);

            return array(
                'image_mobile' => null,
                'image_desktop' => null
            );
        }

        return $this->initializeNonCropSetImages($data);
    }

    /**
     * This function will output the crop region data to javascript
     *
     * @return void
     */
    public function outputCropRegionData()
    {
        // First check if data is cached then output it if so
        $crop_region_key = 'crop_region';
        $crop_region = get_transient($crop_region_key);

        if ($crop_region) {
            wp_localize_script('cn-theme', $crop_region_key, $crop_region);
            return;
        }

        $region_query = new \WP_Query([
            'post_type' => 'regions',
            'posts_per_page' => -1,
            'order' => 'ASC'
        ]);

        $regions = [];

        if ($region_query->have_posts()) {
            foreach ($region_query->posts as $region) {
                $post_meta = ACF::getPostMeta($region->ID);
                $regions[$region->post_name] = [$region->post_title, $post_meta['crops']];
            }
        }

        $crop_query = new \WP_Query([
            'post_type' => 'crops',
            'posts_per_page' => -1,
            'order' => 'ASC'
        ]);

        $crops = [];

        if ($crop_query->have_posts()) {
            foreach ($crop_query->posts as $crop) {
                $crops[$crop->ID] = [$crop->post_name, $crop->post_title];
            }
        }

        $crop_region = [
            'crops' => $crops,
            'regions' => $regions
        ];

        (new Transients())->registerTransients($crop_region_key);
        set_transient($crop_region_key, $crop_region, 60 * 60 * MINUTE_IN_SECONDS);
        wp_localize_script('cn-theme', $crop_region_key, $crop_region);
    }

    /**
     * This function will output the global js data used on pages that pertains to crop images
     *
     * @return void
     */
    public function outputCropImageData()
    {
        // First check if data is cached then output it if so
        $crop_images_key = 'crop_images';
        $crop_images = get_transient($crop_images_key);

        if ($crop_images) {
            wp_localize_script('cn-theme', $crop_images_key, $crop_images);
            return;
        }

        $crop_query = new \WP_Query([
            'post_type' => 'crops',
            'posts_per_page' => -1,
            'order' => 'ASC'
        ]);

        $lookup_images = [];
        $crop_images = [];
        if ($crop_query->have_posts()) {
            foreach ($crop_query->posts as $crop) {
                $crop_meta = ACF::getPostMeta($crop->ID);

                // Handle image sets
                $image_sets = [
                    'image_1_desktop' => $crop_meta['image_1_desktop'] ?? null,
                    'image_1_mobile' => $crop_meta['image_1_mobile'] ?? null,
                    'image_2_desktop' => $crop_meta['image_2_desktop'] ?? null,
                    'image_2_mobile' => $crop_meta['image_2_mobile'] ?? null,
                    'image_3_desktop' => $crop_meta['image_3_desktop'] ?? null,
                    'image_3_mobile' => $crop_meta['image_3_mobile'] ?? null,
                    'image_4_desktop' => $crop_meta['image_4_desktop'] ?? null,
                    'image_4_mobile' => $crop_meta['image_4_mobile'] ?? null,
                    'image_5_desktop' => $crop_meta['image_5_desktop'] ?? null,
                    'image_5_mobile' => $crop_meta['image_5_mobile'] ?? null,
                    'image_6_desktop' => $crop_meta['image_6_desktop'] ?? null,
                    'image_6_mobile' => $crop_meta['image_6_mobile'] ?? null,
                ];
                foreach ($image_sets as $image_id) {
                    if (empty($lookup_images[$image_id])) {
                        $image = $image_id ? Media::getAttachmentByID($image_id) : null;
                        $lookup_images[$image_id] = $image;
                    }
                }

                // Handle banner images
                $banner_images = [
                    'mobile' => [],
                    'desktop' => []
                ];

                $banner_images_mobile = ACF::getRowsLayout('banner-images_mobile', $crop_meta);
                foreach ($banner_images_mobile as $image) {
                    $image_id = $image['image-id'] ?? null;
                    $banner_images['mobile'][] = $image_id;

                    if (empty($lookup_images[$image_id])) {
                        $image = $image_id ? Media::getAttachmentByID($image_id) : null;
                        $lookup_images[$image_id] = $image;
                    }
                }

                $banner_images_desktop = ACF::getRowsLayout('banner-images_desktop', $crop_meta);
                foreach ($banner_images_desktop as $image) {
                    $image_id = $image['image-id'] ?? null;
                    $banner_images['desktop'][] = $image_id;

                    if (empty($lookup_images[$image_id])) {
                        $image = $image_id ? Media::getAttachmentByID($image_id) : null;
                        $lookup_images[$image_id] = $image;
                    }
                }

                // Add to crop image array
                $crop_images[$crop->post_name] = [
                    'sets' => $image_sets,
                    'banners' => $banner_images,
                ];
            }
        }

        ksort($lookup_images);

        /**
         * @var array $crop_images['crops'] - List of all crops, their image sets by id, and banner images by id
         * @var array $crop_images['images'] - Full list of image objects sorted by image id needed for 'crops' as to prevent duplicates
         */
        $crop_images = [
            'crops' => $crop_images,
            'images' => $lookup_images
        ];

        // Cache in transient for one hour
        (new Transients())->registerTransients($crop_images_key);
        set_transient($crop_images_key, $crop_images, 60 * 60 * MINUTE_IN_SECONDS);
        wp_localize_script('cn-theme', $crop_images_key, $crop_images);
    }

    /**
     * Cleanups for title filter
     * @param $title
     * @return array|string
     */
    public function textualCleanups($title)
    {
        if (!is_admin()) {
            //For cleaning invalid characters
            $title = str_replace([''], "", $title);
            // For adding sup tag for ®
            $title = preg_replace('/(®)/', '<sup style="vertical-align: -0.1em;line-height: 0;">$1</sup>', $title);
            return $title;
        }
        return $title;
    }

    /**
     * Return string of block html
     *
     * @param array $card
     *
     * @return string
     */
    public function outputEpisodeCard($card)
    {
        $html = '';
        $file = locate_template("components/partials/episode-card.php");
        if (file_exists($file)) {
            ob_start();
            include $file;
            $html .= ob_get_contents();
            ob_get_clean();
        }

        return $html;
    }

    /**
     * Return string of block html
     *
     * @param array $card
     *
     * @return string
     */
    public function outputFarmerCard($card)
    {
        $html = '';
        $file = locate_template("components/partials/farmer-card.php");
        if (file_exists($file)) {
            ob_start();
            include $file;
            $html .= ob_get_contents();
            ob_get_clean();
        }

        return $html;
    }

    /**
     * Overwrite the request to use the custom post type for farmer profiles
     *
     * @param $query
     *
     * @return mixed
     */
    public function overwriteRequest($query) {
        if ( count($query->query_vars) > 0 && !empty($query->query_vars['post_type'])) {
            if (!empty($query->query_vars['name'])) {
                $page_name = $query->query_vars['name'];
                $post_type = 'farmer-profiles';
    
                // Check if post with the requested slug exists in your custom post type
                $result = get_posts(array(
                    'post_type' => $post_type,
                    'name' => $page_name
                ));
    
                // If it doesn't, just return the query
                if (count($result) < 1) {
                    return $query;
    
                // If it does, create a new query_vars array to replace the old one.
                } else {
                    $new_query = array(
                        'page' => '',
                        'farmer-profiles' => $page_name,
                        'post_type' => $post_type,
                        'name' => $page_name
                    );
                    $query->query_vars = $new_query;
                    return $query;
                }
            }
        } else {
            return $query;
        }
    }
}