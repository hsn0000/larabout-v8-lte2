const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

require('laravel-mix-merge-manifest');

// mix.js('resources/js/app.js', 'public/js')
//     .sass('resources/css/app.scss', 'public/css', [
//         //
//     ]);

mix.js('resources/themes/js/app.js', 'public/themes/js/app.js')
    .sass('resources/themes/css/app.scss', 'public/themes/css/app.css')
    .sourceMaps()

mix.copy('node_modules/admin-lte/dist/img', 'public/themes/img');
