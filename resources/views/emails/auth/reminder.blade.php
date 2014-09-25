<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>{{ _('Password Reset') }}</h2>

		<div>
			{{ _('To reset your password, complete this form')}}: {{ URL::to('password/reset', array($token)) }}.<br/>
			{{ sprintf(_('This link will expire in %d minutes'), config('auth.reminder.expire', 60)) }}.{ _('This link will expire in {{ config('auth.reminder.expire', 60) }} minutes.
		</div>
	</body>
</html>
