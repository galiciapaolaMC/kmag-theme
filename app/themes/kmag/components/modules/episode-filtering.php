<?php
/**
 * ACF Module: Episode Filtering
 *
 * @global $data
 */

use CN\App\Fields\ACF;

$filter_type = ACF::getField('filter-type', $data);

if (! $filter_type) {
    return;
}

do_action('cn/modules/styles', $row_id, $data);
?>

<div class="module episode-filtering" id="<?php echo esc_attr($row_id); ?>">
    <div class="uk-container uk-container-large">
        <?php switch ($filter_type) {
            case 'grid':
                $file = locate_template("components/modules/episode-grid.php");
                if (file_exists($file)) {
                    include $file;
                }
                break;
            case 'slider':
                $file = locate_template("components/modules/episode-slider.php");
                if (file_exists($file)) {
                    include $file;
                }
                break;
            default:
                echo '<!-- Episode module missing filter type field -->';
                return;
        } ?>

        <?php echo '<input type="hidden" name="nonce" value="' . wp_create_nonce('wp_rest') . '" />' ?>
    </div>
</div>
