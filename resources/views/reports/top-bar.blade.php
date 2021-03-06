<div class="title-bar" style="background:#333" data-responsive-toggle="topbar" data-hide-for="medium">
  <button class="menu-icon"  style="float:right" type="button" data-toggle>&nbsp;</button>
  <div class="title-bar-title">{!! link_to_route('admin', config('site.name')) !!}</div>
</div>

<div class="top-bar" id="topbar">
  <div class="top-bar-left">
    <ul class="vertical medium-horizontal menu" data-responsive-menu="drilldown medium-dropdown">
      <li class="menu-text"><h1>{!! link_to_route('admin', config('site.name')) !!}</h1></li>
      {!! $menu->render() !!}
    </ul>
  </div>
  <div class="top-bar-right">
     <ul class="vertical medium-horizontal menu" data-responsive-menu="drilldown medium-dropdown">
     {!! $rightmenu->render() !!}
    </ul>
  </div>
</div>