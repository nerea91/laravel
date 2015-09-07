if(typeof $ != 'undefined') {

	var $doc = $(document), $window = $(window);

	$doc.ready(function() {

		// Zurb Foundation
		if($.fn.foundation)
			$doc.foundation();

	});

	//Checkboxes togglers
	$('.checkbox_togglers a').click(function(e) {
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

	// Show spinner when leaving the page
	$window.on('beforeunload', function() {
		$('body').append('<span class="spinner"></span>');
	});

	// Disable form button after submit
	$('form').not('dontDisable').submit(function() {
		$(':input[type=submit]', $(this)).prop('disabled', true);
		return true;
	});

}
