<h3>{{ _('Profiles') }} <small>{{enum($resource->profiles->pluck('name')->all())}}</small></h3>

<div id ="document" class="panel">
	<h1>{!! $resource->title !!}</h1>
	{!! markdown($resource->body) !!}
</div>

@section('js')
@parent
<script>
$(document).ready(function() {

	// Cancel grid
	$('#document').parent().removeClass();

});
</script>
@stop
