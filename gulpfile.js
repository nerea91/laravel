var elixir = require('laravel-elixir');
elixir.config.sourcemaps = false;

// Shortcut name for common paths
var assetsDir = elixir.config.assetsDir;       // resources/assets/
var bowerDir = assetsDir + 'bower/';           // resources/assets/bower/
var foundationDir = bowerDir + 'foundation/';  // resources/assets/bower/foundation/
var publicDir = elixir.config.publicDir + '/'; // plublic/
var publicCssDir = publicDir + 'css/';         // plublic/css/
var publicJsDir = publicDir + 'js/';           // plublic/js/

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
	mix.copy(assetsDir + 'js/app.js', foundationDir + 'js/');

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
		'vendor/modernizr.js',
		'vendor/jquery.js',
		'vendor/fastclick.js',

		// Components
		'foundation/foundation.js',
		//'foundation/foundation.abide.js',
		//'foundation/foundation.accordion.js',
		'foundation/foundation.alert.js',
		//'foundation/foundation.clearing.js',
		'foundation/foundation.dropdown.js',
		//'foundation/foundation.equalizer.js',
		//'foundation/foundation.interchange.js',
		//'foundation/foundation.joyride.js',
		//'foundation/foundation.magellan.js',
		'foundation/foundation.offcanvas.js',
		//'foundation/foundation.orbit.js',
		//'foundation/foundation.reveal.js',
		//'foundation/foundation.slider.js',
		//'foundation/foundation.tab.js',
		//'foundation/foundation.tooltip.js',
		//'foundation/foundation.topbar.js',
		'app.js'
	];

	// Build CSS
	mix.sass('master.scss', publicCssDir + 'master.css', {includePaths: [foundationDir + 'scss/', bowerDir + 'spinners/stylesheets']});

	// Build JavaScript
	mix.scripts(components, publicJsDir + 'master.js', foundationDir + 'js/');
}

// ===== BACKEND ===============================================================

function doBackend(mix)
{
	// Foundation components to include
	var components = [
		// Vendor dependencies
		'vendor/modernizr.js',
		'vendor/jquery.js',
		//'vendor/fastclick.js',

		// Components
		'foundation/foundation.js',
		//'foundation/foundation.abide.js',
		//'foundation/foundation.accordion.js',
		'foundation/foundation.alert.js',
		//'foundation/foundation.clearing.js',
		'foundation/foundation.dropdown.js',
		//'foundation/foundation.equalizer.js',
		//'foundation/foundation.interchange.js',
		//'foundation/foundation.joyride.js',
		'foundation/foundation.magellan.js',
		'foundation/foundation.offcanvas.js',
		//'foundation/foundation.orbit.js',
		'foundation/foundation.reveal.js',
		//'foundation/foundation.slider.js',
		//'foundation/foundation.tab.js',
		'foundation/foundation.tooltip.js',
		'foundation/foundation.topbar.js',
		'app.js'
	];

	// Build CSS
	mix.sass('admin.scss', publicCssDir + 'admin.css', {includePaths: [foundationDir + 'scss/', bowerDir + 'spinners/stylesheets']});

	// Build JavaScript
	mix.scripts(components, publicJsDir + 'admin.js', foundationDir + 'js/');
}

