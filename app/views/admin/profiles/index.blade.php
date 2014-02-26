<thead>
	<tr>
		<th>{{ $links->name }}</th>
		<th>{{ $links->description }}</th>
		<th class="text-center">{{ _('Users') }}</th>
		<th class="actions text-center">{{ _('Actions') }}</th>
	</tr>
</thead>

<tbody>
	@foreach ($results as $resource)
	<tr>
		<td>{{ $resource->name }}</td>
		<td>{{ $resource->description }}</td>
		<td class="text-center">
			@if ($users = $resource->getUsernamesArray())
			<span class="has-tip" title="{{ implode(', ', $users) }}" data-tooltip>
			{{ count($users) }}
			</span>
			@endif
		</td>
		@include('resource.actions')
	</tr>
	@endforeach
</tbody>
