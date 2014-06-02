<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>Password Reset</h2>

		<div>
			{{{ _('To reset your password, complete this form')}}: {{ URL::to('password/reset', array($token)) }}.<br/>
			{{ sprintf(_('This link will expire in %d minutes'), Config::get('auth.reminder.expire', 60)) }}.{ _('This link will expire in {{ Config::get('auth.reminder.expire', 60) }} minutes.
		</div>
	</body>
</html>
