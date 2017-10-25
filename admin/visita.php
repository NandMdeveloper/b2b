<?php
require_once("lib/seg.php");
require_once('lib/conex.php');
conectar();

$nombre=$_SESSION["nombre"];
$team=$_SESSION["team"];
$user=$_SESSION["user"];
if($_POST){
	$rif=$_POST["id"];
	$fecha=date("Y-m-d H:i:s");
	$sql=@mysql_query("INSERT INTO evento (id,rif,user,fecha,new) VALUES (NULL, '".$rif."', '".$user."', '".$fecha."', 'n');");
	if($sql){
		print '<script type="text/javascript">window.location="evento.php";</script>';
	}else{
		print '<script type="text/javascript">alert("Ocurrio un error, intentelo de nuevo...");window.location="evento.php";</script>';
	}
}else{
	print '<script type="text/javascript">window.location="evento.php";</script>';
}
?>