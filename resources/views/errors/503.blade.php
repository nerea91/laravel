@extends('layouts.base')

<?php
	session('language')->apply();
	Assets::add('master');
?>

@section('body')
<div class="row text-center">

	<div class="medium-9 medium-centered large-centered columns">
		<h1>{{ config('site.name') }}</h1>
		<div class="panel callout radius">

			<h2>{{ _('Site down for maintenance') }}.</h2>

			<hr/>

			<p><i>{{ _('Sorry, our site is currently undergoing scheduled maintenance') }}.</i></p>

			<p>{{ _('Please visit us again in a few minutes') }}.</p>

		</div>
	</div>

</div>
@stop

@section('css')
<style>
h1{margin:.8em 0;}
.panel{
	box-shadow: 2px 2px 10px #999 !important;
}
</style>
@stop
