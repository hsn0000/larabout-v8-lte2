const dotenvExpand = require('dotenv-expand');
dotenvExpand(require('dotenv').config({ path: '../../.env'/*, debug: true*/}));

const mix = require('laravel-mix');
require('laravel-mix-merge-manifest');

// mix.setPublicPath('../../public').mergeManifest();

mix.js(__dirname + '/Resources/assets/js/app.js', '/module/js/home.js');
mix.sass( __dirname + '/Resources/assets/sass/app.scss', '/module/css/home.css');

if (mix.inProduction()) {
    mix.version();
}
