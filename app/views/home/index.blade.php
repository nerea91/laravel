@section('title')
{{$title}}
@stop

@section('description')
{{$description}}
@stop

@section('body')
<p>View: home.index</p>
<p>Current locale: {{Config::get('app.locale')}}</p>
<p>Link to home route: {{URL::route('home')}}</p>
@stop
