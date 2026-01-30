<?php
/**
 * ACF Module: Accordion
 *
 * @global $data
 */

use CN\App\Fields\ACF;
use CN\App\Fields\Util;

$accordion = ACF::getRowsLayout('accordion-block', $data);

if (!$accordion) {
    return;
}

do_action('cn/modules/styles', $row_id, $data);
?>

<div class="module accordion" id="<?php echo esc_attr($row_id); ?>">
    <ul uk-accordion>
        <?php foreach ($accordion as $index => $item) {
            $headline = ACF::getField('headline', $item);
            $content = ACF::getField('content', $item);
            $list_items = ACF::getRowsLayout('list', $item); ?>
        <li class="accordion__container">
            <button class="accordion__headline uk-accordion-title">
                <?php echo esc_html($headline); ?>

                <svg class="icon icon-accordion-close" aria-hidden="true">
                    <use xlink:href="#icon-accordion-close"></use>
                </svg>

                <svg class="icon icon-accordion-open" aria-hidden="true">
                    <use xlink:href="#icon-accordion-open"></use>
                </svg>
            </button>

            <div class="uk-accordion-content accordion__content">
                <?php
                 if($content):                
                    ?>
                <div class="a_description accordion__content">
                    <?php  echo apply_filters('the_content', $content); ?>
                </div>
                <?php 
                endif;
                
                    foreach ($list_items as $list) {
                        $title = ACF::getField('title', $list);
                        $link = ACF::getField('link', $list);
                        $download = ACF::getField('file-download', $list);
                        
                        if (!empty($link) && !empty($download)) {
                            $button_width = 'uk-width-1-4@m';
                        } else {
                            $button_width = 'uk-width-1-6@m';
                        } 
                        
                        ?>

                <div class="accordion__content-row uk-grid-small" uk-grid>
                    <div class="title-block uk-width-expand@m uk-width-1-1@s" uk-leader="media: @m, fill: - ">
                        <p class="title"><?php echo esc_html($title); ?></p>
                    </div>
                    <div class="uk-text-right uk-width-auto@m buttons-block uk-width-1-1@s">
                        <?php if (!empty($link)) {
                                    echo Util::getButtonHTML($link, ['class' => 'underline-link']);
                                } ?>

                        <?php if (!empty($download)) {
                                    echo Util::getButtonHTML($download, ['class' => 'btn btn--small', 'icon-end' => 'download-arrow']);
                                } ?>
                    </div>
                </div>
                <?php } ?>
            </div>
        </li>
        <?php } ?>
    </ul>
</div>