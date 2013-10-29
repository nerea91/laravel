#!/bin/sh

#Get current directory (It should be the root of our Laravel project)
DIR="$( cd "$( dirname "$0" )" && pwd )"

#Delete old files
find $DIR -type f -name ".*~" -exec rm {} \;

