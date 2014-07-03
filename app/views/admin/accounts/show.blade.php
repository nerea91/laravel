<dl>

	<dt>{{ $labels->provider_id }}</dt>
	<dd>{{{ $resource->provider }}}</dd>

	<dt>{{ $labels->user_id }}</dt>
	<dd>{{{ $resource->user }}}</dd>

	@foreach ($labels as $field => $label)
		@if ( ! is_null($resource->{$field}) and $field !== 'provider_id' and $field !== 'user_id')
			<dt>{{ $label }}</dt>
			<dd>{{{ $resource->{$field} }}}</dd>
		@endif
	@endforeach

	<dt>{{ _('Last update') }}</dt>
	<dd>{{{ $resource->lastUpdate() }}}</dd>
	<dd>{{{ $resource->lastUpdateDiff() }}}</dd>

</dl>
