#!/bin/bash
set -e

while true; do
    read -p "---------> Deseja RESTAURAR o banco de dados GRP3? (s ou n) ------->" sn
    case $sn in
        [Ss]* )

        echo "------- Restauração em execução -------"

		PGPASSWORD="postgres" sshpass -p lliege@2020#! pg_dump -h 192.168.1.45 -U postgres --port=5432 grp3 > /var/www/html/grp3.sql

		PGPASSWORD="postgres" psql -v ON_ERROR_STOP=1 -h localhost -U postgres --port=25432 --<<-EOSQL

		     SELECT 
			pg_terminate_backend(pid) 
		     FROM 
		    	pg_stat_activity 
		     WHERE pid <> pg_backend_pid() 
		     AND datname = 'grp3';

		    DROP DATABASE IF EXISTS grp3;
		    CREATE DATABASE grp3;

		    \c grp3
		    \i /var/www/html/grp3.sql
		EOSQL

        echo "------- Restauração em concluída -------"
		break;;

        [Nn]* )

		echo "------- Cancelada a restauração GRP3 -------"
		break;;

        * ) echo "------- Respostas aceitas: S(Sim) ou N(Não) -------";;
    esac
done
