<thead>
	<tr>
		<th>{{ $links->user_id }}</th>
		<th>{{ $links->provider_id }}</th>
		<th>{{ $links->email }}</th>
		<th class="text-center">{{ $links->login_count }}</th>
		<th class="actions text-center">{{ _('Actions') }}</th>
	</tr>
</thead>

<tbody>
	@foreach ($results as $resource)
	<tr>
		<td>{{ $resource->user->username }}</td>
		<td>{{ $resource->provider->title }}</td>
		<td>{{ $resource->email }}</td>
		<td class="text-center">{{ $resource->login_count }}</td>
		@include('resource.actions')
	</tr>
	@endforeach
</tbody>
