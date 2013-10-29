@foreach ($labels as $field => $label)
<div class="{{ ($e = $errors->has($field)) ? 'error' : null }}">
	{{ Form::label($field, $label) }}
	{{ Form::text($field) }}
	@if($e)<small>{{$errors->first($field);}}</small>@endif
</div>
@endforeach
