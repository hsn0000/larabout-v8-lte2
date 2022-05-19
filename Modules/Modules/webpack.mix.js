const dotenvExpand = require('dotenv-expand');
dotenvExpand(require('dotenv').config({ path: '../../.env'/*, debug: true*/}));

const mix = require('laravel-mix');
require('laravel-mix-merge-manifest');

mix.js(__dirname + '/Resources/assets/js/app.js', '/module/js/modules.js')
    .sass( __dirname + '/Resources/assets/sass/app.scss', '/module/css/modules.css');

if (mix.inProduction()) {
    mix.version();
}
