<dl>
	@foreach (array_except((array)$labels, ['currency_id', 'eea']) as $field => $label)
		@if ( ! is_null($resource->{$field}))
			<dt>{{ $label }}</dt>
			<dd>{{{ $resource->{$field} }}}</dd>
		@endif
	@endforeach

	<dt>{{ $labels->eea }}</dt>
	<dd>{{{ ($resource->eea) ? _('Yes') : _('No') }}}</dd>

	<dt>{{ $resource->currency->singular() }}</dt>
	<dd>{{{ $resource->currency }}}</dd>

	<dt>{{ _('Users') }}</dt>
	<dd>{{{ $resource->users->count() }}}</dd>

</dl>
