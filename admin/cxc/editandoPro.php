<?php
require_once("../lib/seg.php");
if($_SESSION['tipo']!='7') header('Location: ../lib/php/common/logout.php');
require_once('../lib/conex.php');
conectar();
include("../lib/class/pedidos.class.php");
include("../lib/class/log.class.php");
$obj_pedidos= new class_pedidos;
$obj_log= new class_log;

$precio=$_REQUEST["precio"];
$coArt=$_REQUEST["coArt"];
$oldCant=$_REQUEST["oldCant"];
$id_art=$_REQUEST["idArt"];
$total_art=$_REQUEST["total_art"];
$id=$_SESSION["pedido"];
$user=$_SESSION['user'];
$fecha=date("Y-m-d H:i:s");

$sub_total=$precio*$total_art;
$iva=$sub_total*0.12;
$total_neto=$sub_total+$iva;

$query="UPDATE pedidos_detalles SET total_sub=$sub_total, reng_neto=$total_neto, monto_imp=$iva, total_art=$total_art WHERE id=$id_art";
$t=@mysql_query($query) or die(mysql_error());
if($t){
        $obj_log->add_log($fecha, $user, "Modifico el articulo: ".$coArt." de la cantidad: ".$oldCant." a la cantidad: ".$total_art." del pedido #".$id);
        $arr_dp=$obj_pedidos->get_ped_det($id);
        for($i=0;$i<sizeof($arr_dp);$i++){
            $tot_n+=$arr_dp[$i]['reng_neto'];
            $imp+=$arr_dp[$i]['monto_imp'];
            $tot_b+=$arr_dp[$i]['total_sub'];
        }
        $sQuery="UPDATE pedidos SET total_bruto=$tot_b, total_neto=$tot_n, monto_imp=$imp WHERE doc_num=$id";
        mysql_query($sQuery) or die(mysql_error());
        echo '<script type="text/javascript">window.location="detallePedT.php?id='.$id.'";</script>';
}else{
    echo '<script type="text/javascript">alert("Ocurrio un error, intente nuevamente por favor...");window.location="editarPro.php?codigo='.$id_art.'";</script>';
}
?>