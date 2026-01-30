<?php
/**
 * Farmer Profiles template file.
 */

use CN\App\Media;
use CN\App\Fields\ACF;
use CN\App\Fields\Util;

$post_id = get_the_ID();
$data = ACF::getPostMeta($post_id);

?>

<article id="post-<?php the_ID(); ?>" class="farmer-profile" data-post-type="farmer-profile">
    <div class="farmer-profile__body">
        <?php do_action('cn/modules/output', get_the_ID()); ?>
    </div>
</article>
