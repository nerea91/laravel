if(typeof $ != 'undefined') {

	var $doc = $(document);

	// This event is specific to jQuery. Occurs first, after the HTML-Document is loaded and DOM is ready.
	$doc.ready(function() {

		// Zurb Foundation
		if($.fn.foundation)
		{
			$doc.foundation();

			$('form').submit(function() {
				$('*', this).css('visibility', 'hidden');
				$(this).append('<div class="preloader"></div>');
				return true;
			});
		}
	});

	// This event is a standard event in the DOM. Occurs later, after all content (e.g. images, frames,...) are fully loaded.
	/*$(window).load(function() {
		...
	});*/
}



