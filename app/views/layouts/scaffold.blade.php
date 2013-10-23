@extends('layouts.base')

@section('body')

<div class="row">

	<h3>{{ $title }}</h3>

	@if (Session::has('message'))
	<div class="alert-box alert radius">
		{{ Session::get('message') }}
	</div>
	@endif

	@yield('main')

</div>
@stop
