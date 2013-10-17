<!DOCTYPE html>
<html class="no-js" lang="{{ Config::get('app.locale', 'en') }}">
	<head>
		{{-- Info --}}
		<title>{{{ $title }}} | {{{ trim(Config::get('site.name')) }}}</title>
		<meta name="description" content="@yield('description')" />

		{{-- About --}}
		<meta name="author" content="Javi (twitter: @Stolz)" />{{-- to-do set your name --}}
		<link type="text/plain" rel="author" href="humans.txt" />

		{{-- Misc --}}
		<base href="/" />
		<meta charset="utf-8">
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />{{-- Force latest IE rendering engine or Chrome Frame if available) --}}

		{{-- Mobile  --}}
		<meta name="viewport" content="width=device-width, initial-scale=1.0">{{-- Webkit. To disable zooming add ", maximum-scale=1.0, user-scalable=no" --}}
		<meta name="HandheldFriendly" content="True" />{{-- BlackBerry --}}
		<meta name="MobileOptimized" content="960" />{{-- Windows Mobile --}}
		<meta http-equiv="cleartype" content="on" />{{-- Windows Mobile --}}

		{{-- Favicon  --}}
		<link rel="icon" href="favicon.ico" type="image/x-icon" />

		{{-- CSS  --}}
		{{ Assets::css() }}
		@yield('css')
	</head>
	<body>
		@yield('body')

		{{-- JavaScript  --}}
		{{ Assets::js() }}
		@yield('js')

		{{-- Google Analytics --}}
		<?php if(Config::has('site.googleanalytics')) : ?>
		<script>
			(function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
			function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
			e=o.createElement(i);r=o.getElementsByTagName(i)[0];
			e.src='//www.google-analytics.com/analytics.js';
			r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
			ga('create','{{Config::get("site.googleanalytics")}}');ga('send','pageview');
		</script>
		<?php endif ?>
	</body>
</html>
