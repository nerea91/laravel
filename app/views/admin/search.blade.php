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
	@if (isset($searchResults) and $searchResults)
		@foreach ($searchResults as $model => $collection)
			<h3>{{ $model }}</h3>
			<ul class="small-block-grid-2 medium-block-grid-3 large-block-grid-4">
				@foreach ($collection as $model)
				<li>{{$model}}</li>
				@endforeach
			</ul>
		@endforeach
	@endif

</div>
@stop

