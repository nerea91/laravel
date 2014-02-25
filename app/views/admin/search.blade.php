@section('main')
<div class="row">
	<div class="small-11 small-centered large-6 large-centered columns">

		{{ Form::open(['route' => 'admin.search']) }}

		<div class="row collapse">
			<div class="small-7 columns">
				{{ Form::text('search', null, ['autofocus', 'autocomplete' => 'off']) }}
			</div>
			<div class="small-5 columns">
				{{ Form::submit(_('Search'), ['class' => 'button postfix']) }}
			</div>
		</div>

		{{ Form::close() }}
	</div>

	{{-- Show search results --}}
	@if ($search_results)
		@foreach ($search_results as $model => $results)
		<div class="panel">
			<ul class="small-block-grid-2 medium-block-grid-3 large-block-grid-4">
				<li><h4>{{ $results->label }}</h4></li>
				@foreach ($results->collection as $model)
				<li>{{ link_to_route($results->route, $model, array($model->id)) }}</li>
				@endforeach
			</ul>
		</div>
		@endforeach
	@endif

</div>
@stop

