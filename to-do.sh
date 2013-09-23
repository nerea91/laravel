#!/bin/sh

#Search code for pending tasks

DIR="$( cd "$( dirname "$0" )" && pwd )" #No resolve los enlaces simbolicos
#DIR="$( cd -P "$( dirname "$0" )" && pwd )" #Resuelve los enlaces simbolicos
cd $DIR
grep -Ir --colour=auto --exclude-from=.gitignore --exclude=to-do.sh --exclude-dir=app/storage/ "to-do" .
