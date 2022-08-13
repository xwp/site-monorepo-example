<?php

namespace XWP\Sample_Theme\Patterns;

use XWP\Sample_Theme\Pattern;

$pattern = new Pattern( 'call-to-action' );
$pattern->set_title( __( 'Call to Action', 'xwp-sample-theme' ) );
$pattern->set_content_from_file( __DIR__ . '/call-to-action.html' );

return $pattern;