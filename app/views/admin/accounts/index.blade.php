<thead>
	<tr>
		<th>{{ $labels->user_id }}</th>
		<th>{{ $labels->provider_id }}</th>
		<th>{{ $labels->email }}</th>
		<th class="actions text-center">{{ _('Actions') }}</th>
	</tr>
</thead>

<tbody>
	@foreach ($results as $resource)
	<tr>
		<td>{{ $resource->user->name }}</td>
		<td>{{ $resource->provider->title }}</td>
		<td>{{ $resource->email }}</td>
		@include('resource.actions')
	</tr>
	@endforeach
</tbody>
