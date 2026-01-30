<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package CN
 */

get_header(); ?>

<main class="main-container" id="primary">
    <div class="uk-container uk-container-large">
        <div uk-grid>
            <div class="uk-width-s">
                <header class="entry__header">
                    <h1 class="hdg hdg--1">
                        <?php _e('Page Not Found', 'kmag'); ?>
                    </h1>
                </header><!-- /.entry__header -->

                <div class="entry__content">
                    <?php
                    _e(
                        '<p>It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.</p>',
                        'kmag'
                    );
                    get_search_form();
                    ?>
                </div><!-- /.entry__content -->
            </div><!-- /#primary -->

            <?php get_sidebar(); ?>
        </div>
    </div>
</main>

<?php get_footer();