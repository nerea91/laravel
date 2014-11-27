<thead>
	<tr>
		<th>{!! $links->title !!}</th> --}}
		{{-- to-do @ if($viewProfile)<th class="text-center">{ { _('Profiles') } }</th>@ endif --}}
		<th class="actions text-center">{{ _('Actions') }}</th>
	</tr>
</thead>

<tbody>
	@foreach ($results as $resource)
	<tr>
		<td>{{ $resource->title }}</td>
		{{-- to-do @ if($viewProfile)<td class="text-center">{ { $resource->profiles->count() } }</td>@ endif --}}
		@include('resource.actions')
	</tr>
	@endforeach
</tbody>
