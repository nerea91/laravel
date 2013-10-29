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

	{{ $results->links() }}

	@if ($delete)
	@include('admin.delete')
	@endif
@endif

<p class="text-center">
@if ($add)
	{{ link_to_route("$prefix.create", _('Add new'), null, ['class' => 'small radius button']) }}&nbsp;
@endif
{{ link_to_route('admin', _('Return'), null, ['class' => 'small secondary radius button']) }}
</p>
@stop
