<?php

namespace XWP\Sample_Theme;

class Theme {

    const ASSET_PREFIX = 'xwp-sample-theme';

    protected $dir;

    public function __construct( $dir ) {
        $this->dir = rtrim( $dir, '\\/' );
    }

    public function basename() {
        return basename( $this->dir );
    }

    public function asset_id( $id ) {
        return sprintf( '%s-%s', self::ASSET_PREFIX, $id );
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

    public function init() {
        add_action( 'wp_enqueue_styles', array( $this, 'enqueue_scripts' ) );
    }

    public function enqueue_scripts() {
        wp_enqueue_style(
            $this->asset_id( 'style' ),
            $this->url_to( 'css/dist/style.css' )
        )
    }

}