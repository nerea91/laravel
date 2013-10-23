@section('main')
@if ( ! $profiles->count())
	{{ _('There are no profiles') }}
@else
	<table>
		<thead>
			<tr>
				<th>{{ _('Name') }}</th>
				<th>{{ _('Description') }}</th>
				<th>{{ _('Actions') }}</th>
			</tr>
		</thead>

		<tbody>
			@foreach ($profiles as $profile)
				<tr>
					<td>{{{ $profile->name }}}</td>
					<td>{{{ $profile->description }}}</td>
					<td>
						{{ link_to_route('profiles.edit', _('Edit'), array($profile->id), array('class' => 'tiny radius button')) }}
						<a href="{{ route('profiles.destroy', array($profile->id)) }}" title="{{{ sprintf(_('Delete %s profile'), $profile->name) }}}" class="tiny alert radius button delete">{{ _('Delete') }}</a>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>

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
@endif
{{ link_to_route('profiles.create', _('Add profile'), null, ['class' => 'small radius button']) }}
@stop


@section('js')
<script>
$('a.button.delete').click(function(e) {
	e.preventDefault();
	$('#delete-prompt').text($(this).attr('title'));
	$('#delete-form').attr('action', $(this).attr('href')).foundation('reveal', 'open');
});
</script>
@show
