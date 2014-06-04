<thead>
	<tr>
		<th class="text-center">{{ $links->code }}</th>
		<th>{{ $links->name }}</th>
		<th>{{ _('Sample') }}</th>
		<th class="actions text-center">{{ _('Actions') }}</th>
	</tr>
</thead>

<tbody>
	@foreach ($results as $resource)
	<tr>
		<td class="text-center">{{ $resource->code }}</td>
		<td>{{ $resource->name }}</td>
		<td class="text-right"><span class="currency">{{{ $resource->format(1234.56) }}}</span></td>
		@include('resource.actions')
	</tr>
	@endforeach
</tbody>
