@extends('layouts.base')

<?php Assets::add(['offcanvas', 'admin.css']) ?>

@section('body')

	{{-- TOP BAR --}}
	<div class="fixed contain-to-grid-DISABLED">@include('reports.top-bar')</div>

	{{-- OFFCANVAS --}}
	<div id="report" class="off-canvas-wrap {{ $offCanvasClass }}" data-offcanvas>
		<div class="inner-wrap">

			{{-- REPORT HEADER --}}
			<nav class="tab-bar">
				<section class="left-small">
					<a id="off-canvas-toggle" class="left-off-canvas-toggle menu-icon" ><span>&nbsp;</span></a>
				</section>
				<section class="middle tab-bar-section">
					<h1 class="title">{{ _('Report') }} <small style="font-size:.9em">{{ $title }}</small></h1>
				</section>
			</nav>

			{{-- FORM --}}
			<aside class="left-off-canvas-menu">
				{!! Form::open(['route' => $action, 'class' => 'dontDisable']) !!}
					@yield('form')
					{!! Form::submit(_('Submit'), ['class' => 'button expand']) !!}
				{!! Form::close() !!}
			</aside>

			{{-- REPORT RESULTS --}}
			<section id="main">

				<br/>

				@if ($errors->any() or ! $results)
				<div class="row">
					<div class="small-12 medium-10 large-8 columns">

						@if ($errors->any())
							<div data-alert class="alert-box alert">{{ ('Please fix form errors') }}{{--<a class="close">&times;</a>--}}</div>
						@else
							<div data-alert class="alert-box secondary">{{ _('No results found') }}. {{ _('Try with different form values') }}.{{--<a class="close">&times;</a>--}}</div>
						@endif

					</div>
				</div>
				@endif

				@yield('results')

			</section>

			{{-- Close offcanvas after click the main content --}}
			<a class="exit-off-canvas"></a>
		</div><!--.inner-wrap-->
	</div><!--.off-canvas-wrap-->
	{{-- END OFFCANVAS --}}

@stop


@section('js')
<script>
$(document).ready(function() {

	{{-- Toggle canvas if no results or errors --}}
	@if($errors->any() or ! $results)
	$('#report').toggleClass('move-right');
	@endif

});
</script>
@stop
