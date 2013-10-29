<thead>
	<tr>
		<th>{{ $labels->name }}</th>
		<th class="text-center">{{ $labels->iso_3166_2 }}</th>

		@if ($edit or $delete)
		<th class="actions text-center">{{ _('Actions') }}</th>
		@endif

	</tr>
</thead>

<tbody>
	@foreach ($results as $resource)
	<tr>
		<td>{{ $resource->name }}</td>
		<td class="text-center">{{ $resource->iso_3166_2 }}</td>

		@if ($edit or $delete)
		<td class="actions">
			{{ link_to_route("$prefix.show", _('Details'), array($resource->id), array('class' => 'small secondary radius button')) }}

			@if ($edit)
			{{ link_to_route("$prefix.edit", _('Edit'), array($resource->id), array('class' => 'small radius button')) }}
			@endif

			@if ($delete)
			{{ link_to_route("$prefix.destroy", _('Delete'), array($resource->id), array('class' => 'small alert radius button toggle-delete-modal', 'title' => e(sprintf(_('Delete %s'), $resource->name)))) }}
			@endif
		</td>
		@endif
	</tr>
	@endforeach
</tbody>
