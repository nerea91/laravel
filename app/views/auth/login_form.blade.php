@section('body')
<div class="row">
	<div class="small-11 small-centered large-5 columns">

		<h2 class="text-center">{{{ Config::get('site.name') }}}</h2>
		<h3 class="subheader text-center">{{ _('Enter your credentials') }}</h3>
		<hr/>

		@if(Session::has('error'))
		<div class="alert-box alert" data-alert>
			{{ Session::get('error') }}
			<a class="close">&times;</a>
		</div>
		@endif

		{{ Form::open(['action' => 'AuthController@doLogin']) }}
		{{ Form::text('username', null, ['placeholder' => _('Username'), 'autofocus']) }}
		{{ Form::password('password', ['placeholder' => _('Password')]) }}
		{{ Form::submit(_('Login'), ['class' => 'button expand']) }}

		<label class="left">
			{{ Form::checkbox('remember') }}
			&nbsp;{{ _('Remember me') }}
		</label>
		<a href="#" class="right" data-reveal-id="problems">{{ _('Problems?') }}</a>

		{{ Form::close() }}


		{{-- Button to change language --}}
		@if ($languages->count())
		<div class="text-right">
			<br/>
			<a href="#" data-dropdown="language-list" class="tiny secondary button dropdown">{{ $appLanguage->name }}</a>
			<ul id="language-list" data-dropdown-content class="f-dropdown content-disabled text-left">
				@foreach ($languages as $l)
					<li>{{link_to_route('language.set', $l->name, ['code' => $l->code, 'class' => "flag {$l->code}"]) }}</li>
				@endforeach
			</ul>
		</div>
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
