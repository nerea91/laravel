<dl>

	<dt>{{ $resource->getLabel('name') }}</dt>
	<dd>{{{ $resource->name }}}</dd>

	@if ($resource->description)
	<dt>{{ $resource->getLabel('description') }}</dt>
	<dd>{{{ $resource->description }}}</dd>
	@endif

	@if ($users)
	<dt>{{ _('Users') }}</dt>
	<dd>{{ implode(', ', $users)}}</dd>
	@endif

	<dt>{{ _('Permissions') }}</dt>
	@foreach ($permissions as $type => $array)
	<dd>{{$type}}: <i>{{ implode(', ', $array)}}.</i></dd>
	@endforeach

</dl>
