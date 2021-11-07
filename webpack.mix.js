const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix .options({
        processCssUrls: false,
    })
    .sourceMaps()
    .js('resources/js/app.js', 'public/js')
    .scripts([
        'node_modules/datatables.net/js/jquery.dataTables.js',
        'node_modules/datatables.net-bs5/js/dataTables.bootstrap5.js'
    ], 'public/js/datatable.js')
    .styles(['node_modules/datatables.net-bs5/css/dataTables.bootstrap5.css'], 'public/css/datatable.css')
    .sass('resources/sass/app.scss', 'public/css')
