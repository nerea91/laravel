<ul class="off-canvas-list">

	@if (Auth::check())
		<li><label>{{ Auth::user() }}</label></li>
		<li>{{ link_to_route('logout', _('Logout')) }}</li>
		<li>{{ link_to_route('admin', _('Admin panel')) }}</li>
	@else
		<li>{{ link_to_route('login', _('Login')) }}</li>
	@endif
	<li>{{ link_to_route('contact', _('Contact')) }}</li>

	@if ($allLanguagesButCurrent->count())
		<li><label>{{ _('Change language') }}</label></li>
		@foreach ($allLanguagesButCurrent as $l)
		<li>{{ link_to_route('language.set', $l->name, ['code' => $l->code, 'class' => "flag {$l->code}"]) }}</li>
		@endforeach
	@endif
</ul>
