<?php 
if(preg_match('/'."core.lib.php".'/i', $_SERVER["PHP_SELF"])) die("Access denied!");
$link_mysql=mysql_connect(SERVER_LOCAL,USER_LOCAL,PASS_LOCAL) or die("Cound not connect to Server");
mysql_select_db(DB_LOCAL,$link_mysql) or die( "Could not open database");

?>