<td class="actions">
	{{ link_to_route("$prefix.show", _('Details'), array($resource->id), array('class' => 'small secondary radius button')) }}

	@if ($edit)
	{{ link_to_route("$prefix.edit", _('Edit'), array($resource->id), array('class' => 'small radius button')) }}
	@endif

	@if ($delete)
		@if ($resource->deleted_at) {{-- $resource->trashed() is not always available --}}
			{{ link_to_route("$prefix.restore", _('Restore'), array($resource->id), array('class' => 'small success radius button toggle-confirm-modal', 'data-modal' => 'restore-modal', 'title' => e(sprintf(_('Restore %s'), $resource)))) }}
		@else
			{{ link_to_route("$prefix.destroy", _('Delete'),  array($resource->id), array('class' => 'small alert   radius button toggle-confirm-modal', 'data-modal' => 'delete-modal',  'title' => e(sprintf(_('Delete %s'),  $resource)))) }}
		@endif
	@endif
</td>
