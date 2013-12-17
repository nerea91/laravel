<thead>
	<tr>
		<th class="text-center">{{ $labels->code }}</th>
		<th>{{ $labels->name }}</th>
		<th>{{ _('Sample') }}</th>
		<th class="actions text-center">{{ _('Actions') }}</th>
	</tr>
</thead>

<tbody>
	@foreach ($results as $resource)
	<tr>
		<td class="text-center">{{ $resource->code }}</td>
		<td>{{ $resource->name }}</td>
		<td class="text-right">{{ $resource->format(1234.56) }}</td>
		@include('resource.actions')
	</tr>
	@endforeach
</tbody>