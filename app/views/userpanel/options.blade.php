@section('main')
<div class="row">
	<div class="small-11 small-centered medium-8 large-6 columns">

	@include('userpanel.nav', array('active' => 'options'))

	@if ($options->count())
		{{ Form::open(array('method' => 'PUT', 'route' => 'user.options.update')) }}

		@foreach ($options as $o)
		{{
			Form::label($o->name, $o->label),
			Form::text($o->name, $o->value)
		}}
		@endforeach

		{{
			Form::submit(_('Save'), ['class' => 'button']),
			Form::close()
		}}
	@else
		<div class="alert-box" data-alert>{{ _('System has no configurable options') }}<a class="close">&times;</a></div>
	@endif
	</div>
</div>
@stop
