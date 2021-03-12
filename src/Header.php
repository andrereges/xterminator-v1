<?php

if (isset($_SERVER['HTTP_ORIGIN'])) {
	header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
} else {
	header('Access-Control-Allow-Origin: *');
}

//header('Access-Control-Allow-Origin: http://192.168.1.232:8081');
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type, Set-Cookie, X-Auth-Token, X-Requested-With, Accept, Origin, Authorization, x-xsrf-token, X-File-Name, Cache-Control');
