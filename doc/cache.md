# Cache keys in use

App\Composers\DebugBarComposer@compose

	debugbar

App\Http\Controllers\Admin\AdminController@search

	adminSearchResults{Auth:user()->id}

App\Language@getAllByPriority

	allLanguagesOrderedByPriority

App\Permission@getGroupedByType

	allPermissionsGroupedByType

App\PermissionType@scopeUsed

	usedPermissionTypes

App\Profile@getPermissions

	profile{$this->id}permissions
