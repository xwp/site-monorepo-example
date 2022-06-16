<?php
/**
 * Environment tests.
 *
 * @package XWP\Sample_Theme
 */

use XWP\Sample_Theme\Theme;

/**
 * Test Theme.
 */
class Theme_Test extends WP_UnitTestCase {

    /**
     * Ensure that WP is loaded.
     */
    public function test_wordpress_and_plugin_are_loaded() {
        $this->assertTrue( function_exists( 'do_action' ) );
    }

    /**
     * Ensure the theme is loaded.
     *
     * @return void
     */
    public function test_theme_loaded() {
        $this->assertTrue( class_exists( 'XWP\Sample_Theme\Theme' ) );
    }

    /**
     * Can resolve asset paths and URLs relative to the theme root.
     *
     * @return void
     */
    public function test_asset_path_and_url_to() {
        $theme = new Theme( '/path/to/theme' );

        $this->assertEquals(
            '/path/to/theme/asset/style.js',
            $theme->path_to( 'asset/style.js' )
        );

        $this->assertEquals(
            sprintf( '%s/asset/style.js', get_stylesheet_directory_uri() ),
            $theme->url_to( 'asset/style.js' )
        );
    }
}