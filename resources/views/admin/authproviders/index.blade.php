<thead>
	<tr>
		<th>{!! $links->name !!}</th>
		<th class="text-center">{!! $links->login_count !!}</th>
		@if($viewAccount)<th class="text-center">{{ _('Accounts') }}</th>@endif
		<th class="actions text-center">{{ _('Actions') }}</th>
	</tr>
</thead>

<tbody>
	@foreach ($results as $resource)
	<tr>
		<td>{{ $resource->title }}</td>
		<td class="text-center">{{ intval($resource->login_count) }}</td>
		@if($viewAccount)<td class="text-center">{{ $resource->accounts->count() }}</td>@endif
		@include('resource.actions')
	</tr>
	@endforeach
</tbody>
