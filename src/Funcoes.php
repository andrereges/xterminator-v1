<?php

function executaTrocaBanco() {
	switch ($_POST['comando']) {
		case 'L':
			return trocaBanco('postgres');
			break;
		case 'LI':
			return trocaBanco('postgres', 'grp3_ibiuna', 25432);
			break;
		case 'HL':
			return trocaBanco('192.168.1.45');
			break;
		case 'HI':
			return trocaBanco('192.168.1.10', 'grp3', 25432);
			break;
		case 'PL':
			return trocaBanco('200.201.223.237', 'grp3', 25432);
			break;
		case 'PI':
			return trocaBanco('200.201.223.229', 'grp3', 25432);
			break;
		default:
			break;
	}
}

function trocaBanco($host, $baseNome='grp3', $porta=5432) {
	$myfile = fopen("/var/www/html/grp3/app/config/common/parameters.yml", "r");
	$content = '';

	while (!feof($myfile)) {
		$line = fgets($myfile);			
		if (strpos($line, 'database_host:') !== false) {
			list($chave, $valor) = explode(':', $line);
			$line = "$chave: $host".PHP_EOL;
		}
		if (strpos($line, 'database_name:') !== false) {
			list($chave, $valor) = explode(':', $line);
			$line = "$chave: $baseNome".PHP_EOL;
		}
		if (strpos($line, 'database_port:') !== false) {
			list($chave, $valor) = explode(':', $line);
			$line = "$chave: $porta".PHP_EOL;
		}

		$content .= $line;
	}

	fclose($myfile);

	$myfile = fopen("/var/www/html/grp3/app/config/common/parameters.yml", "wb");
	fwrite($myfile, $content);
	fclose($myfile);
	return "<b style='color:green; font-size:20px;'>INFORMAÇÕES DO BANCO DE DADOS</b><br><br><b>HOST:</b> $host | <b>DATABASE:</b> $baseNome | <b>PORTA:</b> $porta";
	exit;
}

function executaRestauraBanco() {
	$bancoNome = $_POST['comando']['banco_nome'];
	$arquivoCaminho = $_POST['comando']['arquivo_caminho'];
	$selectBancoRestauracao = $_POST['comando']['select_banco_restauracao'];

	switch ($selectBancoRestauracao) {
		case 'HL':
			return restauraBanco($bancoNome, $arquivoCaminho);
			break;
		case 'HI':
			return restauraBanco($bancoNome, $arquivoCaminho);
			break;
		case 'PL':
			return restauraBanco($bancoNome, $arquivoCaminho);
			break;
		case 'PI':
			return restauraBanco($bancoNome, $arquivoCaminho);
			break;
		default:
			break;
	}
}

