<thead>
	<tr>
		<th>{{ $links->username }}</th>
		<th>{{ $links->profile_id }}</th>
		<th>{{ $links->country_id }}</th>
		<th class="actions text-center">{{ _('Actions') }}</th>
	</tr>
</thead>

<tbody>
	@foreach ($results as $resource)
	<tr>
		<td><span data-tooltip class="has-tip" title="{{ $resource->name }}">{{ $resource->username }}</span></td>
		<td>{{ $resource->profile->name }}</td>
		<td>{{ (isset($resource->country->name)) ? $resource->country->name : null }}</td>
		@include('resource.actions')
	</tr>
	@endforeach
</tbody>
