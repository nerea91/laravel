@section('main')

<div class="row">
	<div class="small-11 small-centered large-6 large-centered columns">
		<dl>
			@foreach ($labels as $field => $label)
			<dt>{{ $label }}</dt>
			<dd>{{{ $resource->{$field} }}}</dd>
			@endforeach
		</dl>

		<div class="row">
			<div class="large-{{ $columns = 12/(1 + $edit + $delete) }} columns">
				{{-- If the referer page has a 'page' parameter redirect to there --}}
				@if (false !== strpos(URL::previous(), '?page=') )
					<a href="{{ URL::previous() }}" class="small radius secondary button expand">{{ _('Return') }}</a>
				@else
					{{ link_to_route("$prefix.index", _('Return'), [], array('class' => 'small radius secondary button expand')) }}
				@endif
			</div>

			@if ($edit)
			<div class="large-{{ $columns }} columns">
				{{ link_to_route("$prefix.edit", _('Edit'), array($resource->id), array('class' => 'small radius button expand')) }}
			</div>
			@endif

			@if ($delete)
			@include('admin.delete')
			<div class="large-{{ $columns }} columns">
				{{ link_to_route("$prefix.destroy", _('Delete'), array($resource->id), array('class' => 'small alert radius button expand toggle-delete-modal', 'title' => e(sprintf(_('Delete %s'), $resource->{$prompt})))) }}
			</div>
			@endif
		</div>

	</div>
</div>
@stop
