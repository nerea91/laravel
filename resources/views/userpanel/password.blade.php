@section('main')
<div class="row">
	<div class="small-11 small-centered medium-8 large-6 columns">

		@include('userpanel.nav', array('active' => 'password'))

		{!!
			Form::model($user, array('method' => 'PUT', 'route' => 'user.password.update')),

			Form::label('current_password', _('Current password')),
			Form::password('current_password', null, ['autocomplete' => 'off']),

			Form::label('password', _('New password')),
			Form::password('password', null, ['autocomplete' => 'off']),

			Form::label('password_confirmation', _('Repeat new password')),
			Form::password('password_confirmation', null, ['autocomplete' => 'off']),

			Form::submit(_('Change password'), ['class' => 'button']),
			Form::close()
		!!}

	</div>
</div>
@stop
