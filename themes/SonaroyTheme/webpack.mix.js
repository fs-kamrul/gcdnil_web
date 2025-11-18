let mix = require('laravel-mix');

const path = require('path');
let directory = path.basename(path.resolve(__dirname));

const source = 'themes/' + directory;
const dist = 'public/themes/' + directory;
console.log(source);
console.log(dist);
mix
    .js(__dirname + '/assets/js/script.js', 'public/js/script.js')
    .js(__dirname + '/assets/js/backend.js', 'public/js/backend.js');
    // .sass( __dirname + '/assets/sass/app.scss', 'public/css/sonaroytheme.css');

if (mix.inProduction()) {
    mix.version();
}
