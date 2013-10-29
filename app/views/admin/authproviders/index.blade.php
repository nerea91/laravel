<thead>
	<tr>
		<th>{{ $labels->name }}</th>
		<th class="text-center">{{ $labels->login_count }}</th>

		@if ($edit or $delete)
		<th class="actions text-center">{{ _('Actions') }}</th>
		@endif

	</tr>
</thead>

<tbody>
	@foreach ($results as $resource)
	<tr>
		<td>{{ $resource->title }}</td>
		<td class="text-center">{{ intval($resource->login_count) }}</td>

		@if ($edit or $delete)
		<td class="actions">
			{{ link_to_route("$prefix.show", _('Details'), array($resource->id), array('class' => 'small secondary radius button')) }}

			@if ($edit)
			{{ link_to_route("$prefix.edit", _('Edit'), array($resource->id), array('class' => 'small radius button')) }}
			@endif

			@if ($delete)
			{{ link_to_route("$prefix.destroy", _('Delete'), array($resource->id), array('class' => 'small alert radius button toggle-delete-modal', 'title' => e(sprintf(_('Delete %s'), $resource->title)))) }}
			@endif
		</td>
		@endif
	</tr>
	@endforeach
</tbody>
