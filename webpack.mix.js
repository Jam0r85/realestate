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
	.copy('node_modules/fullcalendar/dist/fullcalendar.min.js', 'public/js/fullcalendar.js')
	.copy('node_modules/fullcalendar/dist/fullcalendar.min.css', 'public/css/fullcalendar.css')
	.copy('node_modules/trumbowyg/dist/trumbowyg.min.js', 'public/js/trumbowyg.js')
	.copy('node_modules/trumbowyg/dist/ui/trumbowyg.min.css', 'public/css/trumbowyg.css')
	.copy('node_modules/trumbowyg/dist/ui/icons.svg', 'public/css/trumbowyg/icons.svg')
	.version();
