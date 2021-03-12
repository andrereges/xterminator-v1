<?php

$directory = '/var/www/html/grp3/src/Urbem';
$directoryFiles = getDirContents($directory);

echo findAdminBaseRoutePattern($directoryFiles, 'recursos-humanos/ima/exportacao-remessa-bancaria');


function getDirContents($directory, &$results = array()) {
	$directoryFile = scandir($directory, true);

	foreach ($directoryFile as $file) {

	    $path = realpath($directory . DIRECTORY_SEPARATOR . $file);

	    if (!is_dir($path)) {                
		$results[] = $path;
	    } else if ($file != "." && $file != "..") {
		getDirContents($path, $results);
		if (!is_dir($path)) {
		    $results[] = $path;
		}
	    }
	}

	return $results;
}

function findAdminBaseRoutePattern ($directoryFiles, $url) {
	foreach($directoryFiles as $absolutePathFile) {

		$file = fopen ($absolutePathFile, 'r');

		while(!feof($file))
		{
		    $line = fgets($file);

		    if (strpos($line, $url) !== false) {
			return $absolutePathFile;
		    }
		}

		fclose($file);
	}

	return false;
}

?>
