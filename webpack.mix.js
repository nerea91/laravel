const { mix } = require('laravel-mix');

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

mix.sass('resources/assets/sass/master.scss', 'public/css')
 .js('resources/assets/js/master.js', 'public/js')
 .sass('resources/assets/sass/admin.scss', 'public/css')
 .js('resources/assets/js/admin.js', 'public/js')
 .scripts(['public/js/admin.js', 'resources/assets/js/app.js'], 'public/js/admin.js')
 .copy('resources/assets/sass/responsive-tables.css', 'public/css')
 .js('resources/assets/js/responsive-tables.js', 'public/js')
 .js('node_modules/foundation-datepicker/js/foundation-datepicker.js', 'public/js')
 .js('node_modules/foundation-datepicker/js/locales/foundation-datepicker.es.js', 'public/js')
 .copy('resources/assets/sass/datepicker.css', 'public/css');
