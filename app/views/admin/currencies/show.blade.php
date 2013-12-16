<dl>
	@foreach ($labels as $field => $label)
		@if ( ! is_null($resource->{$field}))
			<dt>{{ $label }}</dt>

			@if ($field == 'symbol_position')
			<dd>{{{ ($resource->{$field}) ? _('Right') : _('Left') }}}</dd>
			@else
			<dd>{{{ $resource->{$field} }}}</dd>
			@endif

		@endif
	@endforeach

	<dt>{{ _('Sample') }}</dt>
	<dd>{{{ $resource->format(1234.56) }}}</dd>

	<dt>{{ _('Countries') }}</dt>
	@if ($resource->countries->count())
		@foreach ($resource->countries as $c)
		<dd>{{{ $c }}}</dd>
		@endforeach
	@else
		<dd>0</dd>
	@endif

</dl>
