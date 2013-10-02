@extends('layouts.base')

@section('title')
Scaffolding | @parent
@stop

@section('body')
<div class="container">
	@if (Session::has('message'))
		<div class="flash alert">
			<p>{{ Session::get('message') }}</p>
		</div>
	@endif

	@yield('main')
</div>
@stop


@section('css')
<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.min.css" rel="stylesheet">
@stop


@section('style')
<style>
	table form { margin-bottom: 0; }
	form ul { margin-left: 0; list-style: none; }
	.error { color: red; font-style: italic; }
	body { padding-top: 20px; }
</style>
@stop
