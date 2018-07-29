let mix = require('laravel-mix');

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
if (!mix.inProduction()) {
    mix
        .webpackConfig({
            devtool: 'source-map',
        })
        .sourceMaps();
} else {
    mix.version();
}

const vendor = [
    'jquery', 'bootstrap', 'axios', 'popper.js', 'turbolinks',
];

mix
    .sass('resources/assets/sass/app.scss', 'css/app.css')
    .js('resources/assets/js/app.js', 'js/app.js')
    .extract(vendor)
    .autoload({
        jquery: ['$', 'window.jQuery', 'jQuery', 'jquery'],
    });
