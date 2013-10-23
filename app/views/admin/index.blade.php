{{-- Common part for all index.blade.php files of the admin secion --}}

{{ Form::open(['method' => 'DELETE', 'id' => 'delete-modal-form', 'class' => 'reveal-modal small']) }}
	<h3 id="delete-modal-prompt" class="text-center"></h3>
	<p class="lead text-center"><?= _('Are you sure?') ?></p>
	<div class="row">
		<div class="small-6 columns">
			<a id="delete-modal-close" class="secondary button radius expand"><?= _('Cancel') ?></a>
		</div>

		<div class="small-6 columns">
		{{ Form::submit(_('Confirm'), array('class' => 'alert button radius expand')) }}
		</div>
	</div>
	<a class="close-reveal-modal">&#215;</a>
{{ Form::close() }}
