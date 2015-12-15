@section('main')
	@if ( ! $results->count())
		<p class="text-center">{{ _('No results found') }}.</p>
	@else

		<table class="hover responsive">@include("$prefix.index")</table>

		{!! pagination_links($results->appends(Input::only('sortby', 'sortdir'))) !!}

		@if ($delete)
		<div id="confirmation-modals">
			@include('resource.delete')
		</div>
		@endif
	@endif

	<div class="text-center">
		{!! link_to_route($returnRouteName, _('Return'), [], ['class' => 'secondary button']) !!}

		@if ($add)
		&nbsp;{!! link_to_route("$prefix.create", _('Create'), [], ['class' => 'success button']) !!}
		@endif

		@if ($trashable)
		
		<a  data-toggle="trash-mode" class="button dropdown">{{ _('Filter') }}</a>
			<div id="trash-mode" data-dropdown data-auto-focus="true" class="dropdown-pane">
				<div>{!! link_to_route("$prefix.trash.mode", _('Only enabled'), ['normal']) !!}</div>
				<div>{!! link_to_route("$prefix.trash.mode", _('Only deleted'), ['trashed']) !!}</div>
				<div>{!! link_to_route("$prefix.trash.mode", _('All'), ['all']) !!}</div>
			</div>
		@endif

	</div>
@stop
