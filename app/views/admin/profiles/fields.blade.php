{{
	Form::label($f = 'name', $labels->$f),
	Form::text($f),

	Form::label($f = 'description', $labels->$f),
	Form::text($f)
}}

<div id="permissions" class="{{ ($e = $errors->has($f = 'permissions')) ? 'error' : null }}">

	{{ Form::label($f, _('Permissions'))}}
	@if($e)<small>{{ $errors->first($f) }}</small>@endif
	<span class="right checkbox_togglers" style="margin-top:-1.5em">
		{{ _('Select') }}:
		<a rel="#permissions" href="all">{{ _('all') }}</a> &#8226;
		<a rel="#permissions" href="none">{{ _('none') }}</a> &#8226;
		<a rel="#permissions" href="invert">{{ _('invert') }}</a>
	</span>

	<?php $all = Permission::getGroupedByType(); ?>

	@foreach (PermissionType::getUsed()->lists('name', 'id') as $type_id => $type)
	{{ Form::checkboxes($f, $all[$type_id], $resource->permissions->lists('id'), ['legend' => $type]) }}
	@endforeach

</div>




