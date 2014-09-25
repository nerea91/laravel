@section('main')
<div class="small-11 small-centered large-7 columns">

	{!! Form::open(['route' => 'contact.send']) !!}

	@if (Session::has('success'))
	<div class="alert-box success radius" data-alert>{{ Session::get('success') }}<a class="close">&times;</a></div>
	@else
	<p>{{ _('Please enter your contact details and we will try to contact you back as soon as possible') }}.</p>
	@endif

	<div class="row">
		<div class="large-6 columns">
			{!! Form::text('name', null, ['placeholder' => '* ' . _('Name'), 'autofocus']) !!}
		</div>
		<div class="large-6 columns">
			{!! Form::text('company', null, ['placeholder' => _('Company')]) !!}
		</div>
	</div>

	<div class="row">
		<div class="large-6 columns">
			{!! Form::email('email', null, ['placeholder' => '* ' . _('E-mail')]) !!}
		</div>
		<div class="large-6 columns">
			{!! Form::text('phone', null, ['placeholder' => _('Phone')]) !!}
		</div>
	</div>

	{!! Form::textarea('message', null, ['placeholder' => '* ' . _('Message')]) !!}

	{!! Form::submit(_('Send query'), ['class' => 'button expand']) !!}

	{!! Form::close() !!}
</div>
@stop

