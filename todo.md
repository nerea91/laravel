# Pending tasks

- app/views/admin/*/show.blade.php often show relationships without checking if current user actually has permission to see those relationships. Add permission checking on app/controllers/*Controller.php@show and make views use them.
- Create a Git hook for checking code quiality before each push
- For production update composer.json and change "minimum-stability": "dev" to "minimum-stability": "stable"
- Add reserved usernames to prevent users from having conflictive usernames.
- In user panel add a seccion to show user accoutns (other than native) and allow to revoke access.
- Add indexes to DB columns that are used in self::search() model methods
