@section('main')
<div class="row">
	<div class="small-11 small-centered medium-8 large-6 columns">

	@include('userpanel.nav', array('active' => 'accounts'))

	@if ($accounts->count())
		<ul class="small-block-grid-2 text-center" data-equalizer>
			@foreach ($accounts as $account)
			<li>
				{!!
					Form::open(array('method' => 'PUT', 'route' => 'user.accounts.update', 'class' => 'panel', 'data-equalizer-watch')),
					Form::hidden('account_id', $account->getKey())
				!!}

				<p>{{ $account->provider }}</p>
				<p><img height="80" width="80" src="{{ $account->image }}" alt=""></p>

				{!!
					Form::submit(_('Revoke access'), ['class' => 'button']),
					Form::close()
				!!}
			</li>
			@endforeach
		</ul>
	@else
		<div class="alert-box" data-alert>{{ _('You have not signed in with any external provider yet') }}<a class="close">&times;</a></div>
	@endif
	</div>
</div>
@stop

