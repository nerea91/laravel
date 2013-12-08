<dl>

	<dt>{{ $labels->username }}</dt>
	<dd>{{{ $resource->username }}}</dd>

	@if ($resource->name)
	<dt>{{ $labels->name }}</dt>
	<dd>{{{ $resource->name }}}</dd>
	@endif

	@if ($resource->description)
	<dt>{{ $labels->description }}</dt>
	<dd>{{{ $resource->description }}}</dd>
	@endif

	<dt>{{ $labels->profile_id }}</dt>
	<dd>{{{ $resource->profile->name }}}</dd>

	@if ($resource->country_id)
	<dt>{{ $labels->country_id }}</dt>
	<dd>{{{ $resource->country }}}</dd>
	@endif

	@if ($resource->language_id)
	<dt>{{ $labels->language_id }}</dt>
	<dd>{{{ $resource->language }}}</dd>
	@endif

	<dt>{{ _('Accounts') }}</dt>
	@foreach ($resource->accounts()->with('provider')->get() as $a)
	<dd>{{{ $a->provider }}}</dd>
	@endforeach

	<dt>{{ _('Last update') }}</dt>
	<dd>{{{ $resource->lastUpdate() }}}</dd>
	<dd>{{{ $resource->lastUpdateDiff() }}}</dd>
</dl>
