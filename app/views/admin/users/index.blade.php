<thead>
	<tr>
		<th>{{ $labels->username }}</th>
		<th>{{ $labels->profile_id }}</th>
		<th>{{ $labels->country_id }}</th>
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
