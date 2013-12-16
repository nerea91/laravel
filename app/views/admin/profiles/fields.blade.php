{{
	Form::label($f = 'name', $labels->$f),
	Form::text($f),

	Form::label($f = 'description', $labels->$f),
	Form::text($f)
}}

<div id="permissions" class="{{ ($e = $errors->has($f = 'permissions')) ? 'error' : null }}">

	{{ Form::label($f, _('Permissions'))}}
	@if($e)<small>{{ $errors->first($f) }}</small>@endif
	<span class="checkbox_togglers">
		<a rel="#permissions" href="all">{{ _('all') }}</a> |
		<a rel="#permissions" href="none">{{ _('none') }}</a> |
		<a rel="#permissions" href="invert">{{ _('invert') }}</a>
	</span>

	<?php $all = Permission::getGroupedByType(); ?>

	@foreach (PermissionType::getUsed()->lists('name', 'id') as $type_id => $type)
	{{ Form::checkboxes($f, $all[$type_id], $resource->permissions->lists('id'), ['legend' => $type]) }}
	@endforeach

</div>


