const dotenvExpand = require('dotenv-expand');
dotenvExpand(require('dotenv').config({ path: '../../.env'/*, debug: true*/}));

const path = require('path');
const mix = require('laravel-mix');
// require('laravel-mix-merge-manifest');

// mix.setPublicPath('../../public').mergeManifest();
mix.webpackConfig({
    resolve: {
        alias: {
            '@base.marketplace': path.resolve('Modules/KamrulDashboard/resources/assets/js/marketplace'),
        }
    }
});

mix.js(__dirname + '/Resources/assets/js/tags.js', 'public/js/tags.js')
    .js(__dirname + '/Resources/assets/js/app.js', 'public/js/app.js')
    .js(__dirname + '/Resources/assets/js/dashboard.js', 'public/js/dashboard.js')
    .js(__dirname + '/Resources/assets/js/tree-category.js', 'public/js/tree-category.js')
    .sass(__dirname + '/Resources/assets/sass/tree-category.scss', 'public/css/tree-category.css')
    .sass(__dirname + '/Resources/assets/sass/custom/email.scss', 'public/css/email.css')
    .sass(__dirname + '/Resources/assets/sass/custom/error-pages.scss', 'public/css/error-pages.css')
    .sass(__dirname + '/Resources/assets/sass/setting.scss', 'public/css/setting.css')
    .sass(__dirname + '/Resources/assets/sass/dashboard.scss', 'public/css/dashboard.css');

mix.js(__dirname + '/Resources/assets/js/setting.js', 'public/js/setting.js')
    .js(__dirname + '/Resources/assets/js/form/phone-number-field.js', 'public/js/phone-number-field.js')
    .js(__dirname + '/Resources/assets/js/vue-app.js', 'public/js/vue-app.js').vue()
    .js(__dirname + '/Resources/assets/js/repeater-field.js', 'public/js/repeater-field.js').vue();

if (mix.inProduction()) {
    mix.version();
}
