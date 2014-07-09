<td class="actions">

	{{-- Soft deleted models have only one action: Restore --}}
	@if ($trashable and $resource->trashed())
	{{
		link_to_route(
			"$prefix.restore",
			_('Restore'),
			[$resource->id],
			[
				'class' => 'small success radius button expand toggle-confirm-modal',
				'data-modal' => 'restore-modal',
				'title' => e(sprintf(_('Restore %s'), $resource))
			]
		)
	}}

	@else

		{{ link_to_route("$prefix.show", _('Details'), [$resource->id], ['class' => 'small secondary radius button']) }}

		@if ($edit)
			{{ link_to_route("$prefix.edit", _('Edit'), [$resource->id], ['class' => 'small radius button']) }}
		@endif

		@if ($delete)
		{{
			link_to_route(
				"$prefix.destroy",
				($trashable) ? _('Disable') : _('Delete'),
				[$resource->id],
				[
					'class' => 'small alert radius button toggle-confirm-modal',
					'data-modal' => 'delete-modal',
					'title' => e(sprintf(($trashable) ? _('Disable %s') : _('Delete %s'), $resource))
				]
			)
		}}
		@endif

	@endif
</td>
