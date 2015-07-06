<?php Assets::add(['marked.min.js']) ?>

{!!
	Form::label($f = 'profiles', _('Profiles')),
	Form::checkboxes($f, App\Profile::dropdown(), $resource->profiles->lists('id')->all())
!!}
@if($errors->has($f))<small class="error">{{ $errors->first($f) }}</small>@endif

{!!
	Form::label($f = 'title', $labels->$f),
	Form::text($f),

	Form::label($f = 'body', $labels->$f),
	Form::textarea($f)
!!}


{{-- Live preview of Markdown --}}
<fieldset>
	<legend>{{ _('Preview') }}</legend>
	<div id="preview"></div>
</fieldset>

@section('js')
@parent
<script>
$(document).ready(function() {

	var $form = $("form"), $source = $("#body"), $preview = $("#preview");

	// Cancel grid
	$form.parent().removeClass();

	// Move preview to form bottom
	$('fieldset').insertAfter($form);

	// Reder existing code
	$preview.html(marked($source.val()));

	// Render new code
	$source.keyup(function () {
		$preview.html(marked($source.val()));
	});

});
</script>
@stop
