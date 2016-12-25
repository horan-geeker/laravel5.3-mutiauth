const elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function (mix) {
	mix.sass([
		'admin/app.scss',
		'vendor/global/components.scss',
		'vendor/global/plugins.scss',
		'vendor/layouts/layout/layout.scss',
		'vendor/layouts/layout/themes/default.scss',
		'vendor/layouts/layout/themes/darkblue.scss',
		'vendor/layouts/layout/custom.scss',
	], 'public/assets/css/admin/app.css')

		.scripts([
			'vendor/jquery.min.js',
			'vendor/bootstrap.min.js',
		], 'public/assets/js/admin/app.js')

		.version([
			'assets/css/admin/app.css',
			'assets/js/admin/app.js',
		]);
});
