<?php

/**
 * ACF Module: Field Study Page
 *
 * @global $data
 */

namespace CN\App\Fields;

$id_from_url = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
$options = Options::getSiteOptions();
$maps_api_key = ACF::getField('mapbox-api_api-key', $options);
$google_storage_url = ACF::getField('google-storage_field-data-json', $data);
wp_localize_script(
    'cn-theme',
    'field_study',
    [
        'theme_path_url' => CN_THEME_PATH_URL,
        'maps_api_key' => esc_html($maps_api_key),
        'google_storage_url' => esc_html($google_storage_url)
    ]
);
$jsonData = file_get_contents($google_storage_url);
// Decode JSON data
$decoded_data = json_decode($jsonData, true);
if (isset($decoded_data[$id_from_url])) {
    // Use the data for the specific ID
    $data = $decoded_data[$id_from_url];
} else {
    // Assuming the JSON data has a top-level UUID key, we'll access the first element.
    // Handle the case where the ID is not found
    // For example, redirect to a 'not found' page or display an error
    die('Study data not found for the provided ID.');
}
// Extract relevant values
$productName = $data['Study Results']['productName'];
$cropName = $data['Crop'];
$yield = $data['Study Results']['yield'];
$extension = pathinfo($_SERVER['SERVER_NAME'], PATHINFO_EXTENSION);
$img_folder = $extension === 'local' ? 'app' : 'wp-content';

