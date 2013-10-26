@section('main')
@if ( ! $results->count())
	<p class="text-center">{{ _('There are no countries') }}.</p>
@else
	<table class="hover">

		@if ($results->getLastPage() > 1)
		<caption>{{ sprintf(_('From %d to %d out of %d'), $results->getFrom(), $results->getTo(), $results->getTotal()) }}.</caption>
		@endif

		<thead>
			<tr>
				@foreach ($labels as $field => $label)
				<th>{{ $label }}</th>
				@endforeach

				@if ($edit or $delete)
				<th class="actions">{{ _('Actions') }}</th>
				@endif

			</tr>
		</thead>

		<tbody>
			@foreach ($results as $resource)
			<tr>
			<td>{{ link_to_route("$prefix.show", $resource->name, array($resource->id)) }}</td>
				@foreach (array_except($labels, ['name']) as $field => $label)
				<td>{{{ $resource->{$field} }}}</td>
				@endforeach
				@if ($edit or $delete)
				<td class="actions">
					@if ($edit)
					{{ link_to_route("$prefix.edit",    _('Edit'),   array($resource->id), array('class' => 'small radius button')) }}
					@endif

					@if ($delete)
					{{ link_to_route("$prefix.destroy", _('Delete'), array($resource->id), array('class' => 'small alert radius button toggle-delete-modal', 'title' => e(sprintf(_('Delete %s'), $resource->name)))) }}
					@endif
				</td>
				@endif
			</tr>
			@endforeach
		</tbody>
	</table>

	{{ $results->links() }}

	@if ($edit or $delete)
		@include('admin.index')
	@endif
@endif
@if ($add)
	<p class="text-center">{{ link_to_route("$prefix.create", _('Add new'), null, ['class' => 'small radius button']) }}</p>
@endif
@stop
