@section('main')
<div class="row">
	<div class="small-11 small-centered medium-8 large-6 columns">

	@include('userpanel.nav', array('active' => 'options'))

	{{

		Form::model($user, array('method' => 'PUT', 'route' => 'user.options.update')),
		'to-do',
		Form::submit(_('Update'), ['class' => 'button']),
		Form::close()
	}}

	</div>
</div>
@stop
