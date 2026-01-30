<?php
/**
 * Template Name: Page Builder
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

$attribute_name = ACF::getField('page-attribute_attribute-name', $data);
$page_attr = '';
if (!is_null($attribute_name)) {
    $page_attr = 'data-post-type="' . esc_attr($attribute_name) . '"';
}

$ignore_crop_region_dynamics = ACF::getField('dynamic-content-replacement_ignore-crop-region', $data, false);
$replace_link_target_attribute = ACF::getField('link-replacement_replace-link-target-value', $data, false);

$ai_agent_button_location = ACF::getField('ai-agent_agent-button-location', $data, 'disabled');
$ai_agent_disabled = $ai_agent_button_location === 'disabled';

get_header(); 

if ($ignore_crop_region_dynamics === '1') {
    wp_localize_script('cn-theme', 'ignore_crop_region_dynamics', array(
        'ignore' => true
    ));
}

if ($replace_link_target_attribute === '1') {
    wp_localize_script('cn-theme', 'replace_link_target_attribute', array(
        'replace' => true
    ));
}
?>

<main class="main-container super-link-entry-point <?php echo $gated_content_class; ?>" id="primary" <?php echo $campaign_action_attr; ?> <?php echo $score_action_attr; ?> <?php echo $page_attr; ?>>
    
    <?php
    get_template_part('partials/super-back-button'); 
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
if (!$ai_agent_disabled) {
    $ai_agent_id = ACF::getField('ai-agent_agent-id', $data);
    $ai_agent_version = ACF::getField('ai-agent_agent-version', $data, 'v2');
?>
    <script type="module"
        src="https://agent.d-id.com/<?php echo esc_attr($ai_agent_version); ?>/index.js"
        data-mode="fabio"
        data-client-key="YXV0aDB8Njc0NzZhMDg3YjE5OTJkYWI1YmYyMDBiOm85ZzRXMmE4QmVUT3A2QnFKZzhfeg=="
        data-agent-id="<?php echo esc_attr($ai_agent_id); ?>"
        data-name="did-agent"
        data-orientation="horizontal"
        data-position="<?php echo $ai_agent_button_location; ?>"
        data-monitor="true"
    >
    </script>
<?php
}


get_footer();