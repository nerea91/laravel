<hr/>
<dl class="sub-nav">
	<dt>{{ _('Sections') }}</dt>
	<dd class="@if($active === 'options')active @endif"><a href="{{ route('user.options') }}">{{ _('Options') }}</a></dd>
	<dd class="@if($active === 'password')active @endif"><a href="{{ route('user.password') }}">{{ _('Password') }}</a></dd>
	<dd class="@if($active === 'regional')active @endif"><a href="{{ route('user.regional') }}">{{ _('Locale') }}</a></dd>
	<dd class="@if($active === 'accounts')active @endif"><a href="{{ route('user.accounts') }}">{{ _('Accounts') }}</a></dd>
</dl>
