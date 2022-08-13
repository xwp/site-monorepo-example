<?php

namespace XWP\Sample_Theme;

class Pattern {

	protected $name;

	protected $title;

	protected $content;

	public function __construct( $name, $title = null ) {
		$this->name = $name;

		if ( ! empty( $title ) ) {
			$this->set_title( $title );
		}
	}

	public function name() {
		return $this->name;
	}

	public function properties() {
		return [
			'title' => $this->title,
			'content' => $this->content,
		];
	}

	public function set_title( $title ) {
		$this->title = $title;
	}

	public function set_properties( $properties ) {
		if ( ! empty( $properties['title'] ) ) {
			$this->set_title( $properties['title'] );
		}

		if ( ! empty( $properties['content'] ) ) {
			$this->set_content( $properties['content'] );
		}
	}

	public function set_content( $content ) {
		$this->content = $content;
	}

	public function set_content_from_file( $path ) {
		if ( is_readable( $path ) ) {
			$this->set_content( file_get_contents( $path ) );
		}
	}
	
}