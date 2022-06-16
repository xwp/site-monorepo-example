<?php

namespace XWP\Sample_Theme;

// Include the local autoloader only if the global one isn't available.
if ( ! class_exists( Theme::class ) && file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
    require_once __DIR__ . '/vendor/autoload.php';
}

$theme = new Theme( __DIR__ );
$theme->init();
