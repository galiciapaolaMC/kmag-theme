<?php
/**
 * Template Name: Campaign Page Builder
 *
 * This template displays Advanced Custom Fields
 * flexible content fields in a user-defined order.
 *
 * @package CN
 */

use CN\App\Fields\ACF;

$data = ACF::getPostMeta(get_the_ID());
$gate_this_content = ACF::getField('gated-content_gate-this-content', $data, false);
$gated_content_class = $gate_this_content ? ' gated-content__gated-asset' : '';

$score_action = ACF::getField('scored-content_page-level-score-action', $data, null);

$score_action_attr = '';
if (!is_null($score_action)) {
    $score_action_attr = 'data-score-action="' . esc_attr($score_action) . '"';
}

$campaign_id = ACF::getField('scored-content_campaign', $data, null);
$campaign_action_attr = '';
if (!is_null($campaign_id)) {
    $campaign_action_attr = 'data-campaign-id="' . esc_attr($campaign_id) . '"';
}

?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">

    <?php
    wp_head();
    ?>
</head>

<body <?php body_class(); ?>>

    <?php do_action('cn/styles/icons'); ?>

    <main class="main-container campaign-page-builder super-link-entry-point <?php echo $gated_content_class; ?>" id="primary-campaign" <?php echo $campaign_action_attr; ?> <?php echo $score_action_attr; ?>>
        <?php
        // get_template_part('partials/super-back-button'); 
        // hook: App/Fields/Modules/outputFlexibleModules()
        do_action('cn/modules/output', get_the_ID()); ?>
        <?php
        if ($gate_this_content) {
            $file = locate_template("partials/gated-content.php");
            if (file_exists($file)) {
                include $file;
            }
        }
    ?>
    </main>

    <?php
    wp_footer();
    ?>

</body>
</html>