<?php

/**
 * ACF Module: Agrifact Filter
 *
 * @global $data
 */

use CN\App\Media;
use CN\App\Components\ComboBox;
use CN\App\Fields\ACF;
use CN\App\Fields\Util;

$logo_id = ACF::getField('logo', $data);
$content = ACF::getField('content', $data);
$module_filter_type = ACF::getField('module_filter_type', $data, 'buttons');

// Crops
$args = [
    'object_type' => ['agrifacts']
];
$crops = ComboBox::getTaxItemsForCombobox('crop', $args);

// Products
$preselected_product = ACF::getField('preselected_performance_product', $data);
$preselected_products = !empty($preselected_product) ? [$preselected_product] : [];
$products = ComboBox::getTaxItemsForCombobox('performance-product', $args);
foreach ($products as $key => $product) {
    if (in_array($product['value'], $preselected_products)) {
        $products[$key]['selected'] = true;
    }
}

// Facts
$fact_args = [
    'post_type' => 'agrifacts',
    'posts_per_page' => -1,
    'status' => 'publish',
];

if ($module_filter_type === 'buttons' && count($preselected_products) > 0) {
    $fact_args['tax_query'] = [
        [
            'taxonomy' => 'performance-product',
            'field'    => 'slug',
            'terms'    => $preselected_products
        ]
    ];
}

$temp_crops_term_list = [];
$fact_posts = [];
$facts_crops_term_list = [];
$facts_query = new WP_Query($fact_args);
foreach ($facts_query->posts as $fact) {
    $fact_data = $fact;
    $fact_data->meta = ACF::getPostMeta($fact->ID);
    $fact_data->crops = get_the_terms($fact->ID, 'crop');
    $fact_data->products = get_the_terms($fact->ID, 'performance-product');
    $fact_posts[] = $fact_data;
    if ($fact_data->crops) {
        foreach ($fact_data->crops as $crop) {
            $facts_crops_term_list[] = $crop->slug;
        }
    }
}

if (count($fact_posts) === 0) {
    return;
}

// Remove duplicates then reindex
$facts_crops_term_list = array_merge(array_unique($facts_crops_term_list));

// Remove any crops that aren't attached to anything
foreach ($crops as $index => $crop) {
    if (!in_array($crop['value'], $facts_crops_term_list)) {
        unset($crops[$index]);
    }
}

do_action('cn/modules/styles', $row_id, $data);
?>

<div class="module agrifact-filter" id="<?php echo esc_attr($row_id); ?>">
    <div class="uk-container uk-container-large">
        <div uk-grid>
            <div class="uk-width-1-1 uk-width-2-5@m">
                <div class="agrifact-filter__logo">
                    <?php
                    $attachment = Media::getAttachmentByID($logo_id);
                    if ($attachment) {
                        echo Util::getImageHTML($attachment, 'full');
                    }
                    ?>
                </div>
            </div>
            <div class="uk-width-1-1 uk-width-3-5@m">
                <div class="agrifact-filter__content">
                    <?php echo $content; ?>
                </div>
            </div>
        </div>

        <div class="divider"></div>

        <div class="filter">
            <!-- Crop Filter Buttons -->
            <?php if ($module_filter_type === 'buttons') { ?>
                <div class="filter__buttons">
                    <?php
                    foreach ($crops as $key => $crop) {
                        printf(
                            '<button class="%4$s" data-crop="%1$s">
                                <div class="icon-wrap">%2$s</div>
                                <div>%3$s</div>
                            </button>',
                            $key,
                            Util::getIconHTML($key),
                            $crop['label'],
                            $key === array_key_first($crops) ? 'uk-active' : ''
                        );
                    }
                    ?>
                </div>
            <?php } else { ?>
                <div class="filter__button-group uk-grid uk-grid-small">
                    <div class="uk-width-1-1 uk-width-1-2@s uk-width-1-3@m uk-width-1-4@l">
                        <?php
                        // Single Crop Dropdown
                        $crop_button_list_html = ComboBox::buildSingleSelectListHtml($crops, true);
                        echo ComboBox::getComboboxHtml(
                            [
                                'id' => 'crops',
                                'label-html' => __('Crops', 'kmag'),
                                'list-html' => $crop_button_list_html,
                            ]
                        );
                        ?>
                    </div>
                    <div class="uk-width-1-1 uk-width-1-2@s uk-width-1-3@m uk-width-1-4@l">
                        <?php
                        // Multi Product Dropdown
                        $product_button_list_html = ComboBox::buildMultiSelectProductsListHtml($products);
                        echo ComboBox::getComboboxHtml(
                            [
                                'id' => 'products',
                                'label-html' => __('Products', 'kmag'),
                                'list-html' => $product_button_list_html,
                                'is-multi' => true,
                            ]
                        );
                        ?>
                    </div>
                </div>
            <?php } ?>

            <!-- Filter results -->
            <div class="filter__content uk-grid uk-grid-small uk-child-width-1-1 uk-child-width-1-2@s uk-child-width-1-3@m">
                <?php
                foreach ($fact_posts as $key => $fact) {
                    $file = locate_template("components/partials/agrifact-card.php");
                    if (file_exists($file)) {
                        include $file;
                    }
                }
                ?>
            </div>

            <!-- No results -->
            <div class="filter__no-results uk-text-center uk-hidden">
                <h3><?php _e('No results found', 'kmag'); ?></h3>
            </div>
        </div>
    </div>
</div>