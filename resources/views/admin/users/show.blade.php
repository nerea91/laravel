<dl>

	<dt>{{ $labels->username }}</dt>
	<dd>{{ $resource->username }}</dd>

	@if ($resource->name)
		<dt>{{ $labels->name }}</dt>
		<dd>{{ $resource->name }}</dd>
	@endif

	@if ($resource->description)
		<dt>{{ $labels->description }}</dt>
		<dd>{{ $resource->description }}</dd>
	@endif

	@if ($viewProfile)
		<dt>{{ $labels->profile_id }}</dt>
		<dd>{{ $resource->profile }}</dd>
	@endif

	@if ($viewCountry and $resource->country_id)
		<dt>{{ $labels->country_id }}</dt>
		<dd>{{ $resource->country }}</dd>
	@endif

	@if ($viewLanguage and $resource->language_id)
		<dt>{{ $labels->language_id }}</dt>
		<dd>{{ $resource->language }}</dd>
	@endif

	@if ($viewAccount)
		<dt>{{ _('Accounts') }}</dt>
		@foreach ($resource->accounts()->with('provider')->get() as $a)
			<dd>{{ $a->provider }} ({{ sprintf(ngettext('%d login', '%d logins', $a->login_count), $a->login_count)}})</dd>
		@endforeach
	@endif

	<dt>{{ _('Last update') }}</dt>
	<dd>{{ $resource->lastUpdate() }}</dd>
	<dd>{{ $resource->lastUpdateDiff() }}</dd>
</dl>
