<?php 	
require_once("../../lib/seg.php");
require_once('../../lib/conex.php');
conectar();

$sql = "SELECT art.co_art,art.art_des,art.monto,art.stock FROM art where art.stock>0 AND art.monto > 0 ";
$result=mysql_query($sql) or die(mysql_error());
	while($row=mysql_fetch_array($result)){
       foreach($row as $key=>$value){
				$res_array[$i][$key]=$value;
		}
		$i++;
	}
echo json_encode($res_array);

