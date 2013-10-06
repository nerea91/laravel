@section('title')
{{$title}}
@stop

@section('description')
{{$description}}
@stop

@section('body')
<p><a href="{{URL::route('users.index')}}">users</a></p>
<p><a href="{{URL::route('phones.index')}}">phones</a></p>
<p><a href="{{URL::route('posts.index')}}">posts</a></p>
<p><a href="{{URL::route('tags.index')}}">tags</a></p>
<p><a href="{{URL::route('countries.index')}}">countries</a></p>
@stop
