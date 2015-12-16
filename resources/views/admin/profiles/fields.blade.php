{!!
	Form::label($f = 'name', $labels->$f),
	Form::text($f),

	Form::label($f = 'description', $labels->$f),
	Form::text($f)
!!}

<div id="permissions" class="{{ ($e = $errors->has($f = 'permissions')) ? 'error' : null }}">

	{!! Form::label($f, _('Permissions')) !!}
	<span class="right checkbox_togglers" style="margin-top:-1.5em">
		{{ _('Select') }}:
		<a rel="#permissions" href="all">{{ _('all') }}</a> &#8226;
		<a rel="#permissions" href="none">{{ _('none') }}</a> &#8226;
		<a rel="#permissions" href="invert">{{ _('invert') }}</a>
	</span>
	@if($e)<small class="error">{{ $errors->first($f) }}</small>@endif

	<?php $all = App\Permission::getGroupedByType(); ?>

	@foreach (App\PermissionType::inUse()->lists('name', 'id')->all() as $type_id => $type)
		{!! checkboxes($f, array_map('gettext', $all[$type_id]), $resource->permissions->lists('id')->all(), ['legend' => _($type)]) !!}
	@endforeach

</div>
