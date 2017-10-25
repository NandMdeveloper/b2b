<?php
//if(eregi("core.lib.php", $_SERVER["PHP_SELF"]) || eregi("core.lib.php", $HTTP_SERVER_VARS["PHP_SELF"])) die("Access denied!");
if(preg_match('/'."core.lib.php".'/i', $_SERVER["PHP_SELF"])) die("Access denied!");

@session_start();
ob_start();
//config_var same directory the core.lib
require("config_var.php"); 
//conex same directory the corelib
require("conn.php"); 

//Carga de clases del sistema
require("class/TSBdQuery.class.php");
require("class/TSBdQueryProcedure.class.php");



?>

