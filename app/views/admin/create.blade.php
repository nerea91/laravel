@section('main')
<div class="row">
	<div class="small-11 small-centered large-6 large-centered columns">
		{{ Form::model($resource, array('route' => "$prefix.store", 'class' => 'custom')) }}

		@include('admin.fields')

		<div class="row">
			<div class="large-6 columns">
				{{ Form::submit(_('Add'), array('class' => 'small radius button expand')) }}
			</div>

			<div class="large-6 columns">
			{{-- If the referer page has a 'page' parameter redirect to there --}}
			@if (false !== strpos(URL::previous(), '?page=') )
				<a href="{{ URL::previous() }}" class="small radius secondary button expand">{{ _('Return') }}</a>
			@else
				{{ link_to_route("$prefix.index", _('Return'), [], array('class' => 'small radius secondary button expand')) }}
			@endif
			</div>
		</div>

		{{ Form::close() }}
	</div>
</div>
@stop

{{-- to-do mostrar boton para volver atras --}
