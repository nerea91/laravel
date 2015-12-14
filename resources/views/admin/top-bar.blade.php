<!--<nav class="top-bar" data-topbar>
	<ul class="title-area">
		<li class="name"><h1>{!! link_to_route('admin', config('site.name')) !!}</h1></li>
		<li class="toggle-topbar menu-icon"><a href="#"><span>&nbsp;</span></a></li>
	</ul>

	<section class="top-bar-section">

		{!! $menu->render() !!}

	</section>
</nav>-->
<div class="top-bar">
  <div class="top-bar-left">
    <ul class="dropdown menu" data-dropdown-menu>
      <li class="menu-text"><h1>{!! link_to_route('admin', config('site.name')) !!}</h1></li>
      {!! $menu->render() !!}
    </ul>
  </div>
  <div class="top-bar-right">
    <ul class="menu">
      <li><input type="search" placeholder="Search"></li>
      <li><button type="button" class="button">Search</button></li>
    </ul>
  </div>
</div>