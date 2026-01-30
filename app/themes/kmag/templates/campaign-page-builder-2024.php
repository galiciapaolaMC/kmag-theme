<?php
/**
 * Template Name: Campaign Page Builder (2024)
 *
 * This template displays Advanced Custom Fields
 * flexible content fields in a user-defined order.
 *
 * @package CN
 */

use CN\App\Fields\ACF;
use CN\App\Fields\Options;

$options = Options::getSiteOptions();
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

$attribute_name = ACF::getField('page-attribute_attribute-name', $data);
$page_attr = '';
if (!is_null($attribute_name)) {
    $page_attr = 'data-post-type="' . esc_attr($attribute_name) . '"';
}

get_template_part('partials/header-pf'); 

$desktop_navigation = ACF::getField('page-navigation_desktop-navigation', $data, 'false');
$mobile_navigation = ACF::getField('page-navigation_mobile-navigation', $data, 'false');

$desktop_margin = '';
$mobile_margin = '';

if($desktop_navigation === 'false') {
    $desktop_margin = 'remove-margin';
}

if($mobile_navigation === 'false') {
    $mobile_margin = 'remove-margin-mobile';
}

if ($desktop_navigation === 'false' && $mobile_navigation === 'false') {
    $desktop_margin = 'remove-margin-all';
}

wp_localize_script('cn-theme', 'ignore_crop_region_dynamics', array(
    'ignore' => true
));

$replace_link_target_attribute = ACF::getField('link-replacement_replace-link-target-value', $data, false);


if ($replace_link_target_attribute === '1') {
    wp_localize_script('cn-theme', 'replace_link_target_attribute', array(
        'replace' => true
    ));
}

$footer_scripts = ACF::getField('footer_scripts', $options);
$head_scripts = ACF::getField('head_scripts', $options);
$body_scripts = ACF::getField('body_scripts', $options);

?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">

    <?php
    wp_head();

    echo $head_scripts;

    ?>
</head>

<body <?php body_class(); ?>>
    <?php echo $body_scripts; ?>

    <!-- skip to main content -->
    <a href="#primary" class="screen-reader-text"><?php _e('Skip to Main Content', 'kmag'); ?></a>

    <?php do_action('cn/styles/icons'); ?>

    <main class="main-container campaign-page-builder-2024 super-link-entry-point <?php echo $gated_content_class; ?> <?php echo esc_attr($desktop_margin); ?> <?php echo esc_attr($mobile_margin ); ?>" id="primary-campaign" <?php echo $campaign_action_attr; ?> <?php echo $score_action_attr; ?> <?php echo $page_attr; ?>>
        <?php
        // get_template_part('partials/super-back-button'); 
        get_template_part('partials/announcement-bar'); 
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
    echo $footer_scripts;
?>
</body>
</html>
