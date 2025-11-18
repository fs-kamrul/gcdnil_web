const dotenvExpand = require('dotenv-expand');
dotenvExpand(require('dotenv').config({ path: '../../.env'/*, debug: true*/}));

const mix = require('laravel-mix');
// require('laravel-mix-merge-manifest');

// mix.setPublicPath('../../public').mergeManifest();
//console.log(__dirname);
mix.js(__dirname + '/Resources/assets/js/menu.js', 'public/js/menus.js')
    .sass( __dirname + '/Resources/assets/sass/menu.scss', 'public/css/menus.css');

if (mix.inProduction()) {
    mix.version();
}
