@extends('layouts.base')

@section('body')
	{{-- OFFCANVAS --}}
	<div class="off-canvas-wrapper">
		<div class="off-canvas-wrapper-inner" data-off-canvas-wrapper>

			{{-- Menu toggler for small screens --}}
			<!--<nav class="tab-bar show-for-small-only">
				<section class="left-small"><a class="left-off-canvas-toggle menu-icon" title="{{ _('Menu') }}"><span>&nbsp;</span></a></section>
				<section class="middle tab-bar-section">{!! link_to_route('home', config('site.name')) !!} <i>{{ $title }}</i></section>
				{{--<section class="right-small"></section>--}}
			</nav>-->
			<div class="off-canvas position-left" id="offCanvasLeft" data-off-canvas>
			 @section('side')
				@include('home.side')
			 @show
			</div>
			
			<div class="title-bar show-for-small-only">
			  <div class="title-bar-left">
			    <button class="menu-icon" type="button" data-open="offCanvasLeft">&nbsp;</button>
			    <span class="title-bar-title">{!! link_to_route('home', config('site.name')) !!} <i>{{ $title }}</i></span>
			  </div>
			</div>

			{{-- ASIDE --}}
			<!--<aside class="left-off-canvas-menu">
			@section('side')
				@include('home.side')
			@show
			</aside>-->

			{{-- HEADER --}}
			@section('header')
				@include('home.header')
			@show

			{{-- MAIN CONTENT --}}
			<div id="main" class="row off-canvas-content" style="box-shadow:none" data-off-canvas-content>@yield('main')</div>

			{{-- Close offcanvas after click the main content --}}
			<a class="exit-off-canvas"></a>
		</div><!--.inner-wrap-->
	</div><!--.off-canvas-wrap-->
	{{-- END OFFCANVAS --}}
@stop
