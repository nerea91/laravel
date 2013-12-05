<thead>
	<tr>
		<th>{{ $labels->name }}</th>
		<th class="text-center">{{ $labels->login_count }}</th>
		<th class="actions text-center">{{ _('Actions') }}</th>
	</tr>
</thead>

<tbody>
	@foreach ($results as $resource)
	<tr>
		<td>{{ $resource->title }}</td>
		<td class="text-center">{{ intval($resource->login_count) }}</td>
		@include('resource.actions')
	</tr>
	@endforeach
</tbody>
