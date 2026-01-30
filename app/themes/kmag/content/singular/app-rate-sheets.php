<?php

/**
 * Application Rates sheet template file.
 */

 use CN\App\Media;
 use CN\App\Fields\ACF;
 use CN\App\Fields\Util;
 

$post_id = get_the_ID();
$data = ACF::getPostMeta($post_id);
$post_title = get_the_title();
$table_title = get_field('table_title');
$table_headers = get_field('table_headers');
$table_data  = get_field('table_data');
$blocks = get_field('method_blocks'); 
$file = ACF::getField('pdf', $data);
?>

<article id="post-<?php the_ID(); ?>" class="app-rate-sheets" data-post-type="product-sheet">
    <?php get_template_part('partials/back-to-resources-button'); ?>
    <div class="app-rate-sheets__header">
        
        <div class="page_heading">
            <h1><?php _e($post_title, 'kmag'); ?></h1>

            <?php if (!empty($file)) {
                $pdf_url = Media::getPdfSrcByID($file); ?>
                <a href="<?php echo esc_url($pdf_url); ?>" target="_blank"
                    class="btn btn-primary btn-pdf-download">
                    <?php _e('Download PDF', 'kmag'); ?>
                    <svg class="icon icon-download" aria-hidden="true">
                        <use xlink:href="#icon-download"></use>
                    </svg>
                </a>
            <?php } ?>
        </div>
        
    </div>
    <div class="app-rate-sheets__body">
        <div class="uk-container uk-container-large">
            <div class="uk-grid uk-container-large" uk-grid>
                <?php if (!empty($table_data)) : ?>
                    <div class="app-rate-sheets table-block">
                        <?php if (!empty($table_title)) : ?>
                            <h3 class="table-title"><?php echo esc_html($table_title); ?></h3>
                        <?php endif; ?>

                        <table class="app-rate-table">
                            <?php if (!empty($table_headers)) : ?>
                                <thead>
                                    <tr>
                                        <?php foreach ($table_headers as $header) : ?>
                                            <th><?php echo esc_html($header['header_label'] ?? ''); ?></th>
                                        <?php endforeach; ?>
                                    </tr>
                                </thead>
                            <?php endif; ?>
                            <tbody>
                                <?php foreach ($table_data as $row) :
                                    $column_1 = $row['column_1'] ?? '';
                                    $column_2 = !empty($row['column_2']) && is_array($row['column_2']) ? $row['column_2'] : [];
                                    $column_3 = !empty($row['column_3']) && is_array($row['column_3']) ? $row['column_3'] : [];

                                    $max = max(count($column_2), count($column_3));
                                    $max = $max > 0 ? $max : 1;
                                ?>
                                    <?php for ($i = 0; $i < $max; $i++) : ?>
                                        <tr>
                                            <?php if ($i === 0) : ?>
                                                <td rowspan="<?php echo esc_attr($max); ?>" class="crop-cell">
                                                    <?php echo wp_kses_post($column_1); ?>
                                                </td>
                                            <?php endif; ?>

                                            <td>
                                                <?php echo isset($column_2[$i]['point']) ? esc_html($column_2[$i]['point']) : ''; ?>
                                            </td>
                                            <td>
                                                <?php echo isset($column_3[$i]['point']) ? esc_html($column_3[$i]['point']) : ''; ?>
                                            </td>
                                        </tr>
                                    <?php endfor; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>

                
                <?php if (!empty($blocks)) : ?>
                    
                    <div class="application-method-table table-block">
                        <?php foreach ($blocks as $block) : ?>
                            <table class="app-rate-table tab-block">
                                    <thead>
                                        <tr>
                                            <th class="application-title">
                                                <?php echo esc_html($block['application_title']); ?>
                                            </th>
                                            <th class="method-title">
                                                <strong><?php echo $block['method_title'] ?: 'Method of Application:'; ?></strong>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            <tr>
                                                <td class="application-desc">
                                                    <p class="t_heading"><p>
                                                    <p><?php echo $block['application_desc']; ?></p>
                                                </td>
                                                <td class="method-desc">
                                                    <p class="t_heading"><p>
                                                    <?php echo $block['method_desc']; ?>
                                                </td>
                                            </tr>
                                </tbody>
                            </table>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
    
</article><!-- #post-## -->