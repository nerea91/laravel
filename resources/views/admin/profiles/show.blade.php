<dl>

	<dt>{{ $labels->name }}</dt>
	<dd>{{ $resource->name }}</dd>

	@if ($resource->description)
	<dt>{{ $labels->description }}</dt>
	<dd>{{ $resource->description }}</dd>
	@endif

	<dt>{{ _('Permissions') }}</dt>
	@foreach ($resource->getPermissionsGroupedByType(true) as $type => $array)
	<dd>{{ _($type) }}: <i>{{ enum(array_map('gettext', $array)) }}.</i></dd>
	@endforeach

	@if ($viewUser and $resource->users->count())
	<dt>{{ _('Users') }}</dt>
	<dd>{{ enum($resource->users->sortBy('username')->lists('username')->all()) }}</dd>
	@endif

	<dt>{{ _('Last update') }}</dt>
	<dd>{{ $resource->lastUpdate() }}</dd>
	<dd>{{ $resource->lastUpdateDiff() }}</dd>

</dl>
