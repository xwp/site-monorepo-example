<?php

namespace XWP\Sample_Theme;

class App {

    protected $theme;

    protected $blocks = [];

    public function __construct( Theme $theme ) {
        $this->theme = $theme;
    }

    public function init() {
        add_action( 'init', [ $this, 'init_blocks' ] );
        add_action( 'init', [ $this, 'init_patterns' ] );
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_theme_assets' ) );
        add_action( 'enqueue_block_assets', array( $this, 'enqueue_block_assets' ) );
        add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_block_editor_assets' ) );
        add_action( 'after_setup_theme', [ $this, 'after_setup_theme' ] );
        add_filter( 'wp_should_load_separate_core_block_assets', '__return_true' );
    }

    public function after_setup_theme() {
        add_theme_support( 'editor-styles' );
        add_theme_support( 'wp-block-styles' );
    }

    public function enqueue_theme_assets() {
        $js_meta_file = $this->theme->path_to( 'js/dist/index.asset.php' );

        if ( is_readable( $js_meta_file ) ) {
            $js_meta = require $js_meta_file;

            wp_enqueue_script(
                $this->theme->asset_id( 'index' ),
                $this->theme->url_to( 'js/dist/index.js' ),
                $js_meta['dependencies'],
                $js_meta['version'],
                true
            );

            wp_enqueue_style(
                $this->theme->asset_id( 'style-index' ),
                $this->theme->url_to( 'js/dist/style-index.css' ),
                array(),
                $js_meta['version']
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

    public function init_blocks() {
        foreach ( glob( $this->theme->path_to( 'blocks/src/*/block.php' ) ) as $block_file ) {
            $block = $this->require_object_from_file( $block_file );
            
            if ( $block instanceof Block ) {
                $this->blocks[] = $block;
                $block->register();
            }
        }
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

    protected function block_path_to_dist( $path ) {
        return str_replace( '/blocks/src/', '/blocks/dist/', $path );
    }

    protected function block_asset_php( $path, $deps = [] ) {
        $asset_php_path = str_replace( '.js', '.asset.php', $path );
        $asset_php_path = $this->block_path_to_dist( $asset_php_path );

        $meta = [
            'dependencies' => $deps,
            'version' => filemtime( $path ),
        ];

        if ( is_readable( $asset_php_path ) ) {
            $asset_php_meta = require $asset_php_path;
            
            $meta['dependencies'] = array_merge( $meta['dependencies'], $asset_php_meta['dependencies'] );
            $meta['version'] = $asset_php_meta['version'];
        }
        
        return $meta;
    }

    public function enqueue_block_assets() {
        foreach ( $this->blocks as $block ) {
            $assets = $block->assets();

            if ( ! empty( $assets['script'] ) ) {
                $asset_meta = $this->block_asset_php( $assets['script'] );

                wp_enqueue_script(
                    $block->handle_for_context( 'script' ),
                    $this->theme->url_to( $this->block_path_to_dist( $assets['script'] ) ),
                    $asset_meta['dependencies'],
                    $asset_meta['version'],
                    true
                );
            }

            if ( ! empty( $assets['viewScript'] ) ) {
                $asset_meta = $this->block_asset_php( $assets['viewScript'] );

                wp_enqueue_script(
                    $block->handle_for_context( 'viewScript' ),
                    $this->theme->url_to( $this->block_path_to_dist( $assets['viewScript'] ) ),
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
            $this->theme->url_to( 'js/dist/editor.css' )
        );

        // Block-specific styles.
        foreach ( $this->blocks as $block ) {
            $assets = $block->assets();

            if ( ! empty( $assets['editorScript'] ) ) {
                $asset_meta = $this->block_asset_php( $assets['editorScript'] );

                wp_enqueue_script(
                    $block->handle_for_context( 'editorScript' ),
                    $this->theme->url_to( $this->block_path_to_dist( $assets['editorScript'] ) ),
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