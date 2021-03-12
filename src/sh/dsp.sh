#!/bin/sh
echo "\n==== Digite o comando para symfony dentro do GRP ==== \n" 
read COMMAND

docker exec -ti php-fpm5.6 bash -c ' cd /var/www/html/grp3 && php bin/console '$COMMAND
