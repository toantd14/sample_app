const mix = require('laravel-mix');

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
require('laravel-mix-merge-manifest');
mix.mergeManifest();

mix.js('resources/js/app.js', 'public/js')
    .js(__dirname + '/resources/js/common-parking-menu.js', 'js/common/common-parking-menu.js')
    .js(__dirname + '/resources/js/common-validate-menu.js', 'js/common/common-validate-menu.js')
    .js(__dirname + '/resources/js/common-parking-time-picker.js', 'js/common/common-parking-time-picker.js')
    .js(__dirname + '/resources/js/validate-tel-no.js', 'js/common/common-validate-tel-no.js')
    .js(__dirname + '/resources/js/common-image-video-upload.js', 'js/common/common-image-video-upload.js')
    .sass('resources/sass/app.scss', 'public/css');
