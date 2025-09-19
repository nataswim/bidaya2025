const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
   .sass('resources/scss/app.scss', 'public/css', {
       implementation: require('sass')
   })
   .options({
       processCssUrls: false
   })
.copyDirectory('node_modules/@fortawesome/fontawesome-free/webfonts', 'public/webfonts');

if (mix.inProduction()) {
    mix.version();
}