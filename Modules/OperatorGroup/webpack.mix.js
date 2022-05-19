const dotenvExpand = require('dotenv-expand');
dotenvExpand(require('dotenv').config({ path: '../../.env'/*, debug: true*/}));

const mix = require('laravel-mix');
require('laravel-mix-merge-manifest');

mix.js(__dirname + '/Resources/assets/js/app.js', '/module/js/operatorgroup.js')
    .sass( __dirname + '/Resources/assets/sass/app.scss', '/module/css/operatorgroup.css');

if (mix.inProduction()) {
    mix.version();
}
