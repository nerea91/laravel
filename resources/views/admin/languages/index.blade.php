<thead>
	<tr>
		<th>{!! $links->name !!}</th>
		<th class="text-center">{!! $links->code !!}</th>
		<th class="text-center">{{ _('Default') }}</th>
		@if($viewUser)<th class="text-center">{{ _('Users') }}</th>@endif
		<th class="actions text-center">{{ _('Actions') }}</th>
	</tr>
</thead>

<tbody>
	@foreach ($results as $resource)
	<tr>
		<td>{{ $resource->english_name }}</td>
		<td class="text-center">{{ $resource->code }}</td>
		<td class="text-center">{{ $resource->is_default ? _('Yes') : _('No') }}</td>
		@if ($viewUser)<td class="text-center">{{ $resource->users->count() }}</td>@endif
		@include('resource.actions')
	</tr>
	@endforeach
</tbody>
