<?php

namespace XWP\Sample_Theme;

class Theme {

    protected $dir;

    public function __construct( $dir ) {
        $this->dir = rtrim( $dir, '\\/' );
    }

    public function url_to( $path_relative ) {
        // Account for absolute paths to assets under the root directory.
        $path_relative = str_replace( $this->dir, '', $path_relative );

        return sprintf(
            '%s/%s',
            get_template_directory_uri(),
            ltrim( $path_relative, '\\/' )
        );
    }

    public function path_to( $path_relative ) {
        // Account for absolute paths to assets under the root directory.
        $path_relative = str_replace( $this->dir, '', $path_relative );

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

}