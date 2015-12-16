<div class="title-bar" data-responsive-toggle="topbar" data-hide-for="medium">
  <button class="menu-icon" type="button" data-toggle>&nbsp;</button>
  <div class="title-bar-title">Menu</div>
</div>

<div class="top-bar" id="topbar">
  <div class="top-bar-left">
    <ul class="dropdown menu" data-dropdown-menu>
      <li class="menu-text"><h1>{!! link_to_route('admin', config('site.name')) !!}</h1></li>
      {!! $menu->render() !!}
    </ul>
  </div>
  <div class="top-bar-right">
    <ul class="dropdown menu" data-dropdown-menu>
     {!! $rightmenu->render() !!}
    </ul>
  </div>
</div>