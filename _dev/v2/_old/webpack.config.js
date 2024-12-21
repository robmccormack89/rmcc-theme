const TerserPlugin = require('terser-webpack-plugin');

module.exports = {

    name: 'uikit',
    mode: "production", // sets mode to miniied production output, the entry file and the path & filename to output file
  
    optimization: {
      minimize: true,
      minimizer: [new TerserPlugin({
        extractComments: false,
      })],
    },
  
  // remove file size warnings from webpack, sets new limit
  performance: {
    hints: false,
    maxEntrypointSize: 512000,
    maxAssetSize: 512000
  },

  entry: {
    uikit: './src/js/index.js',
  },
  output: {
    filename: '[name].js',
    path: __dirname + '/public/js',
  },
    
};