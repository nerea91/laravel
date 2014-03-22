# Pending tasks

- Find a way to purge cache after seeding DB
- For production update composer.json and change "minimum-stability": "dev" to "minimum-stability": "stable"
- Make usernames in lower case unique.
- Add reserved usernames to prevent users from having conflictive usernames.
- Add timezones and relate it to users.
- Send mails using a queue.
- Refactor languages/countries/currencies with the info from app-text/iso-codes
- In users index, after sorting by country the url generated for the edit button is wrong
- When adding accounts in the admin panel it doesnt check for duplicates. Add an event to do it.
- Hay una nueva regla de validacion unique_with. Buscar las migraciones que definen reglas unique con array y añadir la nueva validacion al modelo.
