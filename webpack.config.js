const webpack = require('webpack');

// Check for production flag
const PROD = process.argv.indexOf('-p') !== -1;

module.exports = {
  entry: './src/jsx/index.jsx',
  output: {
    filename: './web/assets/bundle.js',
    publicPath: 'http://localhost/assets'
  },
  module: {
    loaders: [
      {
        test: /\.jsx$/,
        loaders: ['jsx', 'babel'],
        exclude: /node_modules/

      },
      {
        test: /\.sass$/, loaders: ['style', 'css', 'sass'] 
      }
    ]
  },
  // Only enable minification and NODE_ENV modifications
  // when launched with -p
  plugins: PROD ? [
    new webpack.DefinePlugin({
      'process.env': {
        'NODE_ENV': JSON.stringify('production')
      }
    }),
    new webpack.optimize.UglifyJsPlugin({
      compress: { warnings: false }
    })
  ] : [],
  resolve: {
    extensions: ['', '.js', '.jsx']
  }
};