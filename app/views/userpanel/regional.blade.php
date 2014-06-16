@section('main')
<div class="row">
	<div class="small-11 small-centered medium-8 large-6 columns">

	@include('userpanel.nav', array('active' => 'regional'))

	{{
		Form::model($user, array('method' => 'PUT', 'route' => 'user.regional.update')),

		Form::label($f = 'country_id', $user->getLabel($f)),
		Form::select($f, ['' => _('Unknown')] + Country::dropdown()),

		Form::label($f = 'language_id', $user->getLabel($f)),
		Form::select($f, ['' => _('Default')] + Language::dropdown()),

		Form::submit(_('Save'), ['class' => 'button']),
		Form::close()
	}}

	</div>
</div>
@stop
