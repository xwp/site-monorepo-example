<?php

namespace XWP\Sample_Theme\Blocks;

use XWP\Sample_Theme\Block;
use XWP\Sample_Theme\Block_Script;

$block = new Block( 'xwp-sample-theme/button' );

$block->extends( 'core/button' );

$index_script = new Block_Script( __DIR__ . '/script.js' );
$block->add_asset( 'script', $index_script->script() );
$block->add_asset( 'style', $index_script->style() );

$editor_script = new Block_Script( __DIR__ . '/editor.js' );
$block->add_asset( 'editorScript', $editor_script->editor_script() );
$block->add_asset( 'editorStyle', $editor_script->editor_style() );

$block->remove_variation( 'fill' );

// The CSS styles for this are added to the block style.
$block->add_variation(
    [
        'name' => 'secondary',
        'label' => __( 'Secondary' ),
        'is_default' => true, 
    ]
);

return $block;
