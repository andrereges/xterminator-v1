#!/bin/sh

php -S xterminator.local:28000 -t /var/www/html/xterminator&
php -S xterminator-api.local:28001 -t /var/www/html/xterminator/src

