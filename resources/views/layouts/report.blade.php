@extends('layouts.base')

@section('body')

	{{-- TOP BAR --}}
	<div class="fixed contain-to-grid-DISABLED">@include('reports.top-bar')</div>

	{{-- OFFCANVAS --}}
	<div id="report" class="off-canvas-wrapper {{ $offCanvasClass }}">
		<div class="off-canvas-wrapper-inner" data-off-canvas-wrapper>

			{{-- REPORT HEADER --}}

			
			<div class="title-bar">
				<div class="title-bar-left">
					<button class="menu-icon" type="button" data-open="offCanvasLeft">&nbsp;</button>
					<span class="title-bar-title">{{ _('Report') }} <small style="font-size:.9em">{{ $title }}</small></span>
				</div>
			</div>
			

			{{-- FORM --}}
			<div class="off-canvas position-left" id="offCanvasLeft" data-off-canvas>
				{!! Form::open(['route' => $action, 'class' => 'dontDisable']) !!}
					@yield('form')
					{!! Form::submit(_('Submit'), ['class' => 'button expanded']) !!}
				{!! Form::close() !!}
			</div>

			{{-- REPORT RESULTS --}}
			<div class="off-canvas-content" style="height: 896px;" data-off-canvas-content>

				<br/>

				@if ($errors->any() or ! $results)
				<div class="row">
					<div class="small-12 medium-10 large-8 columns">

						@if ($errors->any())
							<div data-alert class="alert-box alert callout" data-closable>{{ ('Please fix form errors') }}{{--<a class="close">&times;</a>--}}</div>
						@else
							<div data-alert class="alert-box secondary">{{ _('No results found') }}. {{ _('Try with different form values') }}.{{--<a class="close">&times;</a>--}}</div>
						@endif

					</div>
				</div>
				@endif

				@yield('results')

			</div>

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
