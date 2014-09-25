<nav class="top-bar" data-topbar>
	<ul class="title-area">
		<li class="name"><h1>{!! link_to_route('home', config('site.name')) !!}</h1></li>
		<li class="toggle-topbar menu-icon"><a href="#"><span>&nbsp;</span></a></li>
	</ul>

	<section class="top-bar-section">

		{!! $menu->render() !!}

	</section>
</nav>
