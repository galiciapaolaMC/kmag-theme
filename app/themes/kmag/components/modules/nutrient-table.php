<?php
/**
 * ACF Module: Nutrient Table
 *
 * @global $data
 *
 *
 */

use CN\App\Fields\ACF;

$macro_nutrients = ACF::getField('macro_nutrients', $data);
$macronutrient_name = ACF::getField('macronutrient_name', $data);
$secondary_nutrients = ACF::getField('secondary_nutrients', $data);
$secondary_nutrient_name = ACF::getField('secondary_nutrient_name', $data);
$micro_nutrients = ACF::getField('micro_nutrients', $data);
$micronutrient_name = ACF::getField('micronutrient_name', $data);
$non_fertilizer_nutrients = ACF::getField('non_fertilizer_nutrients', $data);
$non_fertilizer_name = ACF::getField('non_fertilizer_name', $data);

do_action('cn/modules/styles', $row_id, $data);
?>

<section class="module nutrient-table" id="<?php echo esc_attr($row_id); ?>">
    <div class="uk-grid-collapse nutrient-table__wrapper" uk-height-match="row: true" uk-grid>
        <div class="uk-width-3-5@l nutrient-table__table">
            <div class="nutrient-table__inside-wrap">
                <div class="uk-grid uk-grid-collapse uk-child-width-1-2@m uk-child-width-1-1@s nutrient-table__row">
                    <div class="nutrient-table__first-container">
                        <div class="uk-grid uk-grid-collapse uk-child-width-1-4 nutrient-table__grid-box-three three-first grid-box" uk-grid data-container="first">
                            <?php
                                $macros = [];

                            foreach ($macro_nutrients as $item) :
                                $fields = ACF::getPostMeta($item);
                            
                                $macros[esc_html($fields['slug'])] = esc_html($fields['excerpt']);

                                ?>
                            <button class="nutrient-table__nutrient-box" data-nutrient="<?php echo esc_attr($fields['slug']); ?>" data-symbol="<?php echo esc_attr($fields['symbol']); ?>">
                                <p class="nutrient-symbol"><?php echo esc_html($fields['symbol']); ?></p>
                                <p class="nutrient-name"><?php echo esc_html(ucfirst($fields['slug'])); ?></p>
                            </button>

                            <?php endforeach; ?>
                        </div>

                        <div class="uk-width-expand nutrient-table__nutrient-box-group box-group-first">
                            <p class="group-name"><?php echo esc_html($macronutrient_name); ?></p>
                        </div>
                    </div>
                    
                    <div>
                        <div class="uk-grid uk-grid-collapse uk-child-width-1-4 nutrient-table__grid-box-three grid-box" uk-grid data-container="second">
                            <?php
                                $secondaries = [];

                            foreach ($secondary_nutrients as $item) :
                                $fields = ACF::getPostMeta($item);

                                $secondaries[esc_html($fields['slug'])] = esc_html($fields['excerpt']);

                                ?>
                            <button class="nutrient-table__nutrient-box" data-nutrient="<?php echo esc_attr($fields['slug']); ?>" data-symbol="<?php echo esc_attr($fields['symbol']); ?>">
                                <p class="nutrient-symbol"><?php echo esc_html($fields['symbol']); ?></p>
                                <p class="nutrient-name"><?php echo esc_html(ucfirst($fields['slug'])); ?></p>
                            </button>

                            <?php endforeach; ?>
                        </div>

                        <div class="uk-width-expand nutrient-table__nutrient-box-group box-group-second">
                            <p class="group-name"><?php echo esc_html($secondary_nutrient_name); ?></p>
                        </div>
                    </div>
                </div>
                <div class="uk-grid uk-grid-collapse uk-child-width-1-2@m uk-child-width-1-1@s nutrient-table__row">
                    <div>
                        <div class="uk-grid uk-grid-collapse uk-child-width-1-4 nutrient-table__grid-box-four grid-box" uk-grid data-container="third">
                            <?php
                                $micros = [];

                            foreach ($micro_nutrients as $item) :
                                $fields = ACF::getPostMeta($item);

                                $micros[esc_html($fields['slug'])] = esc_html($fields['excerpt']);

                                ?>
                            <button class="nutrient-table__nutrient-box" data-nutrient="<?php echo esc_attr($fields['slug']); ?>" data-symbol="<?php echo esc_attr($fields['symbol']); ?>">
                                <p class="nutrient-symbol"><?php echo esc_html($fields['symbol']); ?></p>
                                <p class="nutrient-name"><?php echo esc_html(ucfirst($fields['slug'])); ?></p>
                            </button>

                            <?php endforeach; ?>
                        </div>

                        <div class="uk-width-expand nutrient-table__nutrient-box-group box-group-third">
                            <p class="group-name"><?php echo esc_html($micronutrient_name); ?></p>
                        </div>
                    </div>

                    <div>
                        <div class="uk-grid uk-grid-collapse uk-child-width-1-4 nutrient-table__grid-box-three three-last grid-box" uk-grid data-container="fourth">
                            <?php
                                $elements = [];

                            foreach ($non_fertilizer_nutrients as $item) :
                                $fields = ACF::getPostMeta($item);

                                $elements[esc_html($fields['slug'])] = esc_html($fields['excerpt']);

                                ?>
                            <button class="nutrient-table__nutrient-box" data-nutrient="<?php echo esc_attr($fields['slug']); ?>" data-symbol="<?php echo esc_attr($fields['symbol']); ?>">
                                <p class="nutrient-symbol"><?php echo esc_html($fields['symbol']); ?></p>
                                <p class="nutrient-name"><?php echo esc_html(ucfirst($fields['slug'])); ?></p>
                            </button>

                            <?php endforeach; ?>
                        </div>
                        
                        <div class="uk-width-expand nutrient-table__nutrient-box-group box-group-fourth">
                            <p class="group-name"><?php echo esc_html($non_fertilizer_name); ?></p>
                        </div>

                        <?php
                        wp_localize_script('cn-theme', 'nutrient_excerpts', array(
                            'excerpts' => array_merge($macros, $secondaries, $micros, $elements)
                        ));

                        wp_reset_postdata();
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="uk-width-2-5@l nutrient-table__excerpt">
            <!--Description added here with JS---->
        </div>
    </div>
    <?php echo do_shortcode('[mc_modal trigger_type="event" event_name="nutrient-table-event" has_close_button="true" close_on_background_click="true"]<div class="nutrient-table-modal"></div>[/mc_modal]'); ?>
</section>

