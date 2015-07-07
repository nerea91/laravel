@extends('layouts.base')

<?php
$types = ['', 'success', 'warning', 'info', 'alert', 'secondary'];
$sizes = ['tiny', 'small', '', 'large', 'expand'];
$roundness = ['', 'radius', 'round'];
$components = ['top-bar', 'alert', 'form', 'tabs', 'accordion', 'typography', 'button', 'palette', 'pagination', 'block-grid', 'visibility'];
?>

@section('body')

	@include('foundation/' . array_shift($components))

	@foreach ($components as $component)
	<div class="row">
		<h3 class="text-center">{{ ucfirst($component) }}</h3>
		@include("foundation/$component")
		<hr/>
	</div>
	@endforeach

@stop


@section('js')
@parent
<script>
$(document).ready(function() {

	// Disable links for demo purposes
	$('a').click(function (e) {
		if($(this).attr('href') == '#')
			e.preventDefault();});

});
</script>
@stop
