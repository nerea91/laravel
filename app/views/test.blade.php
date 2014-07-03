@extends('layouts.base')

@section('body')
<div id="test">

	<ul class="tabs" data-tab>
		@foreach ($secctions as $key => $value)
		<li class="tab-title {{ ($key === $active) ? 'active' : null }}"><a href="#{{ $key }}">{{ $key }}</a></li>
		@endforeach
	</ul>

	<div class="tabs-content">
		@foreach ($secctions as $key => $value)
		<div class="content {{ ($key === $active) ? 'active' : null }}" id="{{ $key }}">
			{{ p($value) }}
		</div>
		@endforeach
	</div>

</div>
@stop

@section('css')
<style>
#test {
	margin:auto;
	width:90%;
}
code {
	font-size:89%;
	font-weight:normal !important;
}
</style>
@stop
