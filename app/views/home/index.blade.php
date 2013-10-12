@section('title')
{{$title}}
@stop

@section('description')
{{$description}}
@stop

@section('body')

<p>View: home.index</p>
<p>Current locale: {{Config::get('app.locale')}}</p>
@stop
