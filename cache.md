# Cache keys in use

AdminController@search

	adminSearchResults{Auth:user()->id}

Language@getAllByPriority

	allLanguagesOrderedByPriority

Permission@getGroupedByType

	allPermissionsGroupedByType

PermissionType@scopeUsed

	usedPermissionTypes

Profile@getPermissions

	profile{$this->id}permissions
