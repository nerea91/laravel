<dl>
	@foreach ($labels as $field => $label)
		@if ( ! is_null($resource->{$field}))
			<dt>{{ $label }}</dt>

			@if ($field === 'symbol_position')
			<dd>{{ ($resource->{$field}) ? _('Right') : _('Left') }}</dd>
			@else
			<dd>{{ $resource->{$field} }}</dd>
			@endif

		@endif
	@endforeach

	<dt>{{ _('Sample') }}</dt>
	<dd><span class="currency">{{ $resource->format(1234.56) }}</span></dd>

	@if ($viewCountry and $resource->countries->count())
		<dt>{{ _('Countries') }}</dt>
		<dd>{{ $resource->countries->sortBy('name')->implode('name', ', ') }}</dd>
	@endif

</dl>
