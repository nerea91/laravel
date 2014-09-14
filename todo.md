# Pending tasks

- Create a Git hook for checking code quiality before each push
- For production update composer.json and change "minimum-stability": "dev" to "minimum-stability": "stable"
- Add reserved usernames to prevent users from having conflictive usernames.
- In user panel add a seccion to show user accoutns (other than native) and allow to revoke access.
- Add indexes to DB columns that are used in self::search() model methods

# Pending from 4.2

- Copy old app/commands/ to app/Console and check namespaces.
- Migrate old app/start/artisan.php to App\Providers\ArtisanServiceProvider.php
- Migrate old app/start/local.php to App\Providers\
- Migrate old app/views/composers/ to App and check namespaces.
- config/remote.php where is it now? When oudn add `'agent'     => false,`
- config/acl.php
- Copy old app/controlles/ to app/Http/Controllers and check namespaces.
- Copy old app/database/migrations to database/migrations and check namespaces
- Copy old app/database/seeds to database/seeds and check namespaces
- Buscar un a defincion adecuada dentro del namespace App para app/exceptions.php
- Buscar un a defincion adecuada dentro del namespace App para app/others.php
- Buscar un a defincion adecuada dentro del namespace App para /libraries/*
- Migrar los filtros
- Migrar los helpers
- Migrar los ficherosgettext del antiguo app/lang/ al nuevo resources/lang
- Migrar los modelos
- Migrar rutas
- Copiar bin/ y porbar los scrips
- Migrar el Manual
- Migrar cache.md
- Migrar phpcodesniffer.xml
- En el composer.json volver a poner versiones estable de "laravel/framework"


