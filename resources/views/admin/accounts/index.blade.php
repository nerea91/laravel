<thead>
	<tr>
		@if($viewUser)<th>{!! $links->user_id !!}</th>@endif
		@if($viewProvider)<th>{!! $links->provider_id !!}</th>@endif
		<th>{!! $links->email !!}</th>
		<th class="text-center">{!! $links->login_count !!}</th>
		<th class="actions text-center">{{ _('Actions') }}</th>
	</tr>
</thead>

<tbody>
	@foreach ($results as $resource)
	<tr>
		@if($viewUser)<td>{{ $resource->user }}</td>@endif
		@if($viewProvider)<td>{{ $resource->provider }}</td>@endif
		<td>{{ $resource->email }}</td>
		<td class="text-center">{{ $resource->login_count }}</td>
		@include('resource.actions')
	</tr>
	@endforeach
</tbody>
