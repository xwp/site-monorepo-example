<?php

namespace XWP\Sample_Theme;

class App {

    protected $theme;

    protected $blocks = [];

    public function __construct( Theme $theme ) {
        $this->theme = $theme;
    }

    public function init() {
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_theme_assets' ) );
        add_action( 'enqueue_block_assets', array( $this, 'enqueue_block_assets' ) );
        add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_block_editor_assets' ) );
        add_action( 'init', [ $this, 'init_blocks' ] );
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

    public function init_blocks() {
        foreach ( glob( $this->theme->path_to( 'blocks/src/*/block.php' ) ) as $block_file ) {
            if ( is_readable( $block_file ) ) {
                $block = include $block_file;
                $block->register();

                $this->blocks[] = $block;
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

            if ( ! empty( $assets['style'] ) ) {
                wp_enqueue_style(
                    $block->handle_for_context( 'style' ),
                    $this->theme->url_to( $this->block_path_to_dist( $assets['style'] ) )
                );
            }
        }
    }

    public function enqueue_block_editor_assets() {
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