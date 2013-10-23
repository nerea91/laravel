@section('main')
{{ Form::open(['route' => 'profiles.store', 'class' => 'custom']) }}

	<div class="{{ ($e = $errors->has('name')) ? 'error' : null }}">
		{{ Form::label('name', _('Name')) }}
		{{ Form::text('name') }}
		@if($e)<small>{{$errors->first('name');}}</small>@endif
	</div>

	<div class="{{ ($e = $errors->has('description')) ? 'error' : null }}">
		{{ Form::label('description', _('Description')) }}
		{{ Form::text('description') }}
		@if($e)<small>{{$errors->first('description');}}</small>@endif
	</div>

	{{ Form::submit(_('Add'), array('class' => 'small button radius')) }}

{{ Form::close() }}
@stop
