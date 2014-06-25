@extends('layouts.base')

<?php Assets::add('master.css') ?>

@section('body')
<header>

	<div class="row">

		<div class="large-5 columns">
		<h1>{{ link_to_route('home', Config::get('site.name')) }}</h1>
			<h4>{{{ $title }}}</h4>
		</div>

		<div class="large-7 columns">

			{{-- Button to change language --}}
			@if ($allLanguagesButCurrent->count())
			<a href="#" data-dropdown="language-list" class="tiny secondary button dropdown right">{{ $appLanguage->name }}</a>
			<ul id="language-list" data-dropdown-content class="f-dropdown content-disabled text-left">
				@foreach ($allLanguagesButCurrent as $l)
				<li>{{ link_to_route('language.set', $l->name, ['code' => $l->code, 'class' => "flag {$l->code}"]) }}</li>
				@endforeach
			</ul>
			@endif

			<dl class="sub-nav right">
				@if (Auth::check())
				<dt>{{ Auth::user() }}</dt>
				<dd class="active">{{ link_to_route('logout', _('Logout')) }}</dd>
				<dd class="active">{{ link_to_route('admin', _('Admin panel')) }}</dd>
				@else
				<dd class="active">{{ link_to_route('login', _('Login')) }}</dd>
				@endif
				<dd class="active">{{ link_to_route('contact', _('Contact')) }}</dd>
			</dl>
		</div>

	</div>

</header>

<div class="row">
@yield('main')
</div>

@stop



