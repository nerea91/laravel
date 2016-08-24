if(typeof $ != 'undefined') {
	
	var $doc = $(document), $window = $(window);
	$doc.ready(function() {
		//Toggle confirmation modals
		var $confirmModals = $('#confirmation-modals');
		if($confirmModals.length)
		{
			// Close modal on click cancel button
			$('.close-confirm-modal', $confirmModals).click(function() {
				$confirmModals.foundation('reveal', 'close');
			});

			// Replace prompt/action and show modal
			$('a.toggle-confirm-modal').click(function(e) {
				e.preventDefault();
				var $form = $('#' + $(this).attr('data-toggle'), $confirmModals);
				$('.prompt', $form).text($(this).attr('title'));
				$form.attr('action', $(this).attr('href'));
			});
		}

	});
}
