<?php Assets::add(['markdown.js']) ?>

{!!
	Form::label($f = 'profiles', _('Profiles')),
	checkboxes($f, App\Profile::dropdown(), $resource->profiles->lists('id')->all())
!!}
@if($errors->has($f))<small class="error">{{ $errors->first($f) }}</small>@endif

{!!
	Form::label($f = 'title', $labels->$f),
	Form::text($f),

	Form::label($f = 'body', $labels->$f),
	Form::textarea($f)
!!}


{{-- Live preview of Markdown --}}
<fieldset id="preview">
	<legend>{{ _('Preview') }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a id="full">{{ _('Toggle full screen') }}</a></legend>
	<h1 id="previewTitle">{!! $resource->title !!}</h1>
	<div id="previewBody">{!! markdown($resource->body) !!}</div>
</fieldset>

@section('js')
@parent
<script>
$(document).ready(function() {

	var
		$form = $("form"),
		$title = $("#title"),
		$body = $("#body"),
		$previewTitle = $("#previewTitle"),
		$previewBody = $("#previewBody"),
		$full = $("#full");

	// Cancel grid
	$form.parent().removeClass();

	// Move preview to bottom
	$('fieldset').insertAfter('#preview');

	// Live preview
	$title.keyup(function () {
		$previewTitle.text($title.val());
	});
	$body.keyup(function () {
		$previewBody.html(marked($body.val()));
	});

	// Sync scroll
	var $scrollers = $('#body, #preview');
	var syncScroll = function(e){
		var $other = $scrollers.not(this).off('scroll'), other = $other.get(0);
		var percentage = this.scrollTop / (this.scrollHeight - this.offsetHeight);
		other.scrollTop = percentage * (other.scrollHeight - other.offsetHeight);
		// Firefox workaround. Rebinding without delay isn't enough.
		setTimeout( function(){ $other.on('scroll', syncScroll ); },10);
	}
	$scrollers.on( 'scroll', syncScroll);


	// Full-screen mode
	if(screenfull.enabled)
		$full.click(function () { screenfull.toggle(); });
	else
		$full.hide();

});
</script>
@stop


@section('css')
<style>
#preview{
	max-height:25em;
	overflow-y:scroll
}
</style>
@stop
