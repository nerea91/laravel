@extends('layouts.base')

<?php Assets::add('admin') ?>

@section('body')

	<div class="fixed contain-to-grid">@include('admin/top-bar')</div>

	<div class="row">
		<h1>{!! $title !!}</h1>
		{!! $body !!}
	</div>

@stop
