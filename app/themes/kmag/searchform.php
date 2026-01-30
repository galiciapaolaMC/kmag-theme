<?php
/**
 * Default search form.
 *
 * @package CN
 */
?>

<form role="search" method="get" id="searchform" class="searchform" action="<?php echo get_home_url(); ?>">
    <div class="form-group">
        <div class="input-group">
            <input type="text" class="form-control"
                   placeholder="<?php _e('Search …', 'kmag') ?>"
                   value="<?php echo get_search_query() ?>" name="s"
                   title="<?php _e('Search for:', 'kmag') ?>"/>
            <div class="input-group-btn">
                <button class="btn btn-default" type="submit">
                    <?php _e('Search', 'kmag') ?>
                </button>
            </div>
        </div>
    </div>
</form>