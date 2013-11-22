@section('main')
<div class="row">
	<div class="small-11 small-centered large-6 large-centered columns">
		{{ Form::model($resource, array('method' => 'PUT', 'route' => array("$prefix.update", $resource->id))) }}

		@include("$prefix.fields")

		<div class="row">
			<div class="large-{{ $columns = 12/(1 + $view) }} columns">
				{{ Form::submit(_('Update'), array('class' => 'small radius button expand')) }}
			</div>

			@if ($view)
			<div class="large-{{ $columns }} columns">
				{{ link_to_route("$prefix.show", _('Cancel'), $resource->id, array('class' => 'small secondary radius button expand')) }}
			</div>
			@endif
		</div>

		{{ Form::close() }}
	</div>
</div>

@stop
