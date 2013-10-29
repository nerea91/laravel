<dl>
	@foreach ($labels as $field => $label)
	<dt>{{ $label }}</dt>
	<dd>{{{ $resource->{$field} }}}</dd>
	@endforeach
</dl>
