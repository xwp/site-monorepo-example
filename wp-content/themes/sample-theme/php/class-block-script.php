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
	public function style() {
		return sprintf( '%s/style-%s.css', dirname( $this->path ), $this->filename );
	}

	public function editor_style() {
		return sprintf( '%s/%s.css', dirname( $this->path ), $this->filename );
	}

	public function script() {
		return $this->path;
	}

	public function editor_script() {
		return $this->path;
	}

	public function view_script() {
		return $this->path;
	}
}