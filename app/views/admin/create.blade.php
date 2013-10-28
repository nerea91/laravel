@section('main')
<div class="row">
	<div class="small-11 small-centered large-6 large-centered columns">
		{{ Form::model($resource, array('route' => "$prefix.store", 'class' => 'custom')) }}

		@include('admin.fields')

		{{ Form::submit(_('Update'), array('class' => 'small radius button left')) }}
		{{ Form::close() }}
	</div>
</div>
@stop

{{-- to-do mostrar boton para volver atras --}
