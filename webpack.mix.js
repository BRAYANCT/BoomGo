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

// mix.js('resources/js/app.js', 'public/js')
//     .sass('resources/sass/app.scss', 'public/css');

//Para el administrador
mix.js('resources/js/admin.js', 'public/js')
   .sass('resources/sass/admin.scss', 'public/css');


//Para la web publica
mix.js('resources/js/web.js', 'public/js')
   .sass('resources/sass/web.scss', 'public/css');


//ckeditor 5
// mix.js('public/plugins/ckeditor5/build/ckeditor.js', 'public/js');


//date picker
// mix.styles('node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css','public/css/bootstrap-datepicker.css');


// Select2 solo se usa el css
// mix.styles([
//     'node_modules/select2/dist/css/select2.css',
//     'node_modules/@ttskch/select2-bootstrap4-theme/dist/select2-bootstrap4.css',
// ], 'public/css/select2.css');


// Data tables solo se usa el css
// mix.styles([
//     'node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css',
//     'node_modules/datatables.net-responsive-bs4/css/responsive.bootstrap4.css',
//     'public/plugins/datatables/css/custom.css'
// ], 'public/css/datatables.css');


// se importa el css del bootstrap-fileinput
// mix.styles([
//     'node_modules/bootstrap-fileinput/css/fileinput.css',
// ], 'public/css/bootstrap-fileinput.css');



if (mix.inProduction()) {
    mix.version();
}

// mix.options({
//     processCssUrls: false
// })

