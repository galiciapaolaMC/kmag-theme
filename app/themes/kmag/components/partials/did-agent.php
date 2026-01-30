<?php
/**
 * ACF Module Partial: Did Agent
 *
 * @var array $data
 *
 * @var string $cell_number
 */

use CN\App\Fields\ACF;
use CN\App\Fields\Util;

$agent_id = ACF::getField('agent-id', $data);
$div_id = ACF::getField('div-id', $data);
$height = ACF::getField('desktop-height', $data);
$mobile_height = ACF::getField('mobile-height', $data);

if (!$agent_id || !$div_id) {
    return;
}

$agent_div_id = $row_id . '_' . $cell_number . '_' . $agent_id;
$agent_version = ACF::getField('agent-version', $data, 'v2');
?>

<div class="partial did-agent" id="<?php echo esc_attr($agent_div_id); ?>">
    <script type="module"
        src="https://agent.d-id.com/<?php echo $agent_version; ?>/index.js"
        data-mode="full"
        data-client-key="YXV0aDB8Njc0NzZhMDg3YjE5OTJkYWI1YmYyMDBiOm85ZzRXMmE4QmVUT3A2QnFKZzhfeg=="
        data-agent-id="v2_agt_OK5Aa5nH"
        data-name="did-agent"
        data-target-id="<?php echo esc_attr($agent_div_id); ?>"
        data-monitor="true"
    ></script>
    <style>
        #<?php echo esc_attr($agent_div_id); ?> {
            height: <?php echo esc_attr($height); ?>px;
        }

        @media (max-width: 640px) {
            #<?php echo esc_attr($agent_div_id); ?> {
                height: <?php echo esc_attr($mobile_height); ?>px;
            }
        }
    </style>
</div>