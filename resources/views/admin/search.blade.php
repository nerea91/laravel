@section('main')
@if ($models)
	<div class="row">
		<div class="small-11 small-centered large-6 large-centered columns">

			{!! Form::open(['route' => 'admin.search']) !!}

				{!! checkboxes($f = 'sections', $models, array_keys($models), ['legend' => _('Search in')]) !!}
				@if($errors->has($f))<small class="error">{{ $errors->first($f) }}</small>@endif

				<div class="row collapse">
					<div class="small-7 columns">
						{!! Form::text('query', null, ['autofocus', 'autocomplete' => 'off']) !!}
					</div>
					<div class="small-5 columns">
						{!! Form::submit(_('Search'), ['class' => 'button postfix expanded']) !!}
					</div>
				</div>

			{!! Form::close() !!}
		</div>

		{{-- Show search results --}}
		@if ($searchResults)

			{{-- If more than 1 kind of result show nav bar --}}
			@if (count($searchResults) > 1)
			<div data-sticky-container>
				<div class="sticky" id="example" data-sticky data-margin-top="0" style="width:70%;" data-margin-bottom="0" data-top-anchor="topAnchorExample" data-btm-anchor="bottomOfContentId:bottom">
					<nav data-magellan>
					<ul class="horizontal menu expanded">
						@foreach ($searchResults as $model => $results)
						<li><a href="/admin#{{ $model }}">{{ $results->label }} ({{ $results->collection->count() }})</a></li>
						@endforeach
					</ul>
					</nav>
				</div>
			</div><br><br><br><br><br>
			@endif

			<div class="sections">
				@foreach ($searchResults as $model => $results)
					<section class="panel" id="{{ $model }}" data-magellan-target="{{ $model }}">
						<div class="row small-up-2 medium-up-3 large-up-4">
							<div class="column"><h4>{{ $results->label }}</h4></div>
							@foreach ($results->collection as $model)
								<div class="column">{!! link_to_route($results->route, $model, array($model->getKey())) !!}</div>
							@endforeach
						</div>
					</section>
				@endforeach
			</div>
			
		@endif

	</div>
@endif
@stop
