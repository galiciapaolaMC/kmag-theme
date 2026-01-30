<?php
/**
 * Super back button partial template
 */

use CN\App\Fields\Util;

?>
<div id="back-to-resources-button-container" class="back-to-resources-button-container">
    <div class="back-to-resources-button">
        <button class="back-to-resources-button__button btn btn--tertiary">
            <?php
                echo Util::getIconHTML('arrow-left', 0);
            ?>
            <span>
            <?php
                _e('Go back to results', 'kmag');
            ?>
            </span>
        </button>
    </div>
</div>
