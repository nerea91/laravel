<div class="fixed contain-to-grid">
	<nav class="top-bar">
		<ul class="title-area">
			<li class="name"><h1>{{ link_to_route('admin', Config::get('site.name')) }}</h1></li>
			<li class="toggle-topbar menu-icon"><a href="#"><span></span></a></li>
		</ul>

		<section class="top-bar-section">

			<ul class="left">

				@if($user->hasAnyPermission(60, 61, 40, 41, 100, 101))
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
						@if($user->hasPermission(60))<li>{{ link_to_route('admin.profiles.index', _('Index')) }}@endif
						@if($user->hasPermission(61))<li>{{ link_to_route('admin.profiles.create', _('Add')) }}@endif
						@if($user->hasAnyPermission(100, 101))<li class="divider"></li>@endif
						@endif

						{{-- Accounts --}}
						@if($user->hasAnyPermission(100, 101))
						<li><label>{{ _('Accounts') }}</label></li>
						@if($user->hasPermission(100))<li>{{ link_to_route('admin.accounts.index', _('Index')) }}@endif
						@if($user->hasPermission(101))<li>{{ link_to_route('admin.accounts.create', _('Add')) }}@endif
						@endif

					</ul>
				</li>
				@endif
			</ul> {{-- ul.left --}}

			<!--<ul class="right">
				<li>aaaaaaa</li>
			</ul> {{-- ul.right --}}-->

		</section>
	</nav>
</div>
