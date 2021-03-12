<?php
require_once '../../vendor/autoload.php';

$redis = new Predis\Client();

function openRedisConnection($hostName='localhost', $port=6379) { 
global $redis; 

$redis->connect( $hostName, $port );
return $redis; 
} 

function setValueWithTtl( $key, $value, $ttl ) { 

try{ 
    global $redis; 
    $redis->setex( $key, $ttl, $value );
}catch( Exception $e ){ 
    echo $e->getMessage(); 
} 
} 

function getValueFromKey( $key ) { 
try{ 
    global $redis; 
    return $redis->get( $key);
}catch( Exception $e ){ 
    echo $e->getMessage(); 
} 
} 

function keyExists( $key ) {
try {
    global $redis;
    return $redis->exists($key);
} catch( Exception $e) {
    echo $e->getMessage();
}
}

function deleteValueFromKey( $key ) { 
try{ 
    global $redis; 
    $redis->del( $key);
}catch( Exception $e ){ 
    echo $e->getMessage(); 
} 
} 

function convertToArray( $result ) { 
$resultArray = array(); 

for( $count = 0; $row = $result->fetch_assoc(); $count++ ) 
    $resultArray[$count] = $row; 

return $resultArray; 
} 

function executeQuery( $query ){ 
    $mysqli = new mysqli( 'localhost',  'username',  'password',  'someDatabase' ); 

    if( $mysqli->connect_errno ){ 
    echo "Falha ao se conectar MySql:"."(".mysqli_connect_error().")".mysqli_connect_errno(); 
    exit();
    } 

    $result =  $mysqli->query( $query ); 
    $arrResult = convertToArray( $result );

    return $arrResult;   	 
}  

// Verifica se já existe valor para essa chave
if(! keyExists('chave1')) {

    $query = 'select * from sometable limit 1'; 
    // Chamada de função que executa nossa query
    $arrValues = executeQuery( $query );

    // Criando um string de json, também podemos usar o serialize 
    // Lembra que o Redis trabalha com String?
    $jsonValue = json_encode($arrValues);

    // Abrindo conexão com o Redis
    openRedisConnection( 'localhost', 6379 );

    // Inserindo valor com tempo de experição de 1 hora
    setValueWithTtl( 'chave1', $jsonValue, 3600);

    echo $jsonValue;
} else {
    // Busca valor no redis usando nossa chave
    $val = getValueFromKey('chave1'); 

    //  Output:  a string de json que encodamos acima quando não tinhamos no redis ainda
    echo $val;
}