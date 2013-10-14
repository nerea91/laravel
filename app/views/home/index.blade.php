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
Loged in as {{Auth::user()->username}} {{HTML::linkRoute('logout', '[Log out]')}}
@else
{{HTML::linkRoute('login', '[Login]')}}
@endif
</p>

@stop
