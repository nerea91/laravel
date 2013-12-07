<dl>
	@foreach ($labels as $field => $label)
		@if ( ! is_null($resource->{$field}))
			<dt>{{ $label }}</dt>
			<dd>{{{ $resource->{$field} }}}</dd>
		@endif
	@endforeach

	<dt>{{ _('Accounts') }}</dt>
	<dd>{{{ $resource->accounts->count() }}}</dd>

	<dt>{{ _('Last update') }}</dt>
	<dd>{{{ $resource->lastUpdate() }}}</dd>
	<dd>{{{ $resource->lastUpdateDiff() }}}</dd>
</dl>
