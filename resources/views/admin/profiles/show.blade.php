<dl>

	<dt>{{ $labels->name }}</dt>
	<dd>{{ $resource->name }}</dd>

	@if ($resource->description)
	<dt>{{ $labels->description }}</dt>
	<dd>{{ $resource->description }}</dd>
	@endif

	<dt>{{ _('Permissions') }}</dt>
	@foreach ($resource->getPermissionsGroupedByType(true) as $type => $array)
	<dd>{{ $type }}: <i>{{ implode(', ', $array) }}.</i></dd>
	@endforeach

	@if ($viewUser and $resource->users->count())
	<dt>{{ _('Users') }}</dt>
	<dd>{{ $resource->users->sortBy('username')->implode('username', ', ') }}</dd>
	@endif

	<dt>{{ _('Last update') }}</dt>
	<dd>{{ $resource->lastUpdate() }}</dd>
	<dd>{{ $resource->lastUpdateDiff() }}</dd>

</dl>
