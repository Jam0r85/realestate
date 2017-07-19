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

mix.js('resources/assets/js/app.js', 'public/js')
	.scripts([
		'node_modules/moment/min/moment-with-locales.min.js',
		'node_modules/fullcalendar/dist/fullcalendar.min.js',
		'node_modules/select2/dist/js/select2.min.js'
	], 'public/js/all.js')
	.sass('resources/assets/sass/app.scss', 'public/css')
	.styles([
		'node_modules/fullcalendar/dist/fullcalendar.min.css',
		'node_modules/select2/dist/css/select2.min.css'
	], 'public/css/all.css')
	.version();
