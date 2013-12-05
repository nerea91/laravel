<dl>

	@foreach ($labels as $field => $label)
		@if ( ! is_null($resource->{$field}))
			<dt>{{ $label }}</dt>
			<dd>{{{ $resource->{$field} }}}</dd>
		@endif
	@endforeach

	<dt>{{ _('Users') }}</dt>
	<dd>{{{ $resource->users->count() }}}</dd>

</dl>
