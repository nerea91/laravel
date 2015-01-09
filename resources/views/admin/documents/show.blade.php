<h3>{{ _('Profiles') }}</h3>
{{enum($resource->profiles->lists('name'))}}

<h2>{{ $resource->title }}</h2>
{!! markdown($resource->body) !!}
