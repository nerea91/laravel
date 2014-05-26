<hr/>
<dl class="sub-nav">
	<dt>{{ _('Sections') }}</dt>
	<dd class="@if($active == 'options')active@endif"><a href="{{ route('user.options') }}">{{ _('Options') }}</a></dd>
	<dd class="@if($active == 'password')active@endif"><a href="{{ route('user.password') }}">{{ _('Password') }}</a></dd>
</dl>
