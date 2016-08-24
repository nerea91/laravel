$doc.ready(function() {
	
	//Toggle confirmation modals
	var $confirmModals = $('#confirmation-modals');
	if($confirmModals.length)
	{
		
		// Replace prompt/action and show modal
		$('a.toggle-confirm-modal').click(function(e) {
			e.preventDefault();
			
			var $form = $('#' + $(this).attr('data-toggle'));
			
			$('.prompt', $form).text($(this).attr('title'));
			$form.attr('action', $(this).attr('href'));
			
		});
	}
	
}); 
