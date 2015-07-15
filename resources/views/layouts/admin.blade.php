@extends('layouts.base')

<?php Assets::add('admin') ?>

@section('body')

	<div class="fixed contain-to-grid">@include('admin/top-bar')</div>

	<div class="row">

		{{-- Flash errors --}}
		@foreach (['error' => 'alert', 'success' => 'success', 'info' => '', 'secondary' => 'secondary'] as $flashMessage => $boxClass)
			@if (Session::has($flashMessage))
			<div class="flash-alert alert-box {{ $boxClass }} radius" data-alert>
				{{ Session::get($flashMessage) }}
				<a class="close">&times;</a>
			</div>
			@endif
		@endforeach

		<h3 class="text-center">{{ $title }} <small>{{ $subtitle }}</small></h3>

		@yield('main')

	</div>
@stop
