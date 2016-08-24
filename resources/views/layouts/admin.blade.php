@extends('layouts.base')

@section('body')

	<div class="fixed contain-to-grid">@include('admin/top-bar')</div>

	<div class="row">
		{{-- Flash errors --}}
		@foreach (['error' => 'alert', 'success' => 'success', 'info' => '', 'secondary' => 'secondary'] as $flashMessage => $boxClass)
			@if (Session::has($flashMessage))
			<div class="flash-alert radius {{ $boxClass }} callout" data-closable >
				{{ Session::get($flashMessage) }}
				<button class="close-button" aria-label="Dismiss alert" type="button" data-close>
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			@endif
		@endforeach

		<h3 class="text-center">{{ $title }} <small>{{ $subtitle }}</small></h3>

		@yield('main')

	</div>
@stop
