<?php

require __DIR__ . '/constants/api-constants.php';
require __DIR__ . '/constants/default-module-padding.php';
require __DIR__ . '/constants/performance-products.php';
require __DIR__ . '/constants/resource-library-constants.php';

define('ALLOWED_FORMAT_TAGS', '<b><i><em><bold><strong><sup><sub>');
define('FORMATTING_TAG_INSTRUCTIONS', esc_html('This field allows simple formatting using <strong>, <em>, <sup>, and <sub> html tags.'));

define('RESOURCE_POST_TYPES', ['agrifacts', 'robust-articles', 'agrisights', 'video-articles', 'app-rate-sheets', 'success-story', 'standard-articles', 'directions-for-use', 'spec-sheets', 'ghs-label', 'sds-pages', 'trures-insights', 'trures-trial-data']);
define('EPISODE_POST_TYPES', ['frontier-fields-eps', 'sherry-show-episodes']);