<ul class="off-canvas-list">

	{{-- Render menu sections --}}
	@foreach ($sections as $sectionTitle => $links)
		<li><label>{{ $sectionTitle}}</label></li>
		@foreach ($links as $link)
			<li>{{ $link }}</li>
		@endforeach
	@endforeach


	{{-- Render change language section --}}
	@if( $allLanguagesButCurrent->count())
		<li><label>{{ _('Change language') }}</label></li>
		@foreach ($allLanguagesButCurrent as $l)
			<li>{{ link_to_route('language.set', $l->name, ['code' => $l->code]) }}</li>
		@endforeach
	@endif

</ul>
