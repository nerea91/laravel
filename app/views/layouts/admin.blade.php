@extends('layouts.base')

<?php Assets::add('admin') ?>

@section('body')

<div class="fixed contain-to-grid">
@include('admin/top-bar')
</div>

<div class="row">

	@if (Session::has('success'))
	<div class="flash-alert alert-box success radius" data-alert>
		{{ Session::get('success') }}
		<a class="close">&times;</a>
	</div>
	@endif

	@if (Session::has('error'))
	<div class="flash-alert alert-box alert radius" data-alert>
		{{ Session::get('error') }}
		<a class="close">&times;</a>
	</div>
	@endif

	<h3 class="text-center">{{ $title }} <small>{{ $subtitle }}</small></h3>

	@yield('main')

</div>
@stop
