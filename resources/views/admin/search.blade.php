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

		{{-- If more than 1 kind of result show nav bar --}}
		@if (count($search_results) > 1)
		<div data-magellan-expedition="fixed" data-options="destination_threshold:110">
			<dl class="sub-nav">
				@foreach ($search_results as $model => $results)
				<dd data-magellan-arrival="{{ $model }}"><a href="#{{ $model }}">{{ $results->label }}</a></dd>
				@endforeach
			</dl>
		</div>
		@endif

		@foreach ($search_results as $model => $results)
		<a name="{{ $model }}"></a>
		<div class="panel" data-magellan-destination="{{ $model }}">
			<ul class="small-block-grid-2 medium-block-grid-3 large-block-grid-4">
				<li><h4>{{ $results->label }}</h4></li>
				@foreach ($results->collection as $model)
				<li>{{ link_to_route($results->route, $model, array($model->getKey())) }}</li>
				@endforeach
			</ul>
		</div>
		@endforeach
	@endif

</div>
@stop
