<?php
/**
 * WordPress configuration.
 *
 * phpcs:disable WordPress.WP.CapitalPDangit.Misspelled, WordPress.WP.GlobalVariablesOverride.Prohibited
 */

// Include the project-wide autoloader.
require_once __DIR__ . '/vendor/autoload.php';

define( 'WP_CONTENT_DIR', __DIR__ . '/wp-content' );

if ( ! empty( $_SERVER['HTTPS'] ) && 'on' === $_SERVER['HTTPS'] ) {
	define( 'WP_CONTENT_URL', sprintf( 'https://%s/wp-content', $_SERVER['SERVER_NAME'] ) );
} else {
	define( 'WP_CONTENT_URL', sprintf( 'http://%s/wp-content', $_SERVER['SERVER_NAME'] ) );
}

define( 'DB_NAME', getenv( 'WP_DB_NAME' ) );
define( 'DB_USER', getenv( 'WP_DB_USER' ) );
define( 'DB_PASSWORD', getenv( 'WP_DB_PASSWORD' ) );
define( 'DB_HOST', getenv( 'WP_DB_HOST' ) );

define( 'SCRIPT_DEBUG', true );
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_DISPLAY', true );

$table_prefix = 'wp_';

define( 'DB_CHARSET', 'utf8' );
define( 'DB_COLLATE', '' );

define( 'WP_DEBUG', getenv( 'WP_DEBUG' ) ? true : false );

require_once ABSPATH . 'wp-settings.php';