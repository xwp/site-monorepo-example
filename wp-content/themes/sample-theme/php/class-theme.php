<?php

namespace XWP\Sample_Theme;

class Theme {

    protected $dir;

    public function __construct( $dir ) {
        $this->dir = rtrim( $dir, '\\/' );
    }

    public function url_to( $path_relative ) {
        return sprintf(
            '%s/%s',
            get_template_directory_uri(),
            ltrim( $path_relative, '\\/' )
        );
    }

    public function path_to( $path_relative ) {
        return sprintf(
            '%s/%s',
            $this->dir,
            ltrim( $path_relative, '\\/' )
        );
    }

    public function basename() {
        return basename( $this->dir );
    }

    public function asset_id( $id ) {
        return sprintf( '%s-%s', $this->basename(), $id );
    }

    public function init() {
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
    }

    public function enqueue_scripts() {
        $js_meta_file = $this->path_to( 'js/dist/index.asset.php' );

        if ( is_readable( $js_meta_file ) ) {
            $js_meta = file_get_contents( $js_meta_file );

            wp_enqueue_script(
                $this->asset_id( 'index' ),
                $this->url_to( 'js/dist/index.js' ),
                $js_meta['dependencies'],
                $js_meta['version'],
                true
            );

            wp_enqueue_style(
                $this->asset_id( 'style-index' ),
                $this->url_to( 'js/dist/style-index.css' ),
                array(),
                $js_meta['version']
            );
        }
    }

}