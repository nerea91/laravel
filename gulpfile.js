const gulp = require('gulp'),
	elixir = require('laravel-elixir'),
	babel = require('gulp-babel'),
	rename = require("gulp-rename"), //use to save file with dest
	argv = require('yargs').argv; // use to get arguments


elixir.config.sourcemaps = false;

// Shortcut name for common paths
var assetsDir = elixir.config.assetsPath;       // resources/assets
var bowerDir = assetsDir + '/bower/';           // resources/assets/bower/
var foundationDir = bowerDir + 'foundation-sites/';  // resources/assets/bower/foundation-sites/
var publicDir = elixir.config.publicPath + '/'; // public/
var publicCssDir = publicDir + '/css/';         // public/css/
var publicJsDir = publicDir + '/js/';           // public/js/

// ===== MAIN ==================================================================

elixir(function(mix) {
	doCommon(mix);    // Assets required in both master and admin pages
	doFrontEnd(mix);  // Assets required only in the master page
	doBackend(mix);   // Assets required only in the admin page
});

/*
	Transform ES2016

	Ej: yo have a index_es.js write in ES2016 at resources/views/admin/users
		you must run ./node_modules/.bin/gulp compile -d admin/users -f index
		and it genarate resources/views/admin/users/index.js write in standar javascript
*/
gulp.task('compile', function() {
	var directory =  'resources/views/'+argv.d;
	var filename = argv.f;

	gulp.src(directory+'/'+filename+'_es.js')
	   .pipe(babel({
		   presets: ['es2016']
	   }))
	   .pipe(rename(filename+'.js'))
	   .pipe(gulp.dest(directory))

  });

// ===== COMMON ================================================================

function doCommon(mix)
{
	// Foundation app.js
	mix.copy(assetsDir + '/js/app.js', foundationDir + 'js/');

	// Foundation datepicker
	mix.copy(bowerDir + 'foundation-datepicker/css/foundation-datepicker.min.css', publicCssDir + 'datepicker.css');
	mix.copy(bowerDir + 'foundation-datepicker/js/foundation-datepicker.min.js', publicJsDir + 'datepicker.js');

	// Responsive tables
	mix.copy(bowerDir + 'responsive-tables/responsive-tables.css', publicCssDir + 'responsive-tables.css');
	mix.copy(bowerDir + 'responsive-tables/responsive-tables.js', publicJsDir + 'responsive-tables.js');

	// Offcanvas extras
	mix.styles('css/offcanvas.css', publicCssDir + 'offcanvas.css', assetsDir);
	mix.scripts('js/offcanvas.js', publicJsDir + 'offcanvas.js', assetsDir);

	// Markdown preview in full screen
	mix.scripts(['marked/marked.min.js', 'screenfull/dist/screenfull.js'], publicJsDir + 'markdown.js', bowerDir);

	// Data-tables for log viewer
	mix.styles(['jquery.dataTables.min.css', 'dataTables.foundation.min.css'], publicCssDir + 'datatables.css', bowerDir + 'datatables/media/css/');
	mix.scripts(['jquery.dataTables.min.js', 'dataTables.foundation.js'], publicJsDir + 'datatables.js', bowerDir + 'datatables/media/js/');
}

// ===== FRONTEND ==============================================================

function doFrontEnd(mix)
{
	// Foundation components to include
	var components = [

		// Components
		"js/foundation.core.js",
		"js/foundation.util.keyboard.js",
		"js/foundation.dropdown.js",
		"js/foundation.util.motion.js",
		"js/foundation.util.box.js",
		"js/foundation.util.triggers.js",
		"js/foundation.util.mediaQuery.js",
		"js/foundation.util.nest.js",
		"js/foundation.offcanvas.js",
		"js/foundation.dropdownMenu.js",
	];

	// Build CSS
	mix.sass('master.scss', publicCssDir + 'master.css', null, { includePaths: [foundationDir + 'scss/', bowerDir + 'spinners/stylesheets']});

	// Build JavaScript
	mix.webpack(components, publicJsDir + 'master.js', foundationDir);

	components = [
	// Vendor dependencies
	'../modernizr/modernizr.js',
	'../jquery/dist/jquery.js',
	'../fastclick/lib/fastclick.js',
	'../what-input/what-input.js',

	//master.js
	'../../../../public/js/master.js',

	'js/app.js'
	];

	mix.scripts(components, publicJsDir + 'master.js', foundationDir);
}

// ===== BACKEND ===============================================================

function doBackend(mix)
{
	// Foundation components to include
	var components = [

		// Components
		"js/foundation.core.js",
		"js/foundation.util.motion.js",
		"js/foundation.util.keyboard.js",
		"js/foundation.dropdown.js",
		"js/foundation.util.box.js",
		"js/foundation.util.triggers.js",
		"js/foundation.util.mediaQuery.js",
		"js/foundation.util.nest.js",
		"js/foundation.toggler.js",
		"js/foundation.reveal.js",
		"js/foundation.accordionMenu.js",
		"js/foundation.drilldown.js",
		"js/foundation.util.timerAndImageLoader.js",
		"js/foundation.util.touch.js",
		"js/foundation.offcanvas.js",
		"js/foundation.dropdownMenu.js",
		"js/foundation.magellan.js",
		"js/foundation.toggler.js",
		"js/foundation.tabs.js",
		"js/foundation.slider.js",
		"js/foundation.responsiveMenu.js",
		"js/foundation.responsiveToggle.js",
		"js/foundation.sticky.js",
	];

	// Build CSS
	mix.sass('admin.scss', publicCssDir + 'admin.css', null, {includePaths: [foundationDir + 'scss/', bowerDir + 'spinners/stylesheets', bowerDir + 'motion-ui']});

	// Build JavaScript
	mix.webpack(components, publicJsDir + 'admin.js', foundationDir);

	components = [
	// Vendor dependencies
	'../modernizr/modernizr.js',
	'../jquery/dist/jquery.js',
	'../fastclick/lib/fastclick.js',
	'../what-input/what-input.js',

	//admin.js
	'../../../../public/js/admin.js',

	'js/app.js',

	//modal.js
	'../../../../public/js/modal.js'

	];

	mix.scripts(components, publicJsDir + 'admin.js', foundationDir);

}
