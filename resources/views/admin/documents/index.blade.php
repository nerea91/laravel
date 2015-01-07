<thead>
	<tr>
		<th>{!! $links->title !!}</th>
		@if($viewProfile)<th class="text-center">{{ _('Profiles') }}</th>@endif
		<th class="actions text-center">{{ _('Actions') }}</th>
	</tr>
</thead>

<tbody>
	@foreach ($results as $resource)
	<tr>
		<td>{{ $resource->title }}</td>
		@if($viewProfile)
		<td class="text-center">
			@if ($count = $resource->profiles->count())
				<span class="has-tip" title="{{ $resource->profiles->sortBy('name')->implode('name', ', ') }}" data-tooltip>{{ $count }}</span>
			@else
				{{ $count }}
			@endif
		</td>
		@endif
		@include('resource.actions')
	</tr>
	@endforeach
</tbody>
