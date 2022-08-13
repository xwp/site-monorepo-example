const defaultConfig = require( '@wordpress/scripts/config/webpack.config' );

module.exports = {
  ...defaultConfig,
  devServer: {
    ...defaultConfig.devServer,
    headers: {
      'Access-Control-Allow-Origin': '*',
      'Access-Control-Allow-Credentials': 'true',
      'Access-Control-Allow-Methods': 'GET, POST, PUT, DELETE, OPTIONS',
    },
  },
};