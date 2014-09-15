# Pending tasks

- Create a Git hook for checking code quiality before each push
- For production update composer.json and change "minimum-stability": "dev" to "minimum-stability": "stable"
- Add reserved usernames to prevent users from having conflictive usernames.
- In user panel add a seccion to show user accoutns (other than native) and allow to revoke access.
- Add indexes to DB columns that are used in self::search() model methods

# Pending from 4.2

- Migrate old app/start/local.php to App/Providers/
- Migrate old app/filters.php to App/Http/Filter and  App/Providers/FilterServiceProvider.php
- Migrate old app/views/composers/ to App and check namespaces.
- config/remote.php where is it now? When found add  to teh config `'agent' => false,`
- config/acl.php
- Buscar un a defincion adecuada dentro del namespace App para app/exceptions.php
- Buscar un a defincion adecuada dentro del namespace App para app/others.php
- Buscar un a defincion adecuada dentro del namespace App para /libraries/*
- Migrar los helpers
- Migrar los ficheros gettext del antiguo app/lang/ al nuevo resources/lang
- Migrar rutas
- Copiar bin/ y probar los scrips
- Migrar el Manual
- Migrar cache.md
- Migrar phpcodesniffer.xml
- En el composer.json volver a poner versiones estable de "laravel/framework"
