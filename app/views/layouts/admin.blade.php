@extends('layouts.base')

<?php Assets::add('admin') ?>

@section('body')

<div class="row">

	@include('admin/top-bar', array('user' => Auth::user()))

	@if (Session::has('success'))
	<div class="flash-alert alert-box success radius">
		{{ Session::get('success') }}
		<a class="close">&times;</a>
	</div>
	@endif

	@if (Session::has('error'))
	<div class="flash-alert alert-box alert radius">
		{{ Session::get('error') }}
		<a class="close">&times;</a>
	</div>
	@endif

	<h3 class="text-center">{{ $title }} <small>{{ $subtitle }}</small></h3>

	@yield('main')

</div>
@stop
