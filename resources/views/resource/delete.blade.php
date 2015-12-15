{{-- Modal form to confirm deletion of resource --}}

{!! Form::open(['method' => 'DELETE', 'id' => 'delete-modal', 'class' => 'reveal', 'data-reveal']) !!}
	<h3 class="prompt text-center">{{-- Populated with JS --}}</h3>
	<p class="lead text-center"><?= _('Are you sure?') ?></p>
	<div class="row">
		<div class="small-6 columns">
			<a class="close-confirm-modal secondary button expand"><?= _('Cancel') ?></a>
		</div>

		<div class="small-6 columns">
		{!! Form::submit(_('Confirm'), array('class' => 'alert button expand')) !!}
		</div>
	</div>
	<a class="close-reveal-modal">&#215;</a>
{!! Form::close() !!}


{{-- Modal form to confirm restoration of resource --}}

{!! Form::open(['method' => 'PUT', 'id' => 'restore-modal', 'class' => 'reveal', 'data-reveal']) !!}
	<h3 class="prompt text-center">{{-- Populated with JS --}}</h3>
	<p class="lead text-center"><?= _('Are you sure?') ?></p>
	<div class="row">
		<div class="small-6 columns">
			<a class="close-confirm-modal secondary button expand"><?= _('Cancel') ?></a>
		</div>

		<div class="small-6 columns">
		{!! Form::submit(_('Confirm'), array('class' => 'success button expand')) !!}
		</div>
	</div>
	<a class="close-reveal-modal">&#215;</a>
{!! Form::close() !!}
