{{
	Form::label($f = 'name', $labels->$f),
	Form::text($f),

	Form::label($f = 'description', $labels->$f),
	Form::text($f)
}}

<div class="{{ ($e = $errors->has($f = 'permissions')) ? 'error' : null }}">

	{{ Form::label($f, _('Permissions'))}}
	@if($e)<small>{{ $errors->first($f) }}</small>@endif

	<?php $all = Permission::getGroupedByType(); ?>

	@foreach (PermissionType::getUsed()->lists('name', 'id') as $type_id => $type)
	{{ Form::checkboxes($f, $all[$type_id], $resource->permissions->lists('id'), ['legend' => $type]) }}
	@endforeach

</div>
