<dl>

	@foreach (array_except((array) $labels, ['is_default']) as $field => $label)
		@if ( ! is_null($resource->{$field}))
			<dt>{{ $label }}</dt>
			<dd>{{ $resource->{$field} }}</dd>
		@endif
	@endforeach

	<dt>{{ $labels->is_default }}</dt>
	<dd>{{ ($resource->is_default) ? _('Yes') : _('No') }}</dd>

	@if ($viewUser)
		<dt>{{ _('Users') }}</dt>
		<dd>{{ $resource->users->count() }}</dd>
	@endif

</dl>
