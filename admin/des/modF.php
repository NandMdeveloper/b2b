<?php
require_once("../lib/seg.php");
if($_SESSION['tipo']!='6') header('Location: ../lib/php/common/logout.php');
require_once('../lib/conex.php');
conectar();
include("../lib/class/log.class.php");
$obj_log= new class_log;

$pedido=$_REQUEST["id"];
$factura_old=$_REQUEST["factura_old"];
$factura_new=$_REQUEST["factura_new"];
$user=$_SESSION['user'];

$sq="UPDATE pedidos_des SET factura='$factura_new' WHERE doc_num = $pedido";
$result=mysql_query($sq);
if($result){
	$fecha=date("Y-m-d H:i:s");
    $obj_log->add_log_n($fecha, $user, 'Pedido # '.$pedido.' | Factura Modificada old:'.$factura_old.' | new: '.$factura_new);
    ?><script language="javascript" type="text/javascript">window.location="pedidosDesF.php";</script><?php
}else{
    echo '<script language="javascript" type="text/javascript">alert("Ocurrio un error, intente nuevamente...");window.location="detallePedidoDesF.php?id='.$pedido.'";</script>';
}
?>