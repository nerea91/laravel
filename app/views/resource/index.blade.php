@section('main')
@if ( ! $results->count())
	<p class="text-center">{{ _('No results found') }}.</p>
@else

	@if ($results->getLastPage() > 1)
	<p class="caption">{{ sprintf(_('From %d to %d out of %d'), $results->getFrom(), $results->getTo(), $results->getTotal()) }}.</p>
	@endif

	<table class="hover responsive">
	@include("$prefix.index")
	</table>

	{{ $results->appends(Input::only('sortby', 'sortdir'))->links() }}

	@if ($delete)
	@include('resource.delete')
	@endif
@endif

<p class="text-center">
	{{ link_to_route($return, _('Return'), null, ['class' => 'secondary button']) }}

	@if ($add)
	&nbsp;{{ link_to_route("$prefix.create", _('Create'), null, ['class' => 'success button']) }}
	@endif
</p>
@stop
