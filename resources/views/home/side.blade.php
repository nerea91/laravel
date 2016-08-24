<ul class="submenu menu vertical" data-submenu="">
	{{-- Render menu sections --}}
	@foreach ($sections as $sectionTitle => $links)
		<li class="title">{{ $sectionTitle }}</li>
		@foreach ($links as $link)
			<li>{!! $link !!}</li>
		@endforeach
	@endforeach
	{{-- Render change language section --}}
	@if( $allLanguagesButCurrent->count())
		<li class="title">{{ _('Change language') }}</li>
		@foreach ($allLanguagesButCurrent as $l)
			<li>{!! link_to_route('language.set', $l->name, ['code' => $l->code]) !!}</li>
		@endforeach
	@endif
</ul>