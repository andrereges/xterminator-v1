<?php

$absolutePathFile = '/var/www/html/ARQUIVO-BANCARIO/BANESPAEDUCACAO.TXT';
$absolutePathFile = '/var/www/html/ARQUIVO-BANCARIO/8_Banco_Santander_20200731040756.txt';

checkBankFile($absolutePathFile);

function checkBankFile ($absolutePathFile) {
	$file = fopen ($absolutePathFile, 'r');

	while(!feof($file))
	{
		$line = fgets($file);
		echo strlen($line).'<br>';		
	}

	fclose($file);
}

?>
