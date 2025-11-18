const dotenvExpand = require('dotenv-expand');
dotenvExpand(require('dotenv').config({ path: '../../.env'/*, debug: true*/}));

const mix = require('laravel-mix');
require('laravel-mix-merge-manifest');

// mix.setPublicPath('../../public').mergeManifest();

mix.js(__dirname + '/Resources/assets/js/simple-slider.js', 'public/js/simple-slider.js')
    .js(__dirname + '/Resources/assets/js/simple-slider-admin.js', 'public/js/simple-slider-admin.js')
    .sass( __dirname + '/Resources/assets/sass/simple-slider.scss', 'public/css/simple-slider.css');

if (mix.inProduction()) {
    mix.version();
}
