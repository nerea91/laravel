<thead>
	<tr>
		<th>{{ $links->name }}</th>
		<th>{{ $links->description }}</th>
		@if ($viewUser)<th class="text-center">{{ _('Users') }}</th>@endif
		<th class="actions text-center">{{ _('Actions') }}</th>
	</tr>
</thead>

<tbody>
	@foreach ($results as $resource)
	<tr>
		<td>{{ $resource->name }}</td>
		<td>{{ $resource->description }}</td>
		@if ($viewUser)
		<td class="text-center">
			@if ($count = $resource->users->count())
				<span class="has-tip" title="{{ $resource->users->sortBy('username')->implode('username', ', ') }}" data-tooltip>{{ $count }}</span>
			@else
				{{ $count }}
			@endif
		</td>
		@endif
		@include('resource.actions')
	</tr>
	@endforeach
</tbody>



