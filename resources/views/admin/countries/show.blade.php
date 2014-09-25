<dl>
	@foreach (array_except((array) $labels, ['currency_id', 'eea']) as $field => $label)
		@if ( ! is_null($resource->{$field}))
			<dt>{{ $label }}</dt>
			<dd>{{ $resource->{$field} }}</dd>
		@endif
	@endforeach

	<dt>{{ $labels->eea }}</dt>
	<dd>{{ ($resource->eea) ? _('Yes') : _('No') }}</dd>

	@if ($viewCurrency and $resource->currency_id)
		<dt>{{ $labels->currency_id }}</dt>
		<dd>{{ $resource->currency }}</dd>
	@endif

	@if ($viewUser)
		<dt>{{ _('Users') }}</dt>
		<dd>{{ $resource->users->count() }}</dd>
	@endif

</dl>
