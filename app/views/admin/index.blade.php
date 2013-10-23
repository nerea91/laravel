{{-- Common part for all index.blade.php files --}}

{{ Form::open(['method' => 'DELETE', 'id' => 'delete-form', 'class' => 'reveal-modal small', 'style' => 'padding-bottom:0']) }}
	<h3 id="delete-prompt" class="text-center"></h3>
	<p class="lead text-center"><?= _('Are you sure?') ?></p>
	<div class="row">
		<div class="small-6 columns">
			<a onclick="$('#delete-form').foundation('reveal', 'close')" class="secondary button radius expand"><?= _('Cancel') ?></a>
		</div>

		<div class="small-6 columns">
		{{ Form::submit(_('Confirm'), array('class' => 'alert button radius expand')) }}
		</div>
	</div>
	<a class="close-reveal-modal">&#215;</a>
{{ Form::close() }}

@section('js')
<script>
$('a.button.delete').click(function(e) {
	e.preventDefault();
	$('#delete-prompt').text($(this).attr('title'));
	$('#delete-form').attr('action', $(this).attr('href')).foundation('reveal', 'open');
});
</script>
@show
