<?php
require_once("../lib/seg.php");
if($_SESSION['tipo']!='6') header('Location: ../lib/php/common/logout.php');
require_once('../lib/conex.php');
conectar();
include("../lib/class/log.class.php");
$obj_log= new class_log;

$pedido=$_REQUEST["id"];
$fecha_old=$_REQUEST["fecha_old"];
$fecha_new=$_REQUEST["fecha_new"];
$user=$_SESSION['user'];

$sq="UPDATE pedidos_des SET fecha_despacho='$fecha_new' WHERE doc_num = $pedido";
$result=mysql_query($sq);
if($result){
	$fecha=date("Y-m-d H:i:s");
    $obj_log->add_log_n($fecha, $user, 'Pedido # '.$pedido.' | Fecha Despacho Modificada old:'.$fecha_old.' | new: '.$fecha_new);
    ?><script language="javascript" type="text/javascript">window.location="pedidosDesD.php";</script><?php
}else{
    echo '<script language="javascript" type="text/javascript">alert("Ocurrio un error, intente nuevamente...");window.location="detallePedidoDesD.php?id='.$pedido.'";</script>';
}
?>