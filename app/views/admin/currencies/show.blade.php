<dl>
	@foreach ($labels as $field => $label)
		@if ( ! is_null($resource->{$field}))
			<dt>{{ $label }}</dt>
			<dd>{{{ $resource->{$field} }}}</dd>
		@endif
	@endforeach

	<dt>{{ _('Countries') }}</dt>
	@foreach ($resource->countries as $c)
		<dd>{{{ $c }}}</dd>
	@endforeach

</dl>
