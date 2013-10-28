@section('main')

<div class="row">
	<div class="small-11 small-centered large-6 large-centered columns">
		<dl>
			@foreach ($labels as $field => $label)
			<dt>{{ $label }}</dt>
			<dd>{{{ $resource->{$field} }}}</dd>
			@endforeach
		</dl>
	</div>
</div>
@stop
