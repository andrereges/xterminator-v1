#!bin/bash
clear

docker container exec postgres bash -c 'echo "" > /var/lib/postgresql/data/log/postgresql.log'
docker container exec postgres tail -f /var/lib/postgresql/data/log/postgresql.log
