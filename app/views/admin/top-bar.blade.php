<div class="fixed contain-to-grid">
	<nav class="top-bar">
		<ul class="title-area">
			<li class="name"><h1>{{ link_to_route('admin', Config::get('site.name')) }}</h1></li>
			<li class="toggle-topbar menu-icon"><a href="#"><span></span></a></li>
		</ul>

		<section class="top-bar-section">

			<ul class="left">

				@if($user->hasAnyPermission(60, 61, 40, 41))
				<li class="divider"></li>
				<li class="has-dropdown">

					<a>{{ _('Users') }}</a>
					<ul class="dropdown">

						{{-- Users --}}
						@if($user->hasAnyPermission(60 ,61))
						<li><label>{{ _('Users') }}</label></li>
						@if($user->hasPermission(60))<li>{{ link_to_route('admin.users.index', _('Index')) }}@endif
						@if($user->hasPermission(61))<li>{{ link_to_route('admin.users.create', _('Add')) }}@endif
						@if($user->hasAnyPermission(40, 41))<li class="divider"></li>@endif
						@endif

						{{-- Profiles --}}
						@if($user->hasAnyPermission(40 ,41))
						<li><label>{{ _('Profiles') }}</label></li>
						@if($user->hasPermission(40))<li>{{ link_to_route('admin.profiles.index', _('Index')) }}@endif
						@if($user->hasPermission(41))<li>{{ link_to_route('admin.profiles.create', _('Add')) }}@endif
						@endif

					</ul>
				</li>
				@endif

				@if($user->hasAnyPermission(100, 101, 80 ,81))
				<li class="divider"></li>
				<li class="has-dropdown">

					<a>{{ _('Access') }}</a>
					<ul class="dropdown">

						{{-- Accounts --}}
						@if($user->hasAnyPermission(100 ,101))
						<li><label>{{ _('Accounts') }}</label></li>
						@if($user->hasPermission(100))<li>{{ link_to_route('admin.accounts.index', _('Index')) }}@endif
						@if($user->hasPermission(101))<li>{{ link_to_route('admin.accounts.create', _('Add')) }}@endif
						@if($user->hasAnyPermission(80, 81))<li class="divider"></li>@endif
						@endif

						{{-- Auth providers --}}
						@if($user->hasAnyPermission(80 ,81))
						<li><label>{{ _('Providers') }}</label></li>
						@if($user->hasPermission(80))<li>{{ link_to_route('admin.authproviders.index', _('Index')) }}@endif
						@if($user->hasPermission(81))<li>{{ link_to_route('admin.authproviders.create', _('Add')) }}@endif
						@endif

					</ul>
				</li>
				@endif

				@if($user->hasAnyPermission(20, 21, 10, 11))
				<li class="divider"></li>
				<li class="has-dropdown">

					<a>{{ _('Localization') }}</a>
					<ul class="dropdown">

					{{-- Languages --}}
						@if($user->hasAnyPermission(20 ,21))
						<li><label>{{ _('Languages') }}</label></li>
						@if($user->hasPermission(20))<li>{{ link_to_route('admin.languages.index', _('Index')) }}@endif
						@if($user->hasPermission(21))<li>{{ link_to_route('admin.languages.create', _('Add')) }}@endif
						@if($user->hasAnyPermission(10, 11))<li class="divider"></li>@endif
						@endif

						{{-- Auth providers --}}
						@if($user->hasAnyPermission(10 ,11))
						<li><label>{{ _('Countries') }}</label></li>
						@if($user->hasPermission(10))<li>{{ link_to_route('admin.countries.index', _('Index')) }}@endif
						@if($user->hasPermission(11))<li>{{ link_to_route('admin.countries.create', _('Add')) }}@endif
						@endif

					</ul>
				</li>
				@endif

			</ul>{{-- ul.left --}}

			<ul class="right">
				<li class="divider"></li>
				<li class="has-dropdown">

					<a>{{ _('Me') }}</a>
					<ul class="dropdown">
						<li><label>{{ _('User') }}</label></li>
						<li><a>{{ $user->name() }}</a></li>
						<li><label>{{ _('Profile') }}</label></li>
						<li><a>{{ $user->profile->name }}</a></li>
						<li>{{ link_to_route('logout', _('Logout'), [], ['class' => 'button alert']) }}</li>
					</ul>
				</li>
			</ul>{{-- ul.right --}}

		</section>
	</nav>
</div>
