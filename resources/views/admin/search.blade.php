@section('main')
@if ($models)
	<div class="row">
		<div class="small-11 small-centered large-6 large-centered columns">

			{!! Form::open(['route' => 'admin.search']) !!}

				{!! Form::checkboxes($f = 'sections', $models, array_keys($models), ['legend' => _('Search in')]) !!}
				@if($errors->has($f))<small class="error">{{ $errors->first($f) }}</small>@endif

				<div class="row collapse">
					<div class="small-7 columns">
						{!! Form::text('query', null, ['autofocus', 'autocomplete' => 'off']) !!}
					</div>
					<div class="small-5 columns">
						{!! Form::submit(_('Search'), ['class' => 'button postfix']) !!}
					</div>
				</div>

			{!! Form::close() !!}
		</div>

		{{-- Show search results --}}
		@if ($searchResults)

			{{-- If more than 1 kind of result show nav bar --}}
			@if (count($searchResults) > 1)
			<div data-magellan-expedition="fixed" data-options="destination_threshold:110">
				<dl class="sub-nav">
					@foreach ($searchResults as $model => $results)
					<dd data-magellan-arrival="{{ $model }}"><a href="/admin#{{ $model }}">{{ $results->label }} ({{ $results->collection->count() }})</a></dd>
					@endforeach
				</dl>
			</div>
			@endif

			@foreach ($searchResults as $model => $results)
			<a name="{{ $model }}"></a>
			<div class="panel" data-magellan-destination="{{ $model }}">
				<ul class="small-block-grid-2 medium-block-grid-3 large-block-grid-4">
					<li><h4>{{ $results->label }}</h4></li>
					@foreach ($results->collection as $model)
					<li>{!! link_to_route($results->route, $model, array($model->getKey())) !!}</li>
					@endforeach
				</ul>
			</div>
			@endforeach
		@endif

	</div>
@endif
@stop
