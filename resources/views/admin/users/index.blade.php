<thead>
	<tr>
		<th class="actions text-center">{!! $links->username !!}</th>
		<th>{!! $links->name !!}</th>
		@if($viewProfile)<th>{!! $links->profile_id !!}</th>@endif
		@if($viewCountry)<th>{!! $links->country_id !!}</th>@endif
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
		@if($viewProfile)<td>{{ $resource->profile }}</td>@endif
		@if($viewCountry)<td>{{ $resource->country }}</td>@endif
		@include('resource.actions')
	</tr>
	@endforeach
</tbody>
