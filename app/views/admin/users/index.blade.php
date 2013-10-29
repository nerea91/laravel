<thead>
	<tr>
		<th>{{ $labels->username }}</th>
		<th>{{ $labels->profile_id }}</th>
		<th>{{ $labels->country_id }}</th>

		@if ($edit or $delete)
		<th class="actions text-center">{{ _('Actions') }}</th>
		@endif

	</tr>
</thead>

<tbody>
	@foreach ($results as $resource)
	<tr>
		<td>{{ $resource->username }}</td>
		<td>{{ $resource->profile->name }}</td>
		<td>{{ (isset($resource->country->name)) ? $resource->country->name : null }}</td>

		@if ($edit or $delete)
		<td class="actions">
			{{ link_to_route("$prefix.show", _('Details'), array($resource->id), array('class' => 'small secondary radius button')) }}

			@if ($edit)
			{{ link_to_route("$prefix.edit", _('Edit'), array($resource->id), array('class' => 'small radius button')) }}
			@endif

			@if ($delete)
			{{ link_to_route("$prefix.destroy", _('Delete'), array($resource->id), array('class' => 'small alert radius button toggle-delete-modal', 'title' => e(sprintf(_('Delete %s'), $resource->username)))) }}
			@endif
		</td>
		@endif
	</tr>
	@endforeach
</tbody>
