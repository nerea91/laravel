<thead>
	<tr>
		<th>{{ $labels->name }}</th>
		<th class="text-center">{{ $labels->code }}</th>
		<th class="text-center">{{ _('Users') }}</th>
		<th class="text-center">{{ _('Default') }}</th>
		<th class="actions text-center">{{ _('Actions') }}</th>
	</tr>
</thead>

<tbody>
	@foreach ($results as $resource)
	<tr>
		<td>{{ $resource->english_name }}</td>
		<td class="text-center">{{ $resource->code }}</td>
		<td class="text-center">{{ $resource->users->count() }}</td>
		<td class="text-center">{{ $resource->is_default ? _('Yes') : _('No') }}</td>
		@include('resource.actions')
	</tr>
	@endforeach
</tbody>
