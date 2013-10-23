$doc.ready(function() {

	//Toggle delete resource modal
	var $deleteModalForm = $('#delete-modal-form');
	if($deleteModalForm.length)
	{
		$('#delete-modal-close', $deleteModalForm).click(function() {
			$deleteModalForm.foundation('reveal', 'close');
		});

		var $deleteModalPrompt = $('#delete-modal-prompt', $deleteModalForm);
		$('a.toggle-delete-modal').click(function(e) {
			e.preventDefault();
			$deleteModalPrompt.text($(this).attr('title'));
			$deleteModalForm.attr('action', $(this).attr('href')).foundation('reveal', 'open');
		});
	}

});
