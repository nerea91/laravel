<thead>
	<tr>
		<th>{{ $labels->english_name }}</th>
		<th class="text-center">{{ $labels->code }}</th>
		<th class="actions text-center">{{ _('Actions') }}</th>
	</tr>
</thead>

<tbody>
	@foreach ($results as $resource)
	<tr>
		<td>{{ $resource->english_name }}</td>
		<td class="text-center">{{ $resource->code }}</td>
		@include('resource.actions')
	</tr>
	@endforeach
</tbody>
