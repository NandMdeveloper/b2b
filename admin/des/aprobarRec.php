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
$fecha=$_REQUEST["fecha"];
$comentario=$_REQUEST["comentario"];
$user=$_SESSION['user'];

$sq="UPDATE pedidos_des SET status=4,comentario_r='$comentario',fecha_recibido='$fecha' WHERE doc_num = $pedido";
$result=mysql_query($sq);
if($result){
	$fechal=date("Y-m-d H:i:s");
    $obj_log->add_log_n($fechal, $user, 'Pedido # '.$pedido.' | Fecha: '.$fecha.' | Comentario: '.$comentario.' | Pedido recibido por el cliente');
    ?><script language="javascript" type="text/javascript">window.location="pedidosDesD.php";</script><?php
}else{
    echo '<script language="javascript" type="text/javascript">alert("Ocurrio un error, intente nuevamente...");window.location="detallePedidoDesD.php?id='.$pedido.'";</script>';
}
?>
 
