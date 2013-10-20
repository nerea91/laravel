@section('body')

	<p>View: home.index</p>
	<p>Locale: {{Config::get('app.locale')}}</p>

	<p>
	@if(Auth::check())
		Loged in as {{Auth::user()->username}} {{link_to_route('logout', '[Log out]')}}
	@else
		{{link_to_route('login', '[Login]')}}
	@endif
	</p>

	<ul>
		@foreach ($routes as $name => $route)
			@if ( ! strpos($url = $route->getPath(), '{') AND in_array('GET', $route->getMethods()))
			<li>{{ link_to($url, $name) }}</li>
			@endif
		@endforeach
	</ul>

@stop
