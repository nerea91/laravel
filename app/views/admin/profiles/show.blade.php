<dl>

	<dt>{{ $labels->name }}</dt>
	<dd>{{{ $resource->name }}}</dd>

	@if ($resource->description)
	<dt>{{ $labels->description }}</dt>
	<dd>{{{ $resource->description }}}</dd>
	@endif

	<dt>{{ _('Permissions') }}</dt>
	@foreach ($resource->getPermissionsGroupedByType(true) as $type => $array)
	<dd>{{$type}}: <i>{{ implode(', ', $array)}}.</i></dd>
	@endforeach

	@if ($resource->users)
	<dt>{{ _('Users') }}</dt>
	<dd>{{ implode(', ', $resource->getUsernamesArray())}}</dd>
	@endif

	<dt>{{ _('Last update') }}</dt>
	<dd>{{{ $resource->lastUpdate() }}}</dd>
	<dd>{{{ $resource->lastUpdateDiff() }}}</dd>

</dl>
