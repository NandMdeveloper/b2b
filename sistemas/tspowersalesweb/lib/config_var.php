<?php
//Evitamos ataques de scripts de otros sitios
//if(eregi("config_var.lib.php", $_SERVER["PHP_SELF"]) || eregi("config_var.lib.php", $HTTP_SERVER_VARS["PHP_SELF"])) die("Access denied!");
if(preg_match('/'."core.lib.php".'/i', $_SERVER["PHP_SELF"])) die("Access denied!");
//Zona horaraia venezuela
date_default_timezone_set('America/Caracas');

//Directorios
define("APPROOT",$_SERVER['DOCUMENT_ROOT']."/tspowersalesweb/");//local

// Ej: se usa para los includes

define("DOMAIN_ROOT", "http://".$_SERVER['SERVER_NAME']."/tspowersalesweb/");//local

// fuentes de el fpdf
define('FPDF_FONTPATH',APPROOT.'font/');
//Correo
define("SEND_MAIL", "false"); //Activa � Desactiva el envio de Correo.
//carpetas
define("FOLDER_ATTACH", "files"); // atachment
//nomre sstema
define("SYSTEM_NAME","B2BFC"); // sistema

////////////////////////////////////////////
define("SERVER_LOCAL","127.0.0.1");//MYSQL
define("USER_LOCAL","power_db");//MYSQL
define("PASS_LOCAL","#hGbkWpdeSD;");//MYSQL
define("DB_LOCAL","b2bfc");

//define("DBA_MSSQL_LOCAL","mssql");
//define("tsbo01","tspspro-homeWeb");
//////////////////////////////////////////
////////////////////////////////////////////
//define("SERVER_LOCAL","192.168.0.134");//MYSQL
//define("USER_LOCAL","power_db");//MYSQL
//define("PASS_LOCAL","#hGbkWpdeSD;");//MYSQL
//define("DB_LOCAL","psdb");

//define("DBA_MSSQL_LOCAL","mssql");
define("tsbo01","tspspro-homeWeb");
//////////////////////////////////////////



?>
