<thead>
	<tr>
		<th class="actions text-center">{{ $links->username }}</th>
		<th>{{ $links->name }}</th>
		<th>{{ $links->profile_id }}</th>
		<th>{{ $links->country_id }}</th>
		<th class="actions text-center">{{ _('Actions') }}</th>
	</tr>
</thead>

<tbody>
	@foreach ($results as $resource)
	<tr>
		<td class="actions text-center">
			@if (strlen($resource->description))
			<span data-tooltip class="has-tip" title="{{ $resource->description }}">{{ $resource->username }}</span>
			@else
			{{ $resource->username }}
			@endif
		</td>
		<td>{{ $resource->name }}</td>
		<td>{{ $resource->profile->name }}</td>
		<td>{{ (isset($resource->country->name)) ? $resource->country->name : null }}</td>
		@include('resource.actions')
	</tr>
	@endforeach
</tbody>
