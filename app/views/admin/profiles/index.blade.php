<thead>
	<tr>
		<th>{{ $labels->name }}</th>
		<th>{{ $labels->description }}</th>
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
			@if ($resource->users->count())
			<span data-tooltip class="has-tip" title="{{ implode(', ', $resource->users->lists('username')) }}">
			{{ $resource->users->count() }}
			</span>
			@endif
		</td>
		@include('resource.actions')
	</tr>
	@endforeach
</tbody>
