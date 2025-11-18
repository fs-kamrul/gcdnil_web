const dotenvExpand = require('dotenv-expand');
dotenvExpand(require('dotenv').config({ path: '../../.env'/*, debug: true*/}));

const mix = require('laravel-mix');
require('laravel-mix-merge-manifest');

// mix.setPublicPath('../../public').mergeManifest();

mix.js(__dirname + '/Resources/assets/js/contact.js', 'public/js/contact.js')
    .js(__dirname + '/Resources/assets/js/contact-public.js', 'public/js/contact-public.js')
    .sass(__dirname + '/Resources/assets/sass/contact.scss', 'public/css/contact.css')
    .sass(__dirname + '/Resources/assets/sass/contact-public.scss', 'public/css/contact-public.css');

if (mix.inProduction()) {
    mix.version();
}
