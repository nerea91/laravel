var elixir = require('laravel-elixir');

elixir.config.sourcemaps = false;

// Shortcut name for common paths
var assetsDir = elixir.config.assetsPath;       // resources/assets
var bowerDir = assetsDir + '/bower/';           // resources/assets/bower/
var foundationDir = bowerDir + 'foundation-sites/';  // resources/assets/bower/foundation-sites/
var publicDir = elixir.config.publicPath + '/'; // plublic/
var publicCssDir = publicDir + '/css/';         // plublic/css/
var publicJsDir = publicDir + '/js/';           // plublic/js/

// ===== MAIN ==================================================================

elixir(function(mix) {
	doCommon(mix);    // Assets required in both master and admin pages
	doFrontEnd(mix);  // Assets required only in the master page
	doBackend(mix);   // Assets required only in the admin page
});

// ===== COMMON ================================================================

function doCommon(mix)
{
	// Foundation app.js
	mix.copy(assetsDir + '/js/app.js', foundationDir + 'js/');

	// Foundation datepicker
	mix.copy(bowerDir + 'foundation-datepicker/css/foundation-datepicker.min.css', publicCssDir + 'datepicker.css');
	mix.copy(bowerDir + 'foundation-datepicker/js/foundation-datepicker.min.js', publicJsDir + 'datepicker.js');

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
		// Vendor dependencies
		'../modernizr/modernizr.js',
		'../jquery/dist/jquery.js',
		'../fastclick/lib/fastclick.js',
		'../what-input/what-input.js',

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
// 		"dist/foundation.js",
		'js/app.js'
	];

	// Build CSS
	mix.sass('master.scss', publicCssDir + 'master.css', {includePaths: [foundationDir + 'scss/', bowerDir + 'spinners/stylesheets']});

	// Build JavaScript
	mix.scripts(components, publicJsDir + 'master.js', foundationDir);
}

// ===== BACKEND ===============================================================

function doBackend(mix)
{
	// Foundation components to include
	var components = [
		// Vendor dependencies
		'../modernizr/modernizr.js',
		'../jquery/dist/jquery.js',
		'../fastclick/lib/fastclick.js',
		'../what-input/what-input.js',
		
		// Components
		"js/foundation.core.js",
		"js/foundation.util.keyboard.js",
		"js/foundation.dropdown.js",
		"js/foundation.util.motion.js",
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
		
		'js/app.js'
	];

	// Build CSS
	mix.sass('admin.scss', publicCssDir + 'admin.css', {includePaths: [foundationDir + 'scss/', bowerDir + 'spinners/stylesheets']});

	// Build JavaScript
	mix.scripts(components, publicJsDir + 'admin.js', foundationDir);
}

