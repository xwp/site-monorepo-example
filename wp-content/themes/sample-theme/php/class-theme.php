<?php

namespace XWP\Sample_Theme;

class Theme {

    protected $dir;

    protected $dir_uri;

    public function __construct( $dir ) {
        $this->dir = rtrim( $dir, '\\/' );
        $this->dir_uri = rtrim( get_template_directory_uri(), '\\/' );
    }

    public function dir() {
        return $this->dir;
    }

    public function url_to( $path_relative = null ) {
        // Account for absolute paths to assets under the root directory.
        $path_relative = str_replace( $this->dir, '', $path_relative );

        if ( empty( $path_relative ) ) {
            return $this->dir_uri;
        }

        return sprintf(
            '%s/%s',
            $this->dir_uri,
            ltrim( $path_relative, '\\/' )
        );
    }

    public function path_to( $path_relative = null ) {
        // Account for absolute paths to assets under the root directory.
        $path_relative = str_replace( $this->dir, '', $path_relative );

        if ( empty( $path_relative ) ) {
            return $this->dir;
        }

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