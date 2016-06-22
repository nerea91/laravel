<!DOCTYPE html>
<!--[if IE 9]><html class="lt-ie10" lang="{{ $appLanguage->code }}" ><![endif]-->
<html class="no-js" lang="{{ $appLanguage->code }}">
	<head>
		{{-- Current page info --}}
		<title>{{ $title }} | {{ config('site.name') }}</title>
		<meta name="description" content="@yield('description')" />

		{{-- Authors info --}}
		<meta name="author" content="Nerea" />{{-- TODO set your name --}}
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

		{{-- Multilanguage --}}
		@foreach ($allLanguages as $l)
		<link rel="alternate" hreflang="{{ $l->code }}" href="{{ $l->url }}" />
		@endforeach

		{{-- Favicon  --}}
		<link rel="icon" href="favicon.ico" type="image/x-icon" />

		{{-- CSS  --}}
		{!! Assets::css() !!}
		@yield('css')
	</head>
	<body>
		@yield('body')

		{{-- JavaScript  --}}
		{!! Assets::js() !!}
		@yield('js')

		{{-- Debugbar --}}
		{!! $debugbar or null !!}
	</body>
</html>
