const dotenvExpand = require('dotenv-expand');
dotenvExpand(require('dotenv').config({ path: '../../.env'/*, debug: true*/}));

const mix = require('laravel-mix');
// require('laravel-mix-merge-manifest');

// mix.setPublicPath('../../public').mergeManifest();
//console.log(__dirname);
mix.js(__dirname + '/Resources/assets/js/faq.js', 'public/js/faq.js')
    .js(__dirname + '/Resources/assets/js/curriculum.js', 'public/js/curriculum.js')
    .sass( __dirname + '/Resources/assets/sass/faq.scss', 'public/css/faq.css');

if (mix.inProduction()) {
    mix.version();
}
