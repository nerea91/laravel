@section('body')
<div class="row">
	<div class="small-11 small-centered large-5 columns">

		<h2>{{{ Config::get('site.name') }}}</h2>
		<h3 class="subheader">{{ _('Contact us') }}</h3>
		<hr/>

		{{ Form::open(['route' => 'send.contact.email']) }}

		@if (Session::has('success'))
		<div class="alert-box success radius" data-alert>{{ Session::get('success') }}<a class="close">&times;</a></div>
		@else
		<p>{{ _('Please enter your contact details and we will try to contact you back as soon as possible') }}.</p>
		@endif

		<div class="row">
			<div class="large-7 columns">
				{{ Form::text('name', null, ['placeholder' => '* ' . _('Name'), 'autofocus']) }}
			</div>
			<div class="large-5 columns">
				{{ Form::text('company', null, ['placeholder' => _('Company')]) }}
			</div>
		</div>

		<div class="row">
			<div class="large-7 columns">
				{{ Form::email('email', null, ['placeholder' => '* ' . _('E-mail')]) }}
			</div>
			<div class="large-5 columns">
				{{ Form::text('phone', null, ['placeholder' => _('Phone')]) }}
			</div>
		</div>

		{{ Form::textarea('message', null, ['placeholder' => '* ' . _('Message')]) }}

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
