<thead>
	<tr>
		<th>{{ $links->name }}</th>
		<th class="text-center">{{ $links->iso_3166_2 }}</th>
		@if($viewUser)<th class="text-center">{{ _('Users') }}</th>@endif
		<th class="actions text-center">{{ _('Actions') }}</th>
	</tr>
</thead>

<tbody>
	@foreach ($results as $resource)
	<tr>
		<td>{{ $resource->name }}</td>
		<td class="text-center">{{ $resource->iso_3166_2 }}</td>
		@if ($viewUser)<td class="text-center">{{ $resource->users->count() }}</td>@endif
		@include('resource.actions')
	</tr>
	@endforeach
</tbody>
