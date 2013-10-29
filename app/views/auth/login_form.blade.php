@section('body')
<div class="row">
	<div class="small-11 small-centered large-5 columns">

		<h2>{{{ Config::get('site.name') }}}</h2>
		<h3 class="subheader">{{ _('Enter your credentials') }}</h3>
		<hr/>

		@if(Session::has('error'))
		<div class="alert-box alert">
			{{ Session::get('error') }}
			<a class="close">&times;</a>
		</div>
		@endif

		{{ Form::open(['action' => 'AuthController@doLogin']) }}
		{{ Form::text('username', null, ['placeholder' => _('Username'), 'autofocus']) }}
		{{ Form::password('password', ['placeholder' => _('Password')]) }}
		{{ Form::submit(_('Login'), ['class' => 'radius small button expand']) }}

		<label class="left">
			{{ Form::checkbox('remember') }}
			&nbsp;{{ _('Remember me') }}
		</label>
		<span class="right"><a href="#" data-reveal-id="problems">{{ _('Problems?') }}</a>

		{{ Form::close() }}
	</div>
</div>

<div id="problems" class="reveal-modal small">
	<ul>
		<li><a>{{ _("I don't know my username") }}</a></li>
		<li><a>{{ _("I don't know my password") }}</a></li>
		<li><a>{{ _("I'm having other problems") }}</a></li>
	</ul>
	<a class="close-reveal-modal">&#215;</a>
</div>
@stop

