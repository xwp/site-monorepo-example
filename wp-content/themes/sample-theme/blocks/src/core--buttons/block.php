<?php

namespace XWP\Sample_Theme\Blocks;

use XWP\Sample_Theme\Block;
use XWP\Sample_Theme\Block_Script;
use XWP\Sample_Theme\Block_Variation;

$block = new Block( 'xwp-sample-theme/buttons' );

$block->extends( 'core/buttons' );

$index_script = new Block_Script( __DIR__ . '/script.js' );
$block->add_asset( 'script', $index_script->script() );
$block->add_asset( 'style', $index_script->style() );

$editor_script = new Block_Script( __DIR__ . '/editor.js' );
$block->add_asset( 'editorScript', $editor_script->editor_script() );
$block->add_asset( 'editorStyle', $editor_script->editor_style() );

$block->add_variation(
    new Block_Variation( 'secondary', __( 'Secondary' ) )
);

return $block;
