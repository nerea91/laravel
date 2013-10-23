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

	@include('scaffold.index')

@endif
{{ link_to_route('profiles.create', _('Add profile'), null, ['class' => 'small radius button']) }}
@stop
