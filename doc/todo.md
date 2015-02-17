- Ejecutar los comandos artisan uno a uno para ver si funcionan
- Ejecutar los scripts de /bin  uno a uno para ver si funcionan
- Hacer CRUD de todos los modelos uno a uno para ver si funcionan
- Comprobar que el idioma de la web y las Traducciones se cambian correctametne
- Buscar to-do pendientes
- Cuando todo este migrado volver a ejecutar codesniffer
- Paquetes: Se han quedado sin instalar los siguientes paquetes
	- Socialite: Instalarlo, configurar en .env los client_id/client_secret, dar de alta los providers y comprobar que el login social funciona.
	- Backup de base de datos. El paqiuete original no se ha actualizado todavia a L5
	- laravel SSH. De momento he dejado el comando arisan deploy que lo usa


- On production enable route:cache (add it to composer.josn scripts?)
- For production update composer.json and change "minimum-stability": "dev" to "minimum-stability": "stable"
- In user panel add a seccion to show user accounts (other than native) and allow to revoke access.
- When all packages are migrated to Laravel 5 remove all 'repositories' entries form composer.josn and change *-develop versions to *-master
- Check the new artisan stuff
