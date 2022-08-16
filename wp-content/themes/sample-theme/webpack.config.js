const path = require( 'path' );
const { sync: glob } = require( 'fast-glob' );
const defaultConfig = require( '@wordpress/scripts/config/webpack.config.js' );

function filesToEntries( files ) {
    return Object.fromEntries(
        files.map( file => {
            const parsed = path.parse( file );
            return [ 
                path.join( parsed.dir, parsed.name ), // Generate a directory-tree-like name to eject in matching directory.
                `./${ path.join( parsed.dir, parsed.base ) }` // Must be relative to the project root. 
            ];
        } )
    );
}

const entryFiles = [
    ...glob( 'js/*.js' ),
    ...glob( 'blocks/*/*.js' ),
];

module.exports = {
    ...defaultConfig,
    entry: filesToEntries( entryFiles ),
    output: {
        path: path.resolve( __dirname, 'dist' ),
    },
    optimization: {
        ...defaultConfig.optimization,
        runtimeChunk: 'single', // Include just one React Refresh runtime per https://github.com/pmmmwh/react-refresh-webpack-plugin/blob/main/docs/TROUBLESHOOTING.md#externalising-react
    }
}