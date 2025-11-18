const dotenvExpand = require('dotenv-expand');
dotenvExpand(require('dotenv').config({ path: '../../.env'/*, debug: true*/}));

const mix = require('laravel-mix');
// require('laravel-mix-merge-manifest');
//
// mix.setPublicPath('../../public').mergeManifest();

mix.js(__dirname + '/Resources/assets/js/social-login.js', 'public/js/social-login.js')
    .sass( __dirname + '/Resources/assets/sass/social-login.scss', 'public/css/social-login.css');


if (mix.inProduction()) {
    mix.version();
}