function restauraBanco($bancoNome, $arquivoCaminho) {
//PGPASSWORD='postgres' sshpass -p lliege@2020#! pg_dump -h 192.168.1.45 -U postgres --port=5432 grp3 > $arquivoCaminho
	// shell_exec("
	// PGPASSWORD='postgres' psql -h localhost -U postgres --port=25432 --<<-EOSQL
	// 			SELECT 
	// 		pg_terminate_backend(pid) 
	// 			FROM 
	// 			pg_stat_activity 
	// 			WHERE pid <> pg_backend_pid() 
	// 			AND datname = '$bancoNome';
	// 	EOSQL
		
	// 	PGPASSWORD='postgres' psql -v ON_ERROR_STOP=1 -h localhost -U postgres --port=25432 --<<-EOSQL
	// 		\c $bancoNome
	// 		\i $arquivoCaminho
	// 	EOSQL
	// ");

	$backup = shell_exec("
		PGPASSWORD='postgres' sshpass -p lliege@2020#! pg_dump -h 192.168.1.45 -U postgres --port=5432 grp3 > /var/www/html/$bancoNome.sql
	");

	return $backup;

	shell_exec("	
		PGPASSWORD='postgres' psql -v ON_ERROR_STOP=1 -h localhost -U postgres --port=25432 --<<-EOSQL

			SELECT 
				pg_terminate_backend(pid) 
			FROM 
				pg_stat_activity 
			WHERE pid <> pg_backend_pid() 
			AND datname = '$bancoNome';

			DROP DATABASE IF EXISTS $bancoNome;
			CREATE DATABASE $bancoNome;

			\c $bancoNome
			\i $arquivoCaminho
		EOSQL
	");

	return 'Rodando backup!';
}

function comando() {
	$comando = $_POST['comando'];
	return shell_exec($comando);
}

function comandoComParamentro() {
	$comando = $_POST['comando'];
	$valorAuxiliar = $_POST['valorAuxiliar'];
	$valorAuxiliar = filter_var($valorAuxiliar, FILTER_SANITIZE_NUMBER_INT);
	
	$comando = str_replace('%valorAuxiliar%', $valorAuxiliar, $comando);
	return shell_exec($comando);
}

function push() {
	$valorAuxiliar = $_POST['valorAuxiliar'];
	$path = 'cd /var/www/html/grp3';
	$branchOrigin = shell_exec("$path && git rev-parse --abbrev-ref HEAD");
	
	$add = "$path && git add .";
	$commit = "$path && git -c user.name='Andre Reges' -c user.email='asantos@lliege.com.br' commit -m '$valorAuxiliar'";
	$push = "$path && 2>&1 git push 'git@192.168.1.12:POCS/grp3.git' $branchOrigin:$branchOrigin";

	$comando = "$add && $commit && $push";
	return shell_exec($comando);
}

function getLog() {
	$myfile = fopen("/var/www/html/xterminator/postgresql.log", "r");
	$content = '';
	
	while (!feof($myfile)) {
		$line = fgets($myfile);
		$line = preg_replace('/\s+/', ' ', strtolower($line));
		$line = explode('statement:', $line);
		
		$content .= '<pre>'.$line[0].'<pre>';
		
	}

	fclose($myfile);
	return $content;
	exit;
}

function showLog() {
	$myfile = fopen("/var/www/html/grp3/var/logs/dev.log", "r");
	$rows = [];
	$content = '';

	while (!feof($myfile)) {
		$line = fgets($myfile);
		
		foreach ($_REQUEST['options'] as $option) {
			if (stripos(strtolower($line), strtolower($option.' ')) !== false) {
				list($date, $action) = explode(' doctrine.DEBUG: ', $line);
				list($action, $parameters) = explode(' [', $action);
							
				$parameters = rtrim($parameters, "]");
				$date = $_REQUEST['showDate'] ? date('d/m/Y H:i:s', strtotime(str_replace(['[' , ']'], '', $date))).' - ' : '';
				$parameters = (trim($parameters) != ']') ? sprintf('<p>parâmetros: %s</p>', $parameters.PHP_EOL) : '';
				$rows[strtoupper($option)][] = ltrim(sprintf('%s%s%s', $date, $action.PHP_EOL, $parameters));
			}
		}
	}

	foreach ($rows as $key => $row) {
		$row = str_ireplace('parameters:', '<br><br>parameters:', $row);
		$content .= "<h1 style='color:green;'>$key</h1>".implode('<hr>', $row);
	}
	
	fclose($myfile);

	return $content;
	exit;
}

function clearLog() {
	return shell_exec('echo "" > /var/www/html/grp3/var/logs/dev.log');
	exit;
}

function exportLog() {
	$content = showLog();
	$path = '/var/www/html/xterminator/exportLog/';

	shell_exec("mkdir -p $path");
	shell_exec("chown www-data:www-data -R $path");

	$fileExported = fopen($path."exportLog".date('yyyymdhis').".html", "wb");

	fwrite($fileExported, $content);
	fclose($fileExported);
	chmod($fileExported, 0777);

	return $content;
	exit;
}
