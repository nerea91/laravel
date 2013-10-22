@section('body')
<div class="row">
	<div class="small-11 small-centered large-5 columns">

		<h2>{{{ Config::get('site.name') }}}</h2>
		<h3 class="subheader">{{ _('Contact us') }}</h3>
		<hr/>

		{{ Form::open(['route' => 'send.contact.email']) }}

		@if (isset($success))
		<div class="alert-box success radius">{{ $success }}<a class="close">&times;</a></div>
		@else
		<p>{{ _('Please enter your contact details and we will try to contact you back as soon as possible') }}.</p>
		@endif

		<div class="row">
			<div class="large-7 columns {{ ($e = $errors->has('name')) ? 'error' : null }}">
				{{ Form::text('name', null, ['placeholder' => '* ' . _('Name'), 'autofocus']) }}
				@if($e)<small>{{$errors->first('name');}}</small>@endif
			</div>
			<div class="large-5 columns {{ ($e = $errors->has('company')) ? 'error' : null }}">
				{{ Form::text('company', null, ['placeholder' => _('Company'), 'autofocus']) }}
				@if($e)<small>{{$errors->first('company');}}</small>@endif
			</div>
		</div>

		<div class="row">
			<div class="large-7 columns {{ ($e = $errors->has('email')) ? 'error' : null }}">
				{{ Form::email('email', null, ['placeholder' => '* ' . _('E-mail'), 'autofocus']) }}
				@if($e)<small>{{$errors->first('email');}}</small>@endif
			</div>
			<div class="large-5 columns {{ ($e = $errors->has('phone')) ? 'error' : null }}">
				{{ Form::text('phone', null, ['placeholder' => _('Phone'), 'autofocus']) }}
				@if($e)<small>{{$errors->first('phone');}}</small>@endif
			</div>
		</div>

		<div class="{{ ($e = $errors->has('message')) ? 'error' : null }}">
			{{ Form::textarea('message', null, ['placeholder' => '* ' . _('Message'), 'autofocus']) }}
			@if($e)<small>{{$errors->first('message');}}</small>@endif
		</div>

		{{ Form::submit(_('Send'), ['class' => 'radius small button expand']) }}

		{{ Form::close() }}
	</div>
</div>
@stop

@section('css')
<style>
textarea{min-height:5em}
</style>
@stop
