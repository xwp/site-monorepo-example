<?php

namespace XWP\Sample_Theme;

class App {

    const SCRIPT_HANDLE_REFRESH_RUNTIME = 'react-refresh-runtime';

    protected $theme;

    protected $blocks = [];

    public function __construct( Theme $theme ) {
        $this->theme = $theme;
    }

    public function init() {
        add_action( 'init', [ $this, 'init_blocks' ] );
        add_action( 'init', [ $this, 'init_patterns' ] );
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_global_scripts' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_theme_scripts' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_global_scripts' ) );
        add_action( 'enqueue_block_assets', array( $this, 'enqueue_block_assets' ) );
        add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_block_editor_assets' ) );
        add_action( 'after_setup_theme', [ $this, 'after_setup_theme' ] );
        add_filter( 'wp_should_load_separate_core_block_assets', '__return_true' );
    }

    public function after_setup_theme() {
        add_theme_support( 'editor-styles' );
        add_theme_support( 'wp-block-styles' );
    }

    public function enqueue_global_scripts() {
        // Enqueue only during development for "hot" reloading.
        if ( is_readable( $this->theme->path_to( 'dist/runtime.js' ) ) ) {
            wp_register_script(
                $this->theme->asset_id( self::SCRIPT_HANDLE_REFRESH_RUNTIME ),
                $this->theme->url_to( 'dist/runtime.js' ),
            );
        }
    }

    public function enqueue_theme_scripts() {
        $index_js_meta = $this->asset_php( 'dist/js/index.js' );

        if ( ! empty( $index_js_meta['url'] ) ) {
            wp_enqueue_script(
                $this->theme->asset_id( 'index' ),
                $index_js_meta['url'],
                $index_js_meta['dependencies'],
                $index_js_meta['version'],
                true
            );

            wp_enqueue_style(
                $this->theme->asset_id( 'style-index' ),
                $this->theme->url_to( 'dist/js/style-index.css' ),
                array(),
                $index_js_meta['version']
            );
        }
    }

    protected function require_object_from_file( $path ) {
        if ( is_readable( $path ) ) {
            ob_start();
            $object = require $path;
            ob_end_clean();

            return $object;
        }

        return null;
    }

    public function init_patterns() {
        foreach ( glob( $this->theme->path_to( 'patterns/*/pattern.php' ) ) as $pattern_file ) {
            $pattern = $this->require_object_from_file( $pattern_file );

            if ( $pattern instanceof Pattern ) {
                $this->patterns[] = $pattern;
                
                register_block_pattern(
                    sprintf( 'xwp-sample-theme-pattern/%s', $pattern->name() ),
                    $pattern->properties()
                );
            }
        }
    }

    public function init_blocks() {
        foreach ( glob( $this->theme->path_to( 'blocks/*/block.php' ) ) as $block_file ) {
            $block = $this->require_object_from_file( $block_file );
            
            if ( $block instanceof Block ) {
                $this->blocks[] = $block;
                $block->register();
            }
        }
    }

    protected function asset_php( $path ) {
        // Support paths relative to the theme root directory.
        if ( 0 !== strpos( $path, $this->theme->dir() ) ) {
            $path = $this->theme->path_to( $path );
        }

        // Map to the PHP meta file name.
        $asset_php_path = str_replace( '.js', '.asset.php', $path );

        if ( ! is_readable( $asset_php_path ) ) {
            return false;
        }

        $meta = [
            'dependencies' => [],
            'version' => filemtime( $path ),
            'url' => $this->theme->url_to( $path ),
        ];

        if ( is_readable( $asset_php_path ) ) {
            $asset_php_meta = require $asset_php_path;
            
            $meta['dependencies'] = array_merge( $meta['dependencies'], $asset_php_meta['dependencies'] );
            $meta['version'] = $asset_php_meta['version'];
        }

        // Enqueue the React refresh runtime for "hot" reloading.
        if ( in_array( 'wp-react-refresh-runtime', $meta['dependencies'], true ) ) {
            $meta['dependencies'][] = $this->theme->asset_id( self::SCRIPT_HANDLE_REFRESH_RUNTIME );
        }
        
        return $meta;
    }

    protected function block_path_to_dist( $path ) {
        return str_replace( $this->theme->dir(), $this->theme->path_to( 'dist' ), $path );
    }

    public function enqueue_block_assets() {
        foreach ( $this->blocks as $block ) {
            $assets = $block->assets();

            if ( ! empty( $assets['script'] ) ) {
                $asset_meta = $this->asset_php( $this->block_path_to_dist( $assets['script'] ) );

                wp_enqueue_script(
                    $block->handle_for_context( 'script' ),
                    $asset_meta['url'],
                    $asset_meta['dependencies'],
                    $asset_meta['version'],
                    true
                );
            }

            if ( ! empty( $assets['viewScript'] ) ) {
                $asset_meta = $this->asset_php( $this->block_path_to_dist( $assets['viewScript'] ) );

                wp_enqueue_script(
                    $block->handle_for_context( 'viewScript' ),
                    $asset_meta['url'],
                    $asset_meta['dependencies'],
                    $asset_meta['version'],
                    true
                );
            }

            if ( ! empty( $assets['style'] ) ) {
                wp_enqueue_style(
                    $block->handle_for_context( 'style' ),
                    $this->theme->url_to( $this->block_path_to_dist( $assets['style'] ) )
                );
            }
        }
    }

    public function enqueue_block_editor_assets() {
        // Global editor styles.
        wp_enqueue_style(
            $this->theme->asset_id( 'editor' ),
            $this->theme->url_to( 'dist/js/editor.css' )
        );

        // Block-specific styles.
        foreach ( $this->blocks as $block ) {
            $assets = $block->assets();

            if ( ! empty( $assets['editorScript'] ) ) {
                $asset_meta = $this->asset_php( $this->block_path_to_dist( $assets['editorScript'] ) );

                wp_enqueue_script(
                    $block->handle_for_context( 'editorScript' ),
                    $asset_meta['url'],
                    $asset_meta['dependencies'],
                    $asset_meta['version'],
                    true
                );
            }

            if ( ! empty( $assets['editorStyle'] ) ) {
                wp_enqueue_style(
                    $block->handle_for_context( 'editorStyle' ),
                    $this->theme->url_to( $this->block_path_to_dist( $assets['editorStyle'] ) )
                );
            }
        }
    }

}