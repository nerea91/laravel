<dl>

	@foreach ($labels as $field => $label)
		@if ( ! is_null($resource->{$field}) and $field != 'currency_id')
			<dt>{{ $label }}</dt>
			<dd>{{{ $resource->{$field} }}}</dd>
		@endif
	@endforeach

	<dt>{{ $resource->currency->singular() }}</dt>
	<dd>{{{ $resource->currency }}}</dd>

	<dt>{{ _('Users') }}</dt>
	<dd>{{{ $resource->users->count() }}}</dd>
</dl>
