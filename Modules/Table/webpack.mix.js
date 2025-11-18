const dotenvExpand = require('dotenv-expand');
dotenvExpand(require('dotenv').config({ path: '../../.env'/*, debug: true*/}));

const mix = require('laravel-mix');
// require('laravel-mix-merge-manifest');
//
// mix.setPublicPath('../../public').mergeManifest();

mix
    .js(__dirname + '/Resources/assets/js/filter.js', 'public/js/filter.js')
    .js(__dirname + '/Resources/assets/js/table.js', 'public/js/table.js')
    .sass( __dirname + '/Resources/assets/sass/table.scss', 'public/css/table.css');

// js(__dirname + '/Resources/assets/js/app.js', 'js/table.js')
    // .sass( __dirname + '/Resources/assets/sass/app.scss', 'css/table.css');

if (mix.inProduction()) {
    mix.version();
}
