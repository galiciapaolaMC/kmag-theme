<?php
/**
 * Template Name: Field Study Detail
 *
 * This template displays Advanced Custom Fields
 * flexible content fields in a user-defined order.
 *
 * @package CN
 */

$post_id = get_the_ID();
get_header(); 
?>

<main class="main-container super-link-entry-point" id="primary">
    
    <?php
    get_template_part('partials/super-back-button'); 
    // hook: App/Fields/Modules/outputFlexibleModules()
    do_action('cn/modules/output', $post_id); ?>
    <?php
        $file = locate_template("partials/related-content-from-query-params.php");
        if (file_exists($file)) {
            include $file;
        }
    ?>
</main>

<?php 
get_footer();
