<dl>

	@if($viewProvider)
		<dt>{{ $labels->provider_id }}</dt>
		<dd>{{ $resource->provider }}</dd>
	@endif

	@if($viewUser)
		<dt>{{ $labels->user_id }}</dt>
		<dd>{{ $resource->user }}</dd>
	@endif

	@foreach ($labels as $field => $label)
		@if ( ! is_null($resource->{$field}) and $field !== 'provider_id' and $field !== 'user_id')
			<dt>{{ $label }}</dt>
			<dd>{{ $resource->{$field} }}</dd>
		@endif
	@endforeach

	<dt>{{ _('Last update') }}</dt>
	<dd>{{ $resource->lastUpdate() }}</dd>
	<dd>{{ $resource->lastUpdateDiff() }}</dd>

</dl>
