@section('title')
{{$title}}
@stop

@section('description')
{{$description}}
@stop

@section('body')

<p>View: home.index</p>
<p>Locale: {{Config::get('app.locale')}}</p>

<p>
@if(Auth::check())
Loged in as {{Auth::user()->username}} {{link_to_route('logout', '[Log out]')}}
@else
{{link_to_route('login', '[Login]')}}
@endif
</p>

@stop
