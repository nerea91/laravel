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
			@if ($count = $resource->users->count())
				<span class="has-tip" title="{{ $resource->users->sortBy('username')->implode('username', ', ') }}" data-tooltip>{{ $count }}</span>
			@else
				{{ $count }}
			@endif
		</td>
		@include('resource.actions')
	</tr>
	@endforeach
</tbody>



