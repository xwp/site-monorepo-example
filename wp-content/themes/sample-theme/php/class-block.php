<?php

namespace XWP\Sample_Theme;

class Block {

	protected $id;

	protected $extends_id;

	protected $styles = [];

	protected $assets = [
		'script' => null,
		'editorScript' => null,
		'viewScript' => null,
		'style' => null,
		'editorStyle' => null,
	];

	public function __construct( $id, $extends_id = null ) {
		$this->id = $id;

		if ( isset( $extends_id ) ) {
			$this->extends( $extends_id );
		}
	}

	public function extends( $extends ) {
		$this->extends_id = $extends;
	}

	public function handle_for_context( $context ) {
		return generate_block_asset_handle( $this->id, $context );
	}

	public function add_variation( Block_Variation $variation ) {
		$this->variations[] = $variation;
	}

	public function add_asset( $context, $asset_path, $handle = null ) {
		if ( array_key_exists( $context, $this->assets ) ) {
			$this->assets[ $context ] = $asset_path;
		}
	}

	public function assets() {
		return $this->assets;
	}

	public function register() {
		foreach ( $this->variations as $variation ) {
			register_block_style(
				$this->extends_id ? $this->extends_id : $this->id,
				$variation->properties()
			);
		}
	}
}