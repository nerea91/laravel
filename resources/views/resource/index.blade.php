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
		<a href="#" data-dropdown="trash-mode" class="dropdown button">{{ _('Filter') }}</a>
		<ul id="trash-mode" class="f-dropdown text-left" data-dropdown-content>
			<li>{!! link_to_route("$prefix.trash.mode", _('Only enabled'), ['normal']) !!}</li>
			<li>{!! link_to_route("$prefix.trash.mode", _('Only deleted'), ['trashed']) !!}</li>
			<li>{!! link_to_route("$prefix.trash.mode", _('All'), ['all']) !!}</li>
		</ul>
		@endif

	</div>
@stop
