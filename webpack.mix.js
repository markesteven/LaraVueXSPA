let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

// Copy over the CoreUI Assets into separate coreui directories
var coreui_vendor = 'vendor/mrholek/CoreUI-Vue/Vue_Full_Project';

/*
mix.copyDirectory(coreui_vendor + '/static/img', 'public/static/img')
    .copyDirectory(coreui_vendor + '/scss', 'resources/coreui/scss')
    .copyDirectory(coreui_vendor + '/src', 'resources/coreui/src');
*/


mix.webpackConfig({
  module: {
    rules: [
      {
        test: /\.js$/,
        loader: 'babel-loader?cacheDirectory',
        include: [
          /vue2-datatable-component/ // <-- add this!
        ]
      }
    ]
  },
    node: {
      fs: "empty"
    },

});

mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css')
   .sass('resources/assets/sass/custom.scss', 'public/css');
