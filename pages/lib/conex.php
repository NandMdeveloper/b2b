<?php
function conectar()
{
        //$con = mysql_connect('localhost', 'root', 'localhost');
        $con = mysql_connect('localhost', 'power_db', '#hGbkWpdeSD;');
	//$con = mysql_connect('192.168.0.127', 'root', 'ph2016..');
        //$con = mysql_connect('192.168.0.128', 'root', 'prohome2016');
        //$con = mysql_connect('localhost', 'grupopro_user', '#hGbkWpdeSD;');
	//mysql_select_db('grupopro_pow', $con);
        mysql_select_db('b2bfc', $con);
        mysql_set_charset('utf8');
}
?>
