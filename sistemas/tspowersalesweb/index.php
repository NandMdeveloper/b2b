<?php


$server = "192.168.0.10";//PRO-HOME C.A.

//$options = array(  "UID" => "edgar",  "PWD" => "157359",  "Database" => "PSControlDB");

$options = array(  "UID" => "ps",  "PWD" => "#hGbkWpdeSD;",  "Database" => "B2BDB");

$conn = sqlsrv_connect($server, $options);
if ($conn === false) die("<pre>".print_r(sqlsrv_errors(), true));
echo "Conectado a Sql Server 2012 ok <br>";
sqlsrv_close($conn);	

?>
    
    
    