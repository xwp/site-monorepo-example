<?php

namespace XWP\Sample_Theme;

class Block_Script {

	protected $path;

	protected $filename;

	public function __construct( $path ) {
		$this->path = $path;
		$this->filename = pathinfo( $this->path, PATHINFO_FILENAME );
	}

	/**
	 * Account for how `wp-scripts` bundles and ejects all [S]CSS imports
	 * in entry JS files. 
	 *
	 * @return string
	 */
	public function style_css() {
		return sprintf( '%s/style-%s.css', dirname( $this->path ), $this->filename );
	}

	public function css() {
		return sprintf( '%s/%s.css', dirname( $this->path ), $this->filename );
	}

	public function js() {
		return $this->path;
	}
}