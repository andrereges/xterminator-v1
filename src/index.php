<?php
	require("Header.php");
	if ($_POST['rota']) {
		require("Funcoes.php");

		switch ($_POST['rota']) {
			case 'comando':
				// $output = getLog();
				$output = comando();
				break;
			case 'comandoComParamentro':
				$output = comandoComParamentro();
				break;
			case 'push':
				$output = comandoComParamentro();
				break;
			case 'trocaBanco':
				$output = executaTrocaBanco();
				break;
			case 'showLog':				
				$output = showLog();
				break;
			case 'clearLog':				
				$output = clearLog();
				break;
			case 'exportLog':				
				$output = exportLog();
				break;
			case 'restauraBanco':
				$output = executaRestauraBanco();
				break;
			default:
				break;
		}

		echo "<pre>$output</pre>";
		exit;
	} else {
		require_once('../pages/error.html');
		exit;
	}