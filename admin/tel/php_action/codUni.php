<?php 	
require_once("../../lib/seg.php");
require_once('../../lib/conex.php');
conectar();

$productId = $_POST['productId'];
$sql = "SELECT artunidad.co_uni,artunidad.equivalencia FROM artunidad WHERE artunidad.co_art = '$productId'";
$result=mysql_query($sql) or die(mysql_error());
	while($row=mysql_fetch_array($result)){
       foreach($row as $key=>$value){
				$res_array[$i][$key]=$value;
		}
		$i++;
	}
echo json_encode($res_array);