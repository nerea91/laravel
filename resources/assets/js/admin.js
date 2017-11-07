require('./foundation');
if(typeof $ != 'undefined') {

	var $doc = $(document), $window = $(window);
	$doc.ready(function() {
		//Toggle confirmation modals
		// Replace prompt/action and show modal
		$('a.toggle-confirm-modal').click(function (e) {
			e.preventDefault();
			var $form = $('#' + $(this).attr('data-toggle'));
			$('.prompt', $form).text($(this).attr('title'));
			$form.attr('action', $(this).attr('href'));
		});

	});
}
