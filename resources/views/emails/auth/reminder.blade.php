<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>{{ _('Password Reset') }}</h2>

		<div>
			{{ _('To reset your password, complete this form')}}: {{ url('password/reset', [$token]) }}.<br/>
			{{ sprintf(_('This link will expire in %d minutes'), config('auth.reminder.expire', 60)) }}.
		</div>
	</body>
</html>
