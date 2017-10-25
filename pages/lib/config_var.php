<?php

@session_start();
ob_start();

//Zona horaraia venezuela
date_default_timezone_set('America/Caracas');

//Directorios
define("APPROOT",$_SERVER['DOCUMENT_ROOT']."/powersales/");//local

// Ej: se usa para los includes
define("DOMAIN_ROOT", "http://".$_SERVER['SERVER_NAME']."/powersales/");//local

//nomre sstema
define("SYSTEM_NAME","PowerSales | Fauci, C.A."); // sistema



//CONEXION CON EL SERVIDOR LOCAL
//$link_mysql=mysql_connect(SERVER_LOCAL,USER_LOCAL,PASS_LOCAL) or die("No hay Conexion al Servidor");
//CONEXION CON EL SERVIDOR REMOTO
$link_mysql=mysql_connect('192.168.0.128','root','ph2016..') or die("No hay Conexion al Servidor........./");

//SELECCION DE LA BASE DE DATOS REMOTA
mysql_select_db('psdb',$link_mysql) or die( "Could not open database");
//SELECCION DE LA BASE DE DATOS LOCAL
//mysql_select_db(DB_LOCAL,$link_mysql) or die( "Could not open database");
mysql_set_charset('utf8');

?>
