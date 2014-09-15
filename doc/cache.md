# Cache keys in use

AdminController@search

	adminSearchResults{Auth:user()->id}

DebugBarComposer@compose

	debugbar

Language@getAllByPriority

	allLanguagesOrderedByPriority

Permission@getGroupedByType

	allPermissionsGroupedByType

PermissionType@scopeUsed

	usedPermissionTypes

Profile@getPermissions

	profile{$this->id}permissions
