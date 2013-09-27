<!DOCTYPE html>
<html class="no-js" lang="<?= Config::get('app.locale')?>">
	<head>
		<!--Info-->
		<title>@yield('title')</title>
		<meta name="description" content="@yield('description')" />

		<!--About-->
		<meta name="author" content="Javi (twitter: @Stolz)" /><!--to-do set your name-->
		<link type="text/plain" rel="author" href="humans.txt" />

		<!--Misc-->
		<base href="to-do" />
		<meta charset="utf-8">
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" /><!--Force latest IE rendering engine or Chrome Frame if available)-->

		<!-- Mobile -->
		<meta name="viewport" content="width=device-width, initial-scale=1"><!--Webkit-->
		<meta name="HandheldFriendly" content="True" /><!--BlackBerry-->
		<meta name="MobileOptimized" content="960" /><!--Windows Mobile-->
		<meta http-equiv="cleartype" content="on" /><!--Windows Mobile-->

		<!-- Favicon -->
		<link rel="icon" href="favicon.ico" type="image/x-icon" />

		<!-- CSS -->
		@yield('css')
	</head>
	<body>
		@yield('body')

		<!-- JavaScript -->
		@yield('javascript')

		<!-- Google Analytics: to-do change UA-XXXXX-X to be your site's ID. -->
		<script>
			(function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
			function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
			e=o.createElement(i);r=o.getElementsByTagName(i)[0];
			e.src='//www.google-analytics.com/analytics.js';
			r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
			ga('create','UA-XXXXX-X');ga('send','pageview');
		</script>
	</body>
</html>
