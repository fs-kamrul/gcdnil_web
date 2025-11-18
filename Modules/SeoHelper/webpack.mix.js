const dotenvExpand = require('dotenv-expand');
dotenvExpand(require('dotenv').config({ path: '../../.env'/*, debug: true*/}));

const mix = require('laravel-mix');
// require('laravel-mix-merge-manifest');

// mix.setPublicPath('../../public').mergeManifest();

mix.js(__dirname + '/Resources/assets/js/seo-helper.js', 'public/js/seo-helper.js')
    .sass( __dirname + '/Resources/assets/sass/seo-helper.scss', 'public/css/seo-helper.css')

if (mix.inProduction()) {
    mix.version();
}
