@section('title')
{{$title}} | @parent
@stop



@section('css')
<style>
input {display:block}
input[type='checkbox']{display:inline}
.error {color:red}
</style>
@stop



@section('body')
{{ Form::open(['action' => 'AuthController@doLogin']) }}

{{ Form::label('username', _('Username')) }}
{{ Form::text('username') }}
@include('form_field_errors', ['field' => 'username'])


{{ Form::label('password', _('Password')) }}
{{ Form::password('password') }}
@include('form_field_errors', ['field' => 'password'])


{{ Form::label('remember', _('Remember me')) }}
{{ Form::checkbox('remember', '1') }}

{{ Form::submit(_('Login')) }}


{{ Form::close() }}
@stop
