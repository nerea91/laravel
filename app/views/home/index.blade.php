@section('body')
<div class="row">
	<div class="large-4 columns large-centered">

		<ul class="pricing-table">
			<li class="title">{{{ Config::get('site.name') }}}</li>
			@if(Auth::check())
			<li class="price">User: {{Auth::user()->username}}</li>
			<li class="cta-button">{{ link_to_route('logout', _('Logout'), null, ['class' => 'button']) }}</li>
			@else
			<li class="price">User: none</li>
			<li class="cta-button">{{ link_to_route('login', _('Login'), null, ['class' => 'button']) }}</li>
			@endif
			<li class="description">Routes</li>
			@foreach ($routes as $name => $route)
				@if ( ! strpos($url = $route->getPath(), '{') AND in_array('GET', $route->getMethods()))
					<li class="bullet-item">{{ link_to($url, $name) }}</li>
				@endif
			@endforeach
		</ul>

	</div>
</div>
@stop

@section('css')
<style>
ul{margin-top:50px;}
</style>
@stop
