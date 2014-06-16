@section('body')
<div class="row">
	<div class="large-4 columns large-centered">

		<ul class="pricing-table">
			<li class="title">{{{ $title }}}</li>
			@if(Auth::check())
			<li class="price">{{ _('User')}}: {{Auth::user()->username}}</li>
			<li class="cta-button">{{ link_to_route('logout', _('Logout'), null, ['class' => 'button']) }}</li>
			@else
			<li class="price">{{ _('User')}}: none</li>
			<li class="cta-button">{{ link_to_route('login', _('Login'), null, ['class' => 'button']) }}</li>
			@endif
			<li class="description">{{ _('Routes')}}</li>
			@foreach ($routes as $name => $link)
			<li class="bullet-item">{{ $link }}</li>
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
