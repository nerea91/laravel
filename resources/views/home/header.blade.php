<header class="hide-for-small-only">
	<div class="row">

		<div class="medium-5 columns">
			<h1>{!! link_to_route('home', config('site.name')) !!}</h1>
			<h4>{{ $title }}</h4>
		</div>

		<div class="medium-7 columns">

			{{-- Button to change language --}}

			@if ($allLanguagesButCurrent->count())
			<a href="#" data-dropdown="language-list" class="tiny secondary button dropdown right">{{ $appLanguage->name }}</a>
			<ul id="language-list" data-dropdown-content class="f-dropdown content-disabled text-left">
				@foreach ($allLanguagesButCurrent as $l)
				<li>{!! link_to_route('language.set', $l->name, ['code' => $l->code]) !!}</li>
				@endforeach
			</ul>
			@endif

			{{-- Render menu sections --}}

			<dl class="sub-nav right">
			@foreach ($sections as $sectionTitle => $links)
				@foreach ($links as $link)
				<dd class="active">{!! $link !!}</dd>
				@endforeach
			@endforeach
			</dl>

		</div>

	</div>
</header>