function displayValueOrNR($data, $keyPath, $suffix = '')
{
    // Access nested data using the key path provided, if exists.
    $value = $data;
    foreach ($keyPath as $key) {
        if (is_array($value) && isset($value[$key])) {
            $value = $value[$key];
        } else {
            return 'Not reported'; // Return 'N/A' if the key path doesn't exist or is not an array
        }
    }
    // Check if the value is not empty or zero (to include valid '0' values)
    return ($value !== '' && $value !== null) ? $value . $suffix : 'Not reported';
}
function displayValueOrDash($data, $keyPath, $suffix = '')
{
    // Access nested data using the key path provided, if exists.
    $value = $data;
    foreach ($keyPath as $key) {
        if (is_array($value) && isset($value[$key])) {
            $value = $value[$key];
        } else {
            return '--'; // Return 'N/A' if the key path doesn't exist or is not an array
        }
    }
    // Check if the value is not empty or zero (to include valid '0' values)
    return ($value !== '' && $value !== null) ? $value . $suffix : '--';
}
function getCropIconUrl($data){
    switch(strtolower($data['Crop'])){
        case 'corn':
            echo (CN_THEME_PATH_URL . '/assets/images/icon/corn.svg');
            break;
        case 'winter wheat':
            echo (CN_THEME_PATH_URL . '/assets/images/icon/winter-wheat.svg');
            break;
        case 'spring wheat':
            echo (CN_THEME_PATH_URL . '/assets/images/icon/spring-wheat.svg');
            break;
        case 'canola':
            echo (CN_THEME_PATH_URL . '/assets/images/icon/canola.svg');
            break;
    }
}
do_action('cn/modules/styles', $row_id, $data);
$symbol = ($productName === 'PowerCoat') ? '&trade;' : (($productName === 'BioPath') ? '&reg;' : '');
?>
<link href='https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.css' rel='stylesheet' />
<div class="field-study-page" id="<?php echo esc_attr($row_id); ?>">
    <div class="uk-grid uk-container-large" uk-grid>
        <div class="field-study-band--green">
            <a href="/truresponse-field-studies" class="btn btn--primary field-study-back-btn">
                <svg class="icon icon-arrow-right icon-start icon--rotate-180" aria-hidden="true">
                    <use xlink:href="#icon-arrow-right"></use>
                </svg>
                <span><?php _e('Go Back', 'kmag') ?></span>
            </a>
            <p><?php _e('Go back to map', 'kmag') ?></p>
        </div>
        <div class="uk-width-1-5@m uk-width-1-1@s standard-article__share-container share-desktop">

        </div>
        <div class="uk-width-4-5@m uk-width-1-1@s">
            <div class="field-study-results-heading">
                <h1><?php _e('Field Study Details', 'kmag') ?></h1>
            </div>
            <div class="field-study-heading">
                <img src="<?php echo (getCropIconUrl($data)) ?>" class="field-study-crop-icon">
                <h2>
                <?php echo esc_html($productName);?><span class="super"><?php echo $symbol; ?></span> <?php _e('Application in', 'kmag') ?> <?php echo esc_html($cropName); ?> <?php _e('Study', 'kmag') ?>
                </h2>
            </div>
            <div class="field-study-details">
                <p><strong><?php _e('Crop:', 'kmag') ?></strong> <?php echo esc_html($cropName) ?> </p>
                <p><strong><?php _e('Study:', 'kmag') ?></strong> <?php echo esc_html($data['Study']); ?></p>
                <p><strong><?php _e('Application Method:', 'kmag') ?></strong> <?php echo esc_html(displayValueOrNR($data, ['Fertilizer Application Method'])); ?></p>
                <p><strong><?php _e('Previous Crop:', 'kmag') ?></strong> <?php echo esc_html(displayValueOrNR($data, ['Previous Crop'])); ?></p>
                <p><strong><?php _e('Planting Date:', 'kmag') ?></strong> <?php echo esc_html(displayValueOrNR($data, ['Planting Date'])); ?></p>
                <p><strong><?php _e('Harvest Date:', 'kmag') ?></strong> <?php echo esc_html(displayValueOrNR($data, ['Harvest Date'])); ?></p>
                <p><strong><?php _e('Location:', 'kmag') ?></strong> <?php echo esc_html(displayValueOrNR($data, ['Location'])); ?></p>
            </div>
        </div>
    </div>
    <hr>
    <div class="uk-grid uk-container-large" uk-grid>
        <div class="uk-width-1-5@m uk-width-1-1@s standard-article__share-container share-desktop">
            <p><?php _e('SHARE:', 'kmag'); ?></p>
            <?php echo sharethis_inline_buttons(); ?>
        </div>
        <div class="uk-width-4-5@m uk-width-1-1@s">
            <div class="field-study-band">
                <h4><?php _e('Study Results:', 'kmag') ?></h4>
                <div class="large-font"><?php echo esc_html($productName); ?> <?php _e('treated crop yield difference', 'kmag') ?> <?php echo ($yield >= 0) ? "+" : ""; ?><strong><?php echo esc_html($yield); ?> <?php _e('bu/ac', 'kmag') ?></strong></div>
                <?php if (!empty($data['Ag Comments'])) : ?> <!-- Check if 'Ag Comments' is not empty -->
                    <div class="ag-comment">
                        <p><?php echo esc_html($data['Ag Comments']) ?></p>
                    </div>
                <?php endif; ?>
            </div>
            <div class="uk-grid" uk-grid>
                <div class="uk-width-2-5@m uk-width-1-1@s">
                    <div class="field-study-results">
                        <div class="field-study-results-difference">
                            <div class="field-study-results-title"><?php _e('Difference', 'kmag') ?></div>
                            <div class="difference"><?php echo esc_html(displayValueOrDash($data, ['Study Results', 'yield'])); ?> <span class="small-text"><?php _e('bu/ac', 'kmag') ?></span></div>
                        </div>
                        <div class="field-study-results-yield">
                            <div class="field-study-results-title"><?php _e('Yield', 'kmag') ?></div>
                            <div class="inline-heading">
                                <div class="treated"><?php _e('Treated with', 'kmag') ?> <?php echo esc_html($productName); ?></div>
                                <div class="untreated"><?php _e('Untreated', 'kmag') ?></div>
                            </div>
                            <div class="inline-numbers">
                                <div class="treated"><?php echo esc_html(displayValueOrDash($data, ['Yield', 'Treated with product'])); ?> <?php if (!empty($data['Yield']['Treated with product'])) : ?><span class="small-text"><?php _e('bu/ac', 'kmag') ?></span><?php endif; ?></div>
                                <div class="untreated"><?php echo esc_html(displayValueOrDash($data, ['Yield', 'Grower Standard Practice'])); ?> <?php if (!empty($data['Yield']['Grower Standard Practice'])) : ?><span class="small-text"><?php _e('bu/ac', 'kmag') ?></span><?php endif; ?></div>
                            </div>
                        </div>
                        <div class="field-study-results-col">
                            <div class="field-study-results-title">Moisture</div>
                            <div class="inline-heading">
                                <div class="treated"><?php _e('Treated with', 'kmag') ?> <?php echo esc_html($productName) ?></div>
                            </div>
                            <div class="inline-numbers">
                                <div class="treated"><?php echo esc_html(displayValueOrDash($data, ['Moisture', 'Treated with product'], '%')); ?></div>
                            </div>
                            <div class="inline-heading">
                                <div class="untreated"><?php _e('Untreated', 'kmag') ?></div>
                            </div>
                            <div class="inline-numbers">
                                <div class="untreated"><?php echo esc_html(displayValueOrDash($data, ['Moisture', 'Grower Standard Practice'], '%')); ?></div>
                            </div>
                        </div>
                        <div class="field-study-results-col">
                            <div class="field-study-results-title"><?php _e('Test Weight', 'kmag') ?></div>
                            <div class="inline-heading">
                                <div class="treated"><?php _e('Treated with', 'kmag') ?> <?php echo esc_html($productName); ?></div>
                            </div>
                            <div class="inline-numbers">
                                <div class="treated"><?php echo esc_html(displayValueOrDash($data, ['Test Weight', 'Treated with product'])); ?> <?php if (!empty($data['Test Weight']['Treated with product'])) : ?><span class="small-text"><?php _e('lb/bu', 'kmag') ?></span><?php endif; ?></div>
                            </div>
                            <div class="inline-heading">
                                <div class="untreated"><?php _e('Untreated', 'kmag') ?></div>
                            </div>
                            <div class="inline-numbers">
                                <div class="untreated"><?php echo esc_html(displayValueOrDash($data, ['Test Weight', 'Grower Standard Practice'])); ?> <?php if (!empty($data['Test Weight']['Grower Standard Practice'])) : ?><span class="small-text"><?php _e('lb/bu', 'kmag') ?></span><?php endif; ?></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="uk-width-3-5@m uk-width-1-1@s">
                    <div class="field-study-imagery">
                        <div class="field-boundry-image">
                            <div id="field-study-map"></div>
                        </div>
                        <div class="field-boundry-image-caption"><?php _e('Green bounded area indicates', 'kmag') ?> <?php echo esc_html($productName); ?> <?php _e('treated area of field.', 'kmag') ?></div>
                    </div>
                </div>
            </div>
            <div class="field-study-protocols">
            <div class="large-font-thin"><?php _e('Study Protocol:', 'kmag') ?></div>
            <div class="uk-grid" uk-grid>
            <div class="uk-width-3-5@m uk-width-1-1@s">
                
                <p><strong><?php _e('Fertilizer Application Method:', 'kmag') ?></strong> <?php echo esc_html(displayValueOrNR($data, ['Study Protocols', 'Fertilizer Application Method'])); ?></p>
                <p><strong><?php _e('Tillage Practice:', 'kmag') ?></strong> <?php echo esc_html(displayValueOrNR($data, ['Study Protocols', 'Tillage Practice'])); ?></p>
                <?php if (!empty($data['Study Protocols']['Irrigation'])) : ?>
                    <p><strong><?php _e('Irrigation:', 'crop-nutrtition') ?></strong> <?php echo esc_html(displayValueOrNR($data, ['Study Protocols', 'Irrigation'])); ?></p>
                <?php endif; ?>
                <?php if (!empty($data['Study Protocols']['Soil OM %'])) : ?>
                    <p><strong><?php _e('Soil OM %:', 'crop-nutrtition') ?></strong> <?php echo esc_html(displayValueOrNR($data, ['Study Protocols', 'Soil OM %'], '%')); ?></p>
                <?php endif; ?>
                </div>
                <div class="uk-width-2-5@m uk-width-1-1@s">
                <?php if (!empty($data['Study Protocols']['Soil pH (buffered)'])) : ?>
                    <p><strong><?php _e('Soil pH (buffered):', 'crop-nutrtition') ?></strong> <?php echo esc_html(displayValueOrNR($data, ['Study Protocols', 'Soil pH (buffered)'], ' pH')); ?></p>
                <?php endif; ?>
                <?php if (!empty($data['Study Protocols']['Soil CEC (cation exchange capacity)'])) : ?>
                    <p><strong><?php _e('Soil CEC (cation exchange capacity):', 'crop-nutrtition') ?></strong> <?php echo esc_html(displayValueOrNR($data, ['Study Protocols', 'Soil CEC (cation exchange capacity)'], ' meq/100g')); ?></p>
                <?php endif; ?>
                </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
</div>