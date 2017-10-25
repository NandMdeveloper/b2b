<?php
//Evitamos ataques de scripts de otros sitios
if(eregi("core.php", $_SERVER["PHP_SELF"]) || eregi("core.php", $HTTP_SERVER_VARS["PHP_SELF"])) die("Access denied!");

@session_start();
ob_start();

//El config_var va en el mismo directorio del core.lib
require_once("config_var.php"); 

//El conex va en el mismo directorio del corelib
require_once("conn.php"); 



?>
