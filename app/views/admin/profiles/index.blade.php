<thead>
	<tr>
		<th>{{ $labels->name }}</th>
		<th>{{ $labels->description }}</th>
		<th class="actions text-center">{{ _('Actions') }}</th>
	</tr>
</thead>

<tbody>
	@foreach ($results as $resource)
	<tr>
		<td>{{ $resource->name }}</td>
		<td>{{ $resource->description }}</td>
		@include('resource.actions')
	</tr>
	@endforeach
</tbody>
