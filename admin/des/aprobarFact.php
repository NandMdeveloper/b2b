<?php
require_once("../lib/seg.php");
if($_SESSION['tipo']!='6') header('Location: ../lib/php/common/logout.php');
require_once('../lib/conex.php');
conectar();
include("../lib/class/log.class.php");
include("../lib/class/pedidos.class.php");
$obj_pedidos= new class_pedidos;
$obj_log= new class_log;

$pedido=$_REQUEST["id"];
$factura=$_REQUEST["factura"];
$comentario=$_REQUEST["comentario"];
$fecha=date("Y-m-d");
$user=$_SESSION['user'];

$sq="UPDATE pedidos_des SET status=2,comentario='$comentario',factura='$factura',fecha_facturado='$fecha' WHERE doc_num = $pedido";
$result=mysql_query($sq);
if($result){
	$fecha=date("Y-m-d H:i:s");
    $obj_log->add_log_n($fecha, $user, 'Pedido # '.$pedido.' | Factura # '.$factura.' Pedido a ser despachado');
    ?><script language="javascript" type="text/javascript">window.location="pedidosDesA.php";</script><?php
}else{
    echo '<script language="javascript" type="text/javascript">alert("Ocurrio un error, intente nuevamente...");window.location="detallePedidoDesA.php?id='.$pedido.'";</script>';
}
?>
 
