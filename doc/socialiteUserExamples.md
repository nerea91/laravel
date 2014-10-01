## Examples of user data responses from Socialite

After succesfully login with Socialite each call to `Socialite::with('provider')->user()` will return a `Laravel\Socialite\AbstractUser` instance with the folowing data:


### Facebook

	[token] => 'xxxYYYYzzzzzzWWWWW'
	[id] => '12345'
	[nickname] => null
	[name] => 'John Doe'
	[email] => 'john@example.com'
	[avatar] => 'https://graph.facebook.com/12345/picture?type=normal'
	[user] => array (
		[id] => '12345'
		[email] => 'john@example.com'
		[first_name] => 'John'
		[gender] => 'male'
		[last_name] => 'Doe'
		[link] => 'https://www.facebook.com/app_scoped_user_id/12345/'
		[locale] => 'en_US'
		[name] => 'John Doe'
		[timezone] => 2
		[updated_time] => '2012-07-17T17:26:49+0000'
		[verified] => true
	)

## Google

	[token] => 'xxxYYYYzzzzzzWWWWW'
	[id] => '12345'
	[nickname] => null
	[name] => 'John Doe'
	[email] => 'john@example.com'
	[avatar] => 'https://lh3.googleusercontent.com/foo/photo.jpg'
	[user] => array(
		[id] => '12345'
		[email] => 'john@example.com'
		[verified_email] => true
		[name] => 'John Doe'
		[given_name] => 'John'
		[family_name] => 'Doe'
		[link] => 'https://plus.google.com/12345'
		[picture] => 'https://lh3.googleusercontent.com/foo/photo.jpg'
		[gender] => 'male'
		[locale] => 'en'
		[hd] => 'example.com'
	)

## GitHub

	[token] => 'xxxYYYYzzzzzzWWWWW'
	[id] => 12345
	[nickname] => 'Superman'
	[name] => 'Super Man'
	[email] => null
	[avatar] => 'https://avatars.githubusercontent.com/u/12345?v=2'
	[user] => array (
		[login] => 'Superman'
		[id] => 12345
		[avatar_url] => 'https://avatars.githubusercontent.com/u/12345?v=2'
		[gravatar_id] => ''
		[url] => 'https://api.github.com/users/Superman'
		[html_url] => 'https://github.com/Superman'
		[followers_url] => 'https://api.github.com/users/Superman/followers'
		[following_url] => 'https://api.github.com/users/Superman/following{/other_user}'
		[gists_url] => 'https://api.github.com/users/Superman/gists{/gist_id}'
		[starred_url] => 'https://api.github.com/users/Superman/starred{/owner}{/repo}'
		[subscriptions_url] => 'https://api.github.com/users/Superman/subscriptions'
		[organizations_url] => 'https://api.github.com/users/Superman/orgs'
		[repos_url] => 'https://api.github.com/users/Superman/repos'
		[events_url] => 'https://api.github.com/users/Superman/events{/privacy}'
		[received_events_url] => 'https://api.github.com/users/Superman/received_events'
		[type] => 'User'
		[site_admin] => false
		[name] => 'Superman'
		[company] => null
		[blog] => null
		[location] => ''
		[email] => null
		[hireable] => true
		[bio] => null
		[public_repos] => 17
		[public_gists] => 0
		[followers] => 7
		[following] => 0
		[created_at] => '2010-01-30T01:00:42Z'
		[updated_at] => '2014-09-30T21:16:57Z'
	)

