{!!
	Form::label($f = 'profiles', _('Profiles')),
	Form::checkboxes($f, App\Profile::lists('name', 'id'), $resource->profiles->lists('id')->all())
!!}
@if($errors->has($f))<small class="error">{{ $errors->first($f) }}</small>@endif

{!!
	Form::label($f = 'title', $labels->$f),
	Form::text($f),

	Form::label($f = 'body', $labels->$f),
	Form::textarea($f)
!!}
