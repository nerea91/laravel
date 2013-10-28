@extends('layouts.base')

<?php Assets::add('admin') ?>

@section('body')

<div class="row">

	@if (Session::has('success'))
	<div class="alert-box success radius">
		{{ Session::get('success') }}
		<a class="close">&times;</a>
	</div>
	@endif

	<h3 class="text-center">{{ $title }} <small>{{ $subtitle }}</small></h3>

	@yield('main')

</div>
@stop
