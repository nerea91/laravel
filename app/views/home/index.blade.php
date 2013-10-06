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
<p>Link to test route: {{URL::route('test')}}</p>

<hr></hr>
<p>Scaffolding</p>
<p><a href="{{URL::route('users.index')}}">users</a></p>
<p><a href="{{URL::route('phones.index')}}">phones</a></p>
<p><a href="{{URL::route('posts.index')}}">posts</a></p>
<p><a href="{{URL::route('tags.index')}}">tags</a></p>
<p><a href="{{URL::route('countries.index')}}">countries</a></p>

@stop
