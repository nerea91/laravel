<?php
$delete = ($delete and $resource->deletable());
$columns = 12 / (1 + $edit + $delete);
?>

@section('main')
<div class="small-12">
	<div class="small-11 small-centered large-6 large-centered columns">

		@include("$prefix.show")

		<div class="row">
			<div class="large-{{ $columns }} columns">
				{{-- If the referer page has a 'page' parameter redirect to there --}}
				@if (false !== strpos(URL::previous(), '?page=') )
					<a href="{{ URL::previous() }}" class="secondary button expanded">{{ _('Return') }}</a>
				@else
					{!! link_to_route("$prefix.index", _('Return'), [], array('class' => 'secondary button expanded')) !!}
				@endif
			</div>

			@if ($edit)
			<div class="large-{{ $columns }} columns">
				{!! link_to_route("$prefix.edit", _('Edit'), array($resource->getKey()), array('class' => 'button expanded')) !!}
			</div>
			@endif

			@if ($delete)
			<div id="confirmation-modals">
				@include('resource.delete')
			</div>

			<div class="large-{{ $columns }} columns">
				{!!
					link_to_route(
						"$prefix.destroy",
						($trashable) ? _('Disable') : _('Delete'),
						[$resource->getKey()],
						[
							'class' => 'alert button expanded toggle-confirm-modal',
							'data-toggle' => 'delete-modal',
							'title' => e(sprintf(($trashable) ? _('Disable %s') : _('Delete %s'), $resource))
						]
					)
				!!}
			</div>
			@endif
		</div>

	</div>
</div>
@stop
