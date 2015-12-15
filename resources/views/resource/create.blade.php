@section('main')
	<div class="small-12">
		<div class="small-11 small-centered large-6 large-centered columns">
			{!! Form::model($resource, array('route' => "$prefix.store")) !!}

			@include("$prefix.fields")

			<div class="row">
				<div class="small-12">
					<div class="large-6 columns">
						{!! Form::submit(_('Add'), array('class' => 'button expand')) !!}
					</div>

					<div class="large-6 columns">
						{{-- If the referer page has a 'page' parameter redirect to there --}}
						@if (false !== strpos(URL::previous(), '?page=') )
							<a href="{{ URL::previous() }}" class="secondary button expanded">{{ _('Return') }}</a>
						@else
							{!! link_to_route("$prefix.index", _('Return'), [], array('class' => 'secondary button expanded')) !!}
						@endif
					</div>
				</div>
			</div>

			{!! Form::close() !!}
		</div>
	</div>
@stop
