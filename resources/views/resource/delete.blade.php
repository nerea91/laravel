{{-- Modal form to confirm deletion of resource --}}

{!! Form::open(['method' => 'DELETE', 'id' => 'delete-modal', 'class' => 'reveal', 'data-reveal']) !!}
	<h3 class="prompt text-center">{{-- Populated with JS --}}</h3>
	<p class="lead text-center"><?= _('Are you sure?') ?></p>
	<div class="row">
		<div class="small-6 columns">
			<a class="secondary button expanded" data-close><?= _('Cancel') ?></a>
		</div>

		<div class="small-6 columns">
		{!! Form::submit(_('Confirm'), array('class' => 'alert button expanded')) !!}
		</div>
	</div>
	<button class="close-button" data-close aria-label="Close reveal" type="button">
    <span aria-hidden="true">&times;</span>
  </button>
{!! Form::close() !!}


{{-- Modal form to confirm restoration of resource --}}

{!! Form::open(['method' => 'PUT', 'id' => 'restore-modal', 'class' => 'reveal', 'data-reveal']) !!}
	<h3 class="prompt text-center">{{-- Populated with JS --}}</h3>
	<p class="lead text-center"><?= _('Are you sure?') ?></p>
	<div class="row">
		<div class="small-6 columns">
			<a class="secondary button expanded" data-close><?= _('Cancel') ?></a>
		</div>

		<div class="small-6 columns">
		{!! Form::submit(_('Confirm'), array('class' => 'success button expanded')) !!}
		</div>
	</div>
	<button class="close-button" data-close aria-label="Close reveal" type="button">
    <span aria-hidden="true">&times;</span>
  </button>
{!! Form::close() !!}
