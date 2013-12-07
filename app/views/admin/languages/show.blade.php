<dl>

	@foreach ($labels as $field => $label)
		@if ( ! is_null($resource->{$field}))
			<dt>{{ $label }}</dt>
			<dd>{{{ $resource->{$field} }}}</dd>
		@endif
	@endforeach

	<dt>{{ _('Users') }}</dt>
	<dd>{{{ $resource->users->count() }}}</dd>

	<dt>{{ _('Last update') }}</dt>
	<dd>{{{ $resource->lastUpdate() }}}</dd>

</dl>
