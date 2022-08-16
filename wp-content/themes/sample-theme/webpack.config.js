const path = require( 'path' );
const defaultConfig = require( '@wordpress/scripts/config/webpack.config.js' );

const entries = {
    'js/index': './js/index.js',
    'js/editor': './js/editor.js',
    
    // Blocks
    'blocks/core--button/editor': './blocks/core--button/editor.js',
    'blocks/core--button/script': './blocks/core--button/script.js'
};

module.exports = {
    ...defaultConfig,
    entry: entries,
    output: {
        path: path.resolve( __dirname, 'dist' ),
    },
}