<dl>
	@foreach ($labels as $field => $label)
		@if ( ! is_null($resource->{$field}))
			<dt>{{ $label }}</dt>
			<dd>{{{ $resource->{$field} }}}</dd>
		@endif
	@endforeach

	<dt>{{ _('Accounts') }}</dt>
	<dd>{{{ $resource->accounts->count() }}}</dd>
</dl>
