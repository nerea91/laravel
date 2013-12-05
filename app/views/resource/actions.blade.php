<td class="actions">
	{{ link_to_route("$prefix.show", _('Details'), array($resource->id), array('class' => 'small secondary radius button')) }}

	@if ($edit)
	{{ link_to_route("$prefix.edit", _('Edit'), array($resource->id), array('class' => 'small radius button')) }}
	@endif

	@if ($delete)
	{{ link_to_route("$prefix.destroy", _('Delete'), array($resource->id), array('class' => 'small alert radius button toggle-delete-modal', 'title' => e(sprintf(_('Delete %s'), $resource)))) }}
	@endif
</td>

