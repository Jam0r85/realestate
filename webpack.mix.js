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

mix.js('resources/assets/js/app.js', 'public/js')
	.scripts([
		'public/fontawesome/js/packs/regular.js',
		'public/fontawesome/js/packs/solid.js',
		'public/fontawesome/js/fontawesome.js'
		], 'public/js/fontawesome.js')
	.sass('resources/assets/sass/app.scss', 'public/css')
	.styles([
		'node_modules/fullcalendar/dist/fullcalendar.min.css',
		'node_modules/select2/dist/css/select2.min.css'
	], 'public/css/all.css');

if (mix.inProduction()) {
	mix.version();
}
