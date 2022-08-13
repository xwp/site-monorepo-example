<?php

namespace XWP\Sample_Theme;

class Block {

	protected $id;

	protected $extends_id;

	protected $variations = [];

	protected $variations_disabled = [];

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

	public function assets() {
		return $this->assets;
	}

	public function handle_for_context( $context ) {
		return generate_block_asset_handle( $this->id, $context );
	}

	/**
	 * Register a block style/variation.
	 *
	 * @param array $variation Variation arguments, see register_block_style().
	 * 
	 * @return void
	 */
	public function add_variation( $variation ) {
		$this->variations[] = $variation;
	}

	/**
	 * Disable a block variation.
	 * 
	 * Note that styles/variations added via JS must be removed via JS, too!
	 *
	 * @param string|array $variation Variation ID or a list of them.
	 * 
	 * @return void
	 */
	public function remove_variation( $variation ) {
		if ( is_array( $variation ) ) {
			$this->variations_disabled = array_merge( $this->variations_disabled, $variation );
		} else {
			$this->variations_disabled[] = $variation;
		}
	}

	public function add_asset( $context, $asset_path, $handle = null ) {
		if ( array_key_exists( $context, $this->assets ) ) {
			$this->assets[ $context ] = $asset_path;
		}
	}

	public function register() {
		$block_name = $this->extends_id ? $this->extends_id : $this->id;

		foreach ( $this->variations_disabled as $variation_id ) {
			unregister_block_style( $block_name, $variation_id );
		}

		foreach ( $this->variations as $variation ) {
			register_block_style( $block_name, $variation );
		}
	}
}