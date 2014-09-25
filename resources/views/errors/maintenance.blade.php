@extends('layouts.base')

@section('body')
<div class="row">
	<div class="large-7 columns large-centered text-center">
		<h2>{{ config('site.name') }}</h2>
		<div class="panel callout radius">

			<h5>{{ _('Site down for maintenance') }}.</h5>
			<p><i>{{ _('Sorry, our site is currently undergoing scheduled maintenance') }}.</i></p>

			<p>{{ _('Please visit us again in a few minutes') }}.</p>

		</div>
	</div>
</div>
@stop

@section('css')
<style>
h5{margin-bottom:2em !important}
.panel{
	font-size:120%;
	box-shadow: 2px 2px 10px #999 !important;
}
</style>
@stop
