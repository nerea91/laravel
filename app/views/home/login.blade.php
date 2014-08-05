@section('main')
<div class="row">
	<div class="small-11 small-centered large-5 columns">

		<h3 class="subheader text-center">{{ _('Enter your credentials') }}</h3>
		<hr/>

		@if(Session::has('error'))
		<div class="alert-box alert" data-alert>
			{{ Session::get('error') }}
			<a class="close">&times;</a>
		</div>
		@endif

		{{ Form::open(['action' => 'AuthController@login']) }}
		{{ Form::text('username', null, ['placeholder' => _('Username'), 'autofocus']) }}
		<input name="password" type="password" placeholder="{{_('Password')}}" /> {{-- Laravel Form::password filters the placeholder so we don't use it --}}
		{{ Form::submit(_('Login'), ['class' => 'button expand']) }}

		<label class="left">
			{{ Form::checkbox('remember') }}
			&nbsp;{{ _('Remember me') }}
		</label>
		<a href="#" class="right" data-reveal-id="problems">{{ _('Problems?') }}</a>

		{{ Form::close() }}

		@if ($providers->count())
		<hr/>
		<fieldset class="callout panel">
			<legend>{{ _('One click login') }}</legend>
			@foreach($providers as $provider)
			{{ link_to_route('login.oauth', $provider, [$provider->name], ['class' => 'tiny button', 'style' => 'padding:.5em 1em']) }}
			@endforeach
		</fieldset>
		@endif

	</div>
</div>

<div id="problems" class="reveal-modal small" data-reveal>
	<ul>
		<li><a>{{ _("I don't know my username") }}</a></li>
		<li><a>{{ _("I don't know my password") }}</a></li>
		<li>{{ link_to_route('contact', _("I'm having other problems")) }}</li>
	</ul>
	<a class="close-reveal-modal">&#215;</a>
</div>
@stop
