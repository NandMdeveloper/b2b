<?php 	
require_once("../../lib/seg.php");
require_once('../../lib/conex.php');
conectar();

$productId = $_POST['productId'];
$sql = "SELECT monto,comentario FROM art WHERE co_art = '$productId'";
$result=mysql_query($sql) or die(mysql_error());
        while($row=mysql_fetch_array($result)){
            $res_array=$row;
        }
echo json_encode($res_array);