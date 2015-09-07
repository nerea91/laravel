@extends('layouts.base')

<?php Assets::add('master') ?>

@section('body')

	{{-- OFFCANVAS --}}
	<div class="off-canvas-wrap" data-offcanvas>
		<div class="inner-wrap">

			{{-- Menu toggler for small screens --}}
			<nav class="tab-bar show-for-small">
				<section class="left-small"><a class="left-off-canvas-toggle menu-icon" title="{{ _('Menu') }}"><span>&nbsp;</span></a></section>
				<section class="middle tab-bar-section">{!! link_to_route('home', config('site.name')) !!} <i>{{ $title }}</i></section>
				{{--<section class="right-small"></section>--}}
			</nav>

			{{-- ASIDE --}}
			<aside class="left-off-canvas-menu">
			@section('side')
				@include('home.side')
			@show
			</aside>

			{{-- HEADER --}}
			@section('header')
				@include('home.header')
			@show

			{{-- MAIN CONTENT --}}
			<div id="main" class="row">@yield('main')</div>

			{{-- Close offcanvas after click the main content --}}
			<a class="exit-off-canvas"></a>
		</div><!--.inner-wrap-->
	</div><!--.off-canvas-wrap-->
	{{-- END OFFCANVAS --}}
@stop
