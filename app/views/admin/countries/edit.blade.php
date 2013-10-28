@section('main')
<div class="row">
	<div class="small-11 small-centered large-6 large-centered columns">
		{{ Form::model($resource, array('method' => 'PUT', 'route' => array("$prefix.update", $resource->id), 'class' => 'custom')) }}

		@foreach ($labels as $field => $label)
		<div class="{{ ($e = $errors->has($field)) ? 'error' : null }}">
		{{ Form::label($field, $label) }}
		{{ Form::text($field) }}
		@if($e)<small>{{$errors->first($field);}}</small>@endif
		</div>
		@endforeach

		{{ Form::submit(_('Update'), array('class' => 'small radius button left')) }}
		@if ($view)
		{{ link_to_route("$prefix.show", _('Cancel'), $resource->id, array('class' => 'small secondary radius button right')) }}
		@endif

		{{ Form::close() }}
	</div>
</div>

@stop
