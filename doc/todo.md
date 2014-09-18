# Pending tasks

- Create a Git hook for checking code quiality before each push
- For production update composer.json and change "minimum-stability": "dev" to "minimum-stability": "stable"
- Add reserved usernames to prevent users from having conflictive usernames.
- In user panel add a seccion to show user accoutns (other than native) and allow to revoke access.
- Add indexes to DB columns that are used in self::search() model methods

# Pending from 4.2

- Migrate old app/start/local.php to ¿App/Providers/?
- When all packages are migrated to V5 remove all 'repositories' entries form composer.josn and change *-develop versions to *-master
- Migrar el Manual.html
- Check the new artisan stuff:
  auth:controller              Create a stub authentication controller
  auth:login-request           Create a stub login form request
  auth:register-request        Create a stub registration form request
  make:auth                    Create auth classes for the application
  make:console                 Create a new Artisan command
  make:controller              Create a new resource controller class
  make:filter                  Create a new route filter class
  make:migration               Create a new migration file
  make:provider                Create a new service provider class
  make:request                 Create a new form request class
  route:cache                  Create a route cache file for faster route registration
  route:clear                  Remove the route cache file
