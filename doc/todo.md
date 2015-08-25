- MIgrar gulpfile.js para usar dos instalaciones independientes de foundation.
- Paquetes pendientes: Se han quedado sin instalar los siguientes paquetes
	- Backup de base de datos. El paquete original no se ha actualizado todavia a L5
	- laravel SSH. De momento he dejado el comando arisan deploy que lo usa
- On production enable route:cache (Do not enable config:cache since we use closures in config files and they are not supported yet)


