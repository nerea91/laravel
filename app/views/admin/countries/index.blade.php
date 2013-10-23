@section('main')
@if ( ! $resources->count())
	<p class="text-center">{{ _('There are no countries') }}.</p>
@else
	<table class="hover">

		@if ($resources->getLastPage() > 1)
		<caption>{{ sprintf(_('From %d to %d out of %d'), $resources->getFrom(), $resources->getTo(), $resources->getTotal()) }}.</caption>
		@endif

		<thead>
			<tr>
				<th>{{ _('Name') }}</th>
				<th>{{ _('Description') }}</th>
				<th>{{ _('Actions') }}</th>
			</tr>
		</thead>

		<tbody>
			@foreach ($resources as $resource)
				<tr>
					<td>{{{ $resource->name }}}</td>
					<td>{{{ $resource->description }}}</td>
					<td>
						<ul class="button-group even-2 radius">
							<li>{{ link_to_route("$prefix.edit",    _('Edit'),   array($resource->id), array('class' => 'small button')) }}</li>
							<li>{{ link_to_route("$prefix.destroy", _('Delete'), array($resource->id), array('class' => 'small alert button toggle-delete-modal', 'title' => e(sprintf(_('Delete %s'), $resource->name)))) }}</li>
						</ul>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>

	{{ $resources->links() }}

	@include('admin.index')
@endif
<p class="text-center">{{ link_to_route("$prefix.create", _('Add new'), null, ['class' => 'small radius button']) }}</p>
@stop
