# Cache keys in use

AdminController@search

	adminSearchResults{Auth:user()->id}

Language@getAllByPriority

	allLanguagesOrderedByPriority

Permission@getGroupedByType

	allPermissionsGroupedByType

PermissionType@scopeGetUsed

	usedPermissionTypes

Profile@getPermissions

	profile{$this->id}permissions
