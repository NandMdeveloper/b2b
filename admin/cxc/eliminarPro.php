<?php
require_once("../lib/seg.php");
if($_SESSION['tipo']!='7') header('Location: ../lib/php/common/logout.php');
require_once('../lib/conex.php');
conectar();
include("../lib/class/pedidos.class.php");
include("../lib/class/log.class.php");
$obj_pedidos= new class_pedidos;
$obj_log= new class_log;

$user=$_SESSION['user'];
$pedido=$_SESSION["pedido"];
$id=$_REQUEST["codigo"];
$fecha=date("Y-m-d H:i:s");
$q=$obj_pedidos->get_renglon($id);

$arr_detalles_pedido=$obj_pedidos->get_ped_det($pedido);
if(sizeof($arr_detalles_pedido)>1){
    $sql="DELETE FROM pedidos_detalles WHERE id=$id";
    $resp=@mysql_query($sql);
    if($resp){
        $obj_log->add_log($fecha, $user, "Elimino el articulo:  ".$q[0]["co_art"]." Total de articulos: ".$q[0]["total_art"]." del pedido #".$pedido);
        $arr_dp=$obj_pedidos->get_ped_det($pedido);
        for($i=0;$i<sizeof($arr_detalles_pedido);$i++){
            $tot_n+=$arr_dp[$i]['reng_neto'];
            $imp+=$arr_dp[$i]['monto_imp'];
            $tot_b+=$arr_dp[$i]['total_sub'];
        }
        $sQuery="UPDATE pedidos SET total_bruto=$tot_b, total_neto=$tot_n, monto_imp=$imp WHERE doc_num=$pedido";
        mysql_query($sQuery) or die(mysql_error());
        echo '<script type="text/javascript">window.location="detallePedT.php?id='.$pedido.'";</script>';
    }else{
        echo '<script type="text/javascript">alert("Ha ocurrido un error, intente eliminar el producto nuevamente por favor...");window.location="detallePedT.php?id='.$pedido.'";</script>';
    }
}else{
    echo '<script type="text/javascript">alert("Debera anular el pedido ya que tiene solo un articulo...");window.location="detallePedT.php?id='.$pedido.'";</script>';
}
?>
