<nav class="top-bar" data-topbar>
	<ul class="title-area">
		<li class="name"><h1>{{ link_to_route('admin', Config::get('site.name')) }}</h1></li>
		<li class="toggle-topbar menu-icon"><a href="#"><span></span></a></li>
	</ul>

	<section class="top-bar-section">

		<ul class="left">

			@if($currentUser->hasAnyPermission(60, 61, 40, 41))
			<li class="divider"></li>
			<li class="has-dropdown">

				<a>{{ _('Users') }}</a>
				<ul class="dropdown">

					{{-- Users --}}
					@if($currentUser->hasAnyPermission(60, 61))
					<li><label>{{ _('Users') }}</label></li>
					@if($currentUser->hasPermission(60))<li>{{ link_to_route('admin.users.index', _('Index')) }}@endif
					@if($currentUser->hasPermission(61))<li>{{ link_to_route('admin.users.create', _('Add')) }}@endif
					@if($currentUser->hasAnyPermission(40, 41))<li class="divider"></li>@endif
					@endif

					{{-- Profiles --}}
					@if($currentUser->hasAnyPermission(40, 41))
					<li><label>{{ _('Profiles') }}</label></li>
					@if($currentUser->hasPermission(40))<li>{{ link_to_route('admin.profiles.index', _('Index')) }}@endif
					@if($currentUser->hasPermission(41))<li>{{ link_to_route('admin.profiles.create', _('Add')) }}@endif
					@endif

				</ul>
			</li>
			@endif

			@if($currentUser->hasAnyPermission(100, 101, 80, 81))
			<li class="divider"></li>
			<li class="has-dropdown">

				<a>{{ _('Access') }}</a>
				<ul class="dropdown">

					{{-- Accounts --}}
					@if($currentUser->hasAnyPermission(100, 101))
					<li><label>{{ _('Accounts') }}</label></li>
					@if($currentUser->hasPermission(100))<li>{{ link_to_route('admin.accounts.index', _('Index')) }}@endif
					@if($currentUser->hasPermission(101))<li>{{ link_to_route('admin.accounts.create', _('Add')) }}@endif
					@if($currentUser->hasAnyPermission(80, 81))<li class="divider"></li>@endif
					@endif

					{{-- Auth providers --}}
					@if($currentUser->hasAnyPermission(80, 81))
					<li><label>{{ _('Providers') }}</label></li>
					@if($currentUser->hasPermission(80))<li>{{ link_to_route('admin.authproviders.index', _('Index')) }}@endif
					@if($currentUser->hasPermission(81))<li>{{ link_to_route('admin.authproviders.create', _('Add')) }}@endif
					@endif

				</ul>
			</li>
			@endif

			@if($currentUser->hasAnyPermission(20, 21, 10, 11, 120, 121))
			<li class="divider"></li>
			<li class="has-dropdown">

				<a>{{ _('Localization') }}</a>
				<ul class="dropdown">

					{{-- Languages --}}
					@if($currentUser->hasAnyPermission(20, 21))
					<li><label>{{ _('Languages') }}</label></li>
					@if($currentUser->hasPermission(20))<li>{{ link_to_route('admin.languages.index', _('Index')) }}@endif
					@if($currentUser->hasPermission(21))<li>{{ link_to_route('admin.languages.create', _('Add')) }}@endif
					@if($currentUser->hasAnyPermission(10, 11))<li class="divider"></li>@endif
					@endif

					{{-- Countries --}}
					@if($currentUser->hasAnyPermission(10, 11))
					<li><label>{{ _('Countries') }}</label></li>
					@if($currentUser->hasPermission(10))<li>{{ link_to_route('admin.countries.index', _('Index')) }}@endif
					@if($currentUser->hasPermission(11))<li>{{ link_to_route('admin.countries.create', _('Add')) }}@endif
					@if($currentUser->hasAnyPermission(120, 121))<li class="divider"></li>@endif
					@endif

					{{-- Currencies --}}
					@if($currentUser->hasAnyPermission(120, 121))
					<li><label>{{ _('Currencies') }}</label></li>
					@if($currentUser->hasPermission(120))<li>{{ link_to_route('admin.currencies.index', _('Index')) }}@endif
					@if($currentUser->hasPermission(121))<li>{{ link_to_route('admin.currencies.create', _('Add')) }}@endif
					@endif

				</ul>
			</li>
			@endif

		</ul>{{-- ul.left --}}

		<ul class="right">

			<li class="divider"></li>
			<li class="has-dropdown">

			{{-- Show whatever is shorter, Name or Username --}}
			<a>{{ (strlen($currentUser->name()) <= strlen($currentUser->username)) ? $currentUser->name() : $currentUser->username  }}</a>
				<ul class="dropdown">
					<li>{{ link_to_route('user.options', _('Options')) }}</li>
					<li class="divider"></li>
					<li>{{ link_to_route('logout', _('Logout'), [], ['class' => 'button alert', 'style' => 'top:0']) }}</li>
					<li class="divider"></li>
				</ul>

			</li>

			@if ($allLanguages->count() > 1)
			<li class="divider"></li>
			<li class="has-dropdown">

				<a>{{ $appLanguage->name }}</a>
				<ul class="dropdown">

					<li><label>{{ _('Change language') }}</label></li>
					@foreach ($allLanguages as $l)
					<li>{{ link_to_route('language.set', $l->name, ['code' => $l->code]) }}</li>
					@endforeach

				</ul>
			</li>
			@endif

		</ul>{{-- ul.right --}}

	</section>
</nav>
