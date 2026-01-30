<?php
/**
 * ACF Module: Nutrient Deficiencies
 *
 * @global $data
 */

use CN\App\Fields\ACF;
use CN\App\Fields\Util;
use CN\App\Media;

$nutrient = ACF::getField('nutrient', $data);
$photo_credit = ACF::getField('image-credit', $data);

$args = array(
    'post_type' => 'nutrient-deficits',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'order' => 'ASC'
);

$nutrient_deficit_query =  new \WP_Query($args);

do_action('cn/modules/styles', $row_id, $data);

if (!$nutrient_deficit_query->have_posts()) {
    return;
}

$nutrient_deficits = array();
foreach ($nutrient_deficit_query->posts as $nutrient_deficit) {
    $post_title = $nutrient_deficit->post_title;
    if (str_contains(strtolower($post_title), strtolower($nutrient))) {
        $meta = $nutrient_deficit->meta ?? ACF::getPostMeta($nutrient_deficit->ID);
        $deficit_image_ids = array();
        $deficit_image_rows = ACF::getRowsLayout('deficit_images', $meta);
        $crop_val = esc_html(ACF::getField('crop', $meta));
        $standardized_crop_val = str_replace(' ', '-', strtolower($crop_val));
        foreach ($deficit_image_rows as $row) {
            $deficit_image_ids[] = $row['image'];
        }

        $nutrient_deficits[] = array(
            'crop' => $crop_val,
            'aria-control-name' => $row_id . '-crop-content-' . $standardized_crop_val,
            'tab-id' => $row_id . '-crop-tab-' . $standardized_crop_val,
            'instance-id' => $row_id,
            'deficit-image-ids' => $deficit_image_ids
        );
    }
}

?>

<div class="module nutrient-deficiencies" id="<?php echo esc_attr($row_id); ?>">
    <div class="uk-container">
    <div role="tablist" class="nutrient-deficiencies__tabs">
        <?php
            foreach ($nutrient_deficits as $index => $nutrient_deficit) {
                $crop = str_replace(' ', '-', strtolower(esc_html($nutrient_deficit['crop'])));
                $arr = explode(' ', $nutrient_deficit['crop']);
                
                if (count($arr) === 2) {
                    $crop_title = '<span>' . esc_html($arr[0]) . '</span><span>' . esc_html($arr[1]) . '</span>';
                } else {
                    $crop_title = '<span>' . esc_html($nutrient_deficit['crop']) . '</span>';
                }

                // select first icon by default;
                $aria_selected_val = $index === 0 ? 'true' : 'false'; 

                printf(
                    '<button 
                        class="nutrient-deficiencies__tab"
                        aria-controls="%1$s"
                        aria-label="%6$s"
                        id="%3$s"
                        role="tab"
                        tabindex="0"
                        aria-selected="%4$s"
                        data-instance-id="%5$s"
                        data-tab-crop="%6$s"
                    >
                        <div class="tab-icon-container">
                            %2$s
                        </div>
                        <div class="tab-icon-title">
                            %7$s
                        </div>
                    </button>',
                    esc_attr($nutrient_deficit['aria-control-name']),
                    Util::getIconHTML($crop),
                    esc_attr($nutrient_deficit['tab-id']),
                    $aria_selected_val,
                    esc_attr($nutrient_deficit['instance-id']),
                    $crop,
                    $crop_title
                );
            }
        ?>
    </div>
    <section class="nutrient-deficiencies__tab-panels">
        <?php
            foreach ($nutrient_deficits as $index => $nutrient_deficit) {
                $image_carousel_string = '';
                // expand first panel by default
                $aria_expanded_val = $index === 0 ? 'true' : 'false';
                foreach ($nutrient_deficit['deficit-image-ids'] as $image_id) {
                    $image_attachment  = Media::getAttachmentByID($image_id);
                    $inline_image_styles = Util::getBackgroundImageStyle($image_id);
                    $alt = ! empty($image_attachment) && !empty($image_attachment->alt) ? esc_attr($image_attachment->alt) : esc_attr($image_attachment->title);
                    $image_markup = sprintf(
                        '<li><div class="nutrient-deficiencies__image" role="img" aria-label="%1$s" style="%2$s"></div></li>',
                        $alt,
                        esc_attr($inline_image_styles)
                    );
                    $image_carousel_string .= $image_markup;
                }

                $controls = sprintf(
                    '<div class="nutrient-deficiencies__carousel-controls">
                        <button uk-slider-item="previous">
                            %1$s
                        </button>
                        <button uk-slider-item="next">
                            %2$s
                        </button>
                    </div>',
                    Util::getIconHTML('arrow-left', 0),
                    Util::getIconHTML('arrow-right')
                );

                printf(
                    '<div
                        class="nutrient-deficiencies__tab-panel"
                        id="%1$s"
                        role="tabpanel"
                        aria-expanded="%3$s"
                        data-instance-id="%4$s" 
                        uk-slider
                    >
                        <ul class="uk-slider-items">
                            %2$s
                        </ul>
                        %5$s
                    </div>',
                    esc_attr($nutrient_deficit['aria-control-name']),
                    $image_carousel_string,
                    $aria_expanded_val,
                    esc_attr($nutrient_deficit['instance-id']),
                    $controls
                );
            }
        ?>
    </section>
    <section class="nutrient-deficiencies__content">
        <?php 
            printf(
                '<h2> %1$s %2$s <span data-crop-val>%3$s</span></h2>',
                ucfirst(esc_html($nutrient)),
                __('Deficiency in', 'kmag'),
                esc_html($nutrient_deficits[0]['crop'])
            );
        ?>
        <p>
            <?php echo esc_html($photo_credit) ?>
        </p>
    </section>
    </div>
</div>