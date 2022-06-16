<?php
/**
 * WordPress configuration.
 *
 * phpcs:disable WordPress.WP.CapitalPDangit.Misspelled, WordPress.WP.GlobalVariablesOverride.Prohibited
 */

// Include the project-wide autoloader.
require_once __DIR__ . '/vendor/autoload.php';

define( 'WP_CONTENT_DIR', __DIR__ . '/wp-content' );

define( 'DB_NAME', getenv( 'WP_DB_NAME' ) );
define( 'DB_USER', getenv( 'WP_DB_USER' ) );
define( 'DB_PASSWORD', getenv( 'WP_DB_PASSWORD' ) );
define( 'DB_HOST', getenv( 'WP_DB_HOST' ) );

$table_prefix = 'wp_';

define( 'DB_CHARSET', 'utf8' );
define( 'DB_COLLATE', '' );

define( 'WP_DEBUG', getenv( 'WP_DEBUG' ) ? true : false );

require_once ABSPATH . 'wp-settings.php';