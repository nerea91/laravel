@section('main')
<div class="row">
	<div class="small-11 small-centered large-6 large-centered columns">
		{{ Form::model($resource, array('method' => 'PUT', 'route' => array("$prefix.update", $resource->id), 'class' => 'custom')) }}

		@include('admin.fields')

		{{ Form::submit(_('Update'), array('class' => 'small radius button left')) }}
		@if ($view)
		{{ link_to_route("$prefix.show", _('Cancel'), $resource->id, array('class' => 'small secondary radius button right')) }}
		@endif

		{{ Form::close() }}
	</div>
</div>

@stop
