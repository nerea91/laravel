@section('main')
	<div class="small-11 small-centered large-6 large-centered columns">
		{!! Form::model($resource, array('method' => 'PUT', 'route' => array("$prefix.update", $resource->getKey()))) !!}

		@include("$prefix.fields")

		<div class="row">
			<div class="large-{{ $columns = 12/(1 + $view) }} columns">
				{!! Form::submit(_('Update'), array('class' => 'button expand')) !!}
			</div>

			@if ($view)
				<div class="large-{{ $columns }} columns">
					{!! link_to_route("$prefix.show", _('Cancel'), [$resource->getKey()], array('class' => 'secondary button expand')) !!}
				</div>
			@endif
		</div>

		{!! Form::close() !!}
	</div>
@stop
