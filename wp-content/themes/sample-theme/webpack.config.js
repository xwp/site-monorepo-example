const path = require( 'path' );
const { sync: glob } = require( 'fast-glob' );
const defaultConfig = require( '@wordpress/scripts/config/webpack.config.js' );

function filesToEntries( files ) {
    return Object.fromEntries(
        files.map( file => {
            const parsed = path.parse( file );
            return [ 
                path.join( parsed.dir, parsed.name ), 
                `./${ path.join( parsed.dir, parsed.base ) }` 
            ];
        } )
    );
}

const entryFiles = [
    // Theme.
    ...glob( 'js/*.js' ),
    
    // Blocks.
    ...glob( 'blocks/*/*.js' )
];

module.exports = {
    ...defaultConfig,
    entry: filesToEntries( entryFiles ),
    output: {
        path: path.resolve( __dirname, 'dist' ),
    },
}