<?php
/**
 * The template for displaying all single posts.
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

get_header(); ?>

<main class="main-container <?php echo $gated_content_class; ?>" id="primary" <?php echo $campaign_action_attr; ?> <?php echo $score_action_attr; ?>>
    <div class="uk-container uk-container-large top-<?php echo get_post_type();?>-container">
            <div class="single-container">
                <?php
                while (have_posts()) {
                    the_post();
                    // Loads the content/singular/page.php template.
                    get_template_part('content/singular/' . get_post_type());
                }
                ?>
            </div>
        </div>
    </div>
    <?php 
    if ($gate_this_content) {
        $file = locate_template("partials/gated-content.php");
        if (file_exists($file)) {
            include $file;
        }
    }
    ?>
</main>

<?php get_footer();