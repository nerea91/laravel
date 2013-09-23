#!/bin/sh

#Get current directory (It should be the root of our Laravel project)
DIR="$( cd "$( dirname "$0" )" && pwd )"

#Owner
chown javi:nginx $DIR -R

#Default permsissions
find $DIR -type d -exec chmod 770 {} \;
find $DIR -type f -exec chmod 660 {} \;

#Exec permission for scripts
chmod 760 $DIR/artisan
find $DIR -type f -name "*.sh" -exec chmod 760 {} \;
