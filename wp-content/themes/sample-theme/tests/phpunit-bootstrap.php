<?php
/**
 * Bootstrap the WP test environment.
 *
 * @package XWP\Sample_Theme
 *
 * phpcs:disable WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
 */

// WP core test suite will make these the option values automatically.
global $wp_tests_options;
$test_theme_basename = basename( dirname( __DIR__ ) );
$wp_tests_options    = [
	'template'      => $test_theme_basename,
	'stylesheet'    => $test_theme_basename,
	'current_theme' => $test_theme_basename,
];

// Give access to tests_add_filter() function.
require_once getenv( 'WP_PHPUNIT__DIR' ) . '/includes/functions.php';

// Start up the WP testing environment.
require getenv( 'WP_PHPUNIT__DIR' ) . '/includes/bootstrap.php';