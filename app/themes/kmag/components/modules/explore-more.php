<?php
/**
 * ACF Module: Explore More
 *
 * @global $data
 */

use CN\App\Fields\ACF;
use CN\App\Fields\Util;
use CN\App\Media;

$explore_more_links = ACF::getRowsLayout('explore-more-links', $data);
$eyebrow = ACF::getField('eyebrow', $data);
$hide_on_desktop = ACF::getField('hide-desktop', $data, false);
$hide_on_desktop_class = $hide_on_desktop ? 'explore-more--hide-desktop' : '';

$header_image_id = ACF::getField('header-image', $data);
$header_image_attachment = Media::getAttachmentByID($header_image_id, 'full');
$header_image_src = $header_image_attachment ?  $header_image_attachment->url : null;
$header_image_alt = ! empty($header_image_attachment->alt) ? esc_attr($header_image_attachment->alt) : esc_attr($header_image_attachment->title);
$header_image_styles =  'background-image: url(' . esc_html($header_image_src) . ');';

$mobile_header_image_id = ACF::getField('mobile-header-image', $data);
$mobile_header_image_attachment = Media::getAttachmentByID($mobile_header_image_id, 'full');
$mobile_header_image_src = $mobile_header_image_attachment ? $mobile_header_image_attachment->url : null;
$mobile_header_image_alt = ! empty($mobile_header_image_attachment->alt) ? esc_attr($mobile_header_image_attachment->alt) : esc_attr($mobile_header_image_attachment->title);
$mobile_header_image_styles =  'background-image: url(' . esc_html($header_image_src) . ');';

$link_type = ACF::getField('link-type', $data);

$header_image_link = null;

if ($link_type === 'internal') {
  $header_image_link = ACF::getField('header-image-link-internal', $data)['url'];
} else {
  $header_image_link = ACF::getField('header-image-link-external', $data);
}

if (!$explore_more_links) {
  return;
}

do_action('cn/modules/styles', $row_id, $data);

?>

<div class="module explore-more <?php echo esc_attr($hide_on_desktop_class); ?>" id="<?php echo esc_attr($row_id); ?>">
  <div class="explore-more__header">
    <?php if ($eyebrow) { ?>
      <h3 class="explore-more__eyebrow"><?php echo esc_html($eyebrow); ?></h3>
    <?php } ?>
    <?php if ($mobile_header_image_id && $header_image_link) { ?>
      <a
        href="<?php echo esc_url($header_image_link); ?>"
        role="image"
        class="explore-more__header-image explore-more__header-image--mobile"
        aria-label="<?php echo esc_attr($mobile_header_image_alt); ?>"
        style="<?php echo $mobile_header_image_styles; ?>"
      >
      </a>
    <?php } ?>
    <?php if ($header_image_id && $header_image_link) { ?>
      <a
        href="<?php echo esc_url($header_image_link); ?>"
        role="image"
        class="explore-more__header-image explore-more__header-image--desktop"
        aria-label="<?php echo esc_attr($header_image_alt); ?>"
        style="<?php echo $header_image_styles; ?>"
      >
      </a>
    <?php } ?>
  </div>
  <div class="explore-more__link-container">
    <?php foreach ($explore_more_links as $link) {
      $preview_image_id = ACF::getField('preview-image', $link);
      $preview_image_attachment = Media::getAttachmentByID($preview_image_id, 'full');
      $preview_image_src = $preview_image_attachment ? ACF::getField('full', $preview_image_attachment->sizes, $preview_image_attachment->url) : null;
      $preview_image_alt = ! empty($preview_image_attachment->alt) ? esc_attr($preview_image_attachment->alt) : esc_attr($preview_image_attachment->title);
      $title = ACF::getField('title', $link);
      $the_link = null;
      if ($link_type === 'internal') {
        $the_link = ACF::getField('internal-link', $link)['url'];
        
      } else {
        $the_link = ACF::getField('external-link', $link);
      }
      ?>
      <a href="<?php echo esc_url($the_link); ?>" class="explore-more__link">
        <div class="explore-more__link-preview-image" style="background-image: url(<?php echo esc_html($preview_image_src); ?>);" aria-label="<?php echo esc_attr($preview_image_alt); ?>"></div>
        <h4 class="explore-more__link-title"><?php echo esc_html($title); ?></h4>
      </a>
    <?php } ?>
  </div>

  <div class="explore-more__sticky-cta uk-hidden@m">
    <button>
      <?php _e('Explore More', 'kmag'); 
      echo Util::getIconHTML('arrow-bar'); ?>
    </button>
  </div>
</div>
