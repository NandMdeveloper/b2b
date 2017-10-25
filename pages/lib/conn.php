<?php
//Evitamos ataques de scripts de otros sitios
if(eregi("conn.lib.php", $_SERVER["PHP_SELF"]) || eregi("conn.lib.php", $HTTP_SERVER_VARS["PHP_SELF"])) die("Access denied!");

//CONEXION CON EL SERVIDOR LOCAL
//$link_mysql=mysql_connect(SERVER_LOCAL,USER_LOCAL,PASS_LOCAL) or die("No hay Conexion al Servidor");
//CONEXION CON EL SERVIDOR REMOTO
$link_mysql=mysql_connect(SERVER_REMOTE,USER_REMOTE,PASS_REMOTE) or die("No hay Conexion al Servidor........./");

//SELECCION DE LA BASE DE DATOS REMOTA
mysql_select_db(DB_REMOTE,$link_mysql) or die( "Could not open database");
//SELECCION DE LA BASE DE DATOS LOCAL
//mysql_select_db(DB_LOCAL,$link_mysql) or die( "Could not open database");
mysql_set_charset('utf8');

?>
