if(typeof $ != 'undefined') {

	var $doc = $(document);

	// This event is specific to jQuery. Occurs first, after the HTML-Document is loaded and DOM is ready.
	$doc.ready(function() {

		// Zurb Foundation
		if($.fn.foundation)
		{
			$doc.foundation();

			$('form').not('.nospinner').submit(function() {
				$(':input[type=submit]', $(this)).prop("disabled", true);
				$('body').append('<span class="spinner"></span>');
				return true;
			});
		}
	});

	//Checkboxes togglers
	$('.checkbox_togglers a').click(function(e){
		e.preventDefault();
		var $scope = ($(this).attr('rel') !== undefined) ? $(this).attr('rel') : $(this).parent().parent();
		var $checkboxes = $('input:checkbox', $scope);
		switch($(this).attr('href'))
		{
			case 'all':
				$checkboxes.prop('checked', true);
			break;

			case 'none':
				$checkboxes.prop('checked', false);
			break;

			case 'invert':
				$checkboxes.each( function() {$(this).prop('checked', ! $(this).prop('checked'));});
			break;
		}
	});

	// This event is a standard event in the DOM. Occurs later, after all content (e.g. images, frames,...) are fully loaded.
	/*$(window).load(function() {
		...
	});*/
}



