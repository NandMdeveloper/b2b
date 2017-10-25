<?php
require_once("../lib/seg.php");
if($_SESSION['tipo']!='6') header('Location: ../lib/php/common/logout.php');
require_once('../lib/conex.php');
conectar();

$id=$_REQUEST["codigo"];
$sql="UPDATE pedidos_des SET imp = '1' WHERE doc_num = $id";
$q=mysql_query($sql);
if($q){
	?><script language="javascript" type="text/javascript">window.location="pedidosDesA.php";</script><?php
}else{
	echo '<script language="javascript" type="text/javascript">alert("Ocurrio un error, intente nuevamente...");window.location="detallePedidoDesA.php?id='.$id.'";</script>';
}
?>