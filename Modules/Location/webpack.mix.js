const dotenvExpand = require('dotenv-expand');
dotenvExpand(require('dotenv').config({ path: '../../.env'/*, debug: true*/}));

const mix = require('laravel-mix');
// require('laravel-mix-merge-manifest');

// mix.setPublicPath('../../public').mergeManifest();


mix.js(__dirname + '/Resources/assets/js/location.js', 'public/js/location.js');

if (mix.inProduction()) {
    mix.version();
}
