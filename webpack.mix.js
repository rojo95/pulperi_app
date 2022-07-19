const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .js('node_modules/sweetalert2/src/sweetalert2.js', 'public/js')
    .js('node_modules/@fortawesome/fontawesome-free/js/fontawesome.js','public/js')
    .js('node_modules/@fortawesome/fontawesome-free/js/solid.js','public/js')
    .js('node_modules/@fortawesome/fontawesome-free/js/brands.js','public/js')
    .js('node_modules/bootstrap-select/dist/js/bootstrap-select.js','public/js')
    .js('node_modules/chart.js/dist/chart.min.js','public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/bootstrap.scss', 'public/css')
    .postCss('resources/css/app.css', 'public/css')
    .sourceMaps();
