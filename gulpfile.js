const elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');

require('laravel-elixir-compress');

require('laravel-elixir-livereload');
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
	mix
		.copy([
			'node_modules/bootstrap-sass/assets/fonts/bootstrap'
		], 'public/build/assets/fonts')

		.copy([
			'node_modules/font-awesome/fonts'
		], 'public/build/assets/fonts')

		.copy([
			'node_modules/simple-line-icons/fonts'
		], 'public/build/assets/fonts')

		.sass([
			'admin/app.scss',
			'vendor/global/components.scss',
			'vendor/global/plugins.scss',
			'vendor/layouts/layout/layout.scss',
			'vendor/layouts/layout/themes/default.scss',
			'vendor/layouts/layout/themes/darkblue.scss',
			'vendor/layouts/layout/custom.scss',
		], 'public/assets/css/admin/app.css')

		.scripts([
			'./node_modules/jquery/dist/jquery.js',
			'./node_modules/bootstrap-sass/assets/javascripts/bootstrap.js',
			'./node_modules/sweetalert/dist/sweetalert.min.js',
			'./node_modules/jquery-validate/dist/validate.js',
			'vendor/packager.min.js',
			'admin/**',
			'./node_modules/jquery-pjax/jquery.pjax.js',
			'vendor/topbar.js',
		], 'public/assets/js/admin/app.js')

		.version([
			'assets/css/admin/app.css',
			'assets/js/admin/app.js',
		])

		.livereload();

	if (elixir.config.production) {
		mix.compress();
	}
});
