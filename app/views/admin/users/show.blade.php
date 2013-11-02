<dl>

	<dt>{{ $resource->getLabel('username') }}</dt>
	<dd>{{{ $resource->username }}}</dd>

	@if ($resource->name)
	<dt>{{ $resource->getLabel('name') }}</dt>
	<dd>{{{ $resource->name }}}</dd>
	@endif

	@if ($resource->description)
	<dt>{{ $resource->getLabel('description') }}</dt>
	<dd>{{{ $resource->description }}}</dd>
	@endif

	<dt>{{ $resource->getLabel('profile_id') }}</dt>
	<dd>{{{ $resource->profile->name }}}</dd>

	@if ($resource->country_id)
	<dt>{{ $resource->getLabel('country_id') }}</dt>
	<dd>{{{ $resource->country->name }}}</dd>
	@endif

</dl>
