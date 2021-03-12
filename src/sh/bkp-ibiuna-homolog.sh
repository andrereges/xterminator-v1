#!/bin/bash
set -e

while true; do
    read -p "---------> Deseja RESTAURAR o banco de dados GRP3_IBIUNA? (s ou n) ------->" sn
    case $sn in
        [Ss]* )

        echo "------- Restauração em execução -------"

		PGPASSWORD="postgres" pg_dump -h 192.168.1.10 -U postgres --port=25432 grp3 > /var/www/html/grp3_ibiuna.sql

		PGPASSWORD="postgres" psql -v ON_ERROR_STOP=1 -h localhost -U postgres --port=25432 --<<-EOSQL

		     SELECT 
			pg_terminate_backend(pid) 
		     FROM 
		    	pg_stat_activity 
		     WHERE pid <> pg_backend_pid() 
		     AND datname = 'grp3_ibiuna';

		    DROP DATABASE IF EXISTS grp3_ibiuna;
		    CREATE DATABASE grp3_ibiuna;

		    \c grp3_ibiuna
		    \i /var/www/html/grp3_ibiuna.sql
		EOSQL

        echo "------- Restauração em concluída -------"
		break;;

        [Nn]* )

		echo "------- Cancelada a restauração GRP3 -------"
		break;;

        * ) echo "------- Respostas aceitas: S(Sim) ou N(Não) -------";;
    esac
done
