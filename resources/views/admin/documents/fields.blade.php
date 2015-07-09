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
	<h1 id="previewTitle">{!! $resource->title !!}</h1>
	<div id="previewBody">{!! markdown($resource->body) !!}</div>
</fieldset>

@section('js')
@parent
<script>
$(document).ready(function() {

	var $form = $("form"), $title = $("#title"), $body = $("#body"), $previewTitle = $("#previewTitle"), $previewBody = $("#previewBody");

	// Cancel grid
	$form.parent().removeClass();

	// Move preview to form bottom
	$('fieldset').insertAfter($form);

	// Live preview
	$title.keyup(function () {
		$previewTitle.text($title.val());
	});
	$body.keyup(function () {
		$previewBody.html(marked($body.val()));
	});

});
</script>
@stop
