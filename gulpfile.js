var elixir = require('laravel-elixir');

elixir.config.sourcemaps = false;

elixir(function(mix) {

	// Compile CSS
	mix.sass(
		'app.scss', // Source files
		'public/packages/zurb/foundation/css', // Destination folder
		{includePaths: ['resources/assets/bower_components/foundation/scss']}
	);

	// Compile JavaScript
	mix.scripts(
		['vendor/modernizr.js', 'vendor/jquery.js', 'foundation.min.js'], // Source files
		'public/packages/zurb/foundation/js/app.js', // Destination file
		'resources/assets/bower_components/foundation/js/' // Source files base directory
	);

});
