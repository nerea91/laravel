<td class="actions">

	{{-- Soft deleted models have only one action: Restore --}}
	@if ($trashable and $resource->trashed())
	{!!
		link_to_route(
			"$prefix.restore",
			_('Restore'),
			[$resource->getKey()],
			[
				'class' => 'small success radius button expand toggle-confirm-modal',
				'data-toggle' => 'restore-modal',
				'title' => e(sprintf(_('Restore %s'), $resource))
			]
		)
	!!}

	@else

		@if ($view)
			{!! link_to_route("$prefix.show", _('Details'), [$resource->getKey()], ['class' => 'small secondary radius button']) !!}
		@endif

		@if ($edit)
			{!! link_to_route("$prefix.edit", _('Edit'), [$resource->getKey()], ['class' => 'small radius button']) !!}
		@endif

		@if ($delete and $resource->deletable())
		{!!
			link_to_route(
				"$prefix.destroy",
				($trashable) ? _('Disable') : _('Delete'),
				[$resource->getKey()],
				[
					'class' => 'small alert radius button toggle-confirm-modal',
					'data-toggle' => 'delete-modal',
					'title' => e(sprintf(($trashable) ? _('Disable %s') : _('Delete %s'), $resource)),
				]
			)
		!!}
		@endif

	@endif
</td>
