<?php
require_once("../lib/seg.php");
if($_SESSION['tipo']!='7') header('Location: ../lib/php/common/logout.php');
require_once('../lib/conex.php');
require_once('../lib/conecciones.php');
conectar();
include("../lib/class/log.class.php");
include("../lib/class/pedidos.class.php");
$obj_pedidos= new class_pedidos;
$obj_log= new class_log;

$pedido=$_REQUEST["codigo"];
$arr_pedidos=$obj_pedidos->get_ped_sql($pedido);
$arr_dp=$obj_pedidos->get_ped_det_sql($pedido);

$user=$_SESSION['user'];
mysql_query('BEGIN');
function add_pedidos_n($doc_num,$descrip,$co_cli,$co_ven,$fec_emis,$fec_venc,$fec_reg,$anulado,$status,$total_bruto,$monto_imp,$total_neto,$fecha_aprobado){
        $query = "INSERT INTO pedidos_des (doc_num,descrip,co_cli,co_ven,fec_emis,fec_venc,fec_reg,anulado,status,total_bruto,monto_imp,total_neto,fecha_aprobado) VALUES ($doc_num,'$descrip','$co_cli','$co_ven','$fec_emis','$fec_venc','$fec_reg',$anulado,$status,$total_bruto,$monto_imp,$total_neto,'$fecha_aprobado')";
       $result=mysql_query($query);
       return $result;
}
function add_pedidos_detalles($reng_num,$doc_num,$co_art,$art_des,$co_alma,$total_art,$co_precio,$prec_vta,$porc_desc,$monto_desc,$tipo_imp,$porc_imp,$monto_imp,$co_uni,$comentario,$total_sub){
        $query = "INSERT INTO pedidos_detalles_des (reng_num,doc_num,co_art,art_des,co_alma,total_art,co_precio,prec_vta,porc_desc,monto_desc,tipo_imp,porc_imp,monto_imp,co_uni,comentario,reng_neto) VALUES ($reng_num,$doc_num,'$co_art','$art_des','$co_alma',$total_art,'$co_precio',$prec_vta,'$porc_desc',$monto_desc,'$tipo_imp',$porc_imp,$monto_imp,'$co_uni','$comentario',$total_sub)";
        $result=mysql_query($query);
        return $result;
}

for($i=0;$i<sizeof($arr_pedidos);$i++){
    $doc_num=$arr_pedidos[$i]['doc_num'];
    $descrip=$arr_pedidos[$i]['descrip'];
    $co_cli=$arr_pedidos[$i]['co_cli'];
    $co_ven=$arr_pedidos[$i]['co_ven'];
    $fec_emis=$arr_pedidos[$i]['fec_emis']->format('Y-m-d H:m:s');
    $fec_venc=$arr_pedidos[$i]['fec_venc']->format('Y-m-d H:m:s');
    $fec_reg=$arr_pedidos[$i]['fec_reg']->format('Y-m-d H:m:s');
    $anulado=0;
    $status=1;
    $total_bruto=$arr_pedidos[$i]['total_bruto'];
    $monto_imp=$arr_pedidos[$i]['monto_imp'];
    $total_neto=$arr_pedidos[$i]['total_neto'];
    $fecha_aprobado=date("Y-m-d");
    $insert=add_pedidos_n($doc_num,$descrip,$co_cli,$co_ven,$fec_emis,$fec_venc,$fec_reg,$anulado,$status,$total_bruto,$monto_imp,$total_neto,$fecha_aprobado);
    if($insert){
        $fecha=date("Y-m-d H:i:s");
        $obj_log->add_log_n($fecha, $user, 'Insercion del pedido '.$doc_num.' a facturar desde Profit a PowerSales');
    }
}
for($j=0;$j<sizeof($arr_dp);$j++){
    $reng_num=$arr_dp[$j]['reng_num'];
    $doc_num=$arr_dp[$j]['doc_num'];
    $co_art=$arr_dp[$j]['co_art'];
    $art_des=$arr_dp[$j]['art_des'];
    $co_alma=$arr_dp[$j]['co_alma'];
    $total_art=$arr_dp[$j]['total_art'];
    $co_uni=$arr_dp[$j]['co_uni'];
    $co_precio=$arr_dp[$j]['co_precio'];
    $prec_vta=$arr_dp[$j]['prec_vta'];
    $porc_desc=$arr_dp[$j]['porc_desc'];
    $monto_desc=$arr_dp[$j]['monto_desc'];
    $tipo_imp=$arr_dp[$j]['tipo_imp'];
    $porc_imp=$arr_dp[$j]['porc_imp'];
    $monto_imp=$arr_dp[$j]['monto_imp'];
    $total_sub=$arr_dp[$j]['reng_neto'];
    $comentario=$arr_dp[$j]['comentario'];
    $insert2=add_pedidos_detalles($reng_num,$doc_num,$co_art,$art_des,$co_alma,$total_art,$co_precio,$prec_vta,$porc_desc,$monto_desc,$tipo_imp,$porc_imp,$monto_imp,$co_uni,$comentario,$total_sub);
    if($insert2){
        $fecha=date("Y-m-d H:i:s");
        $obj_log->add_log_n($fecha, $user, 'Insercion del articulo '.$co_art.' la cantidad '.$total_art.' del pedido '.$doc_num.' a facturar desde Profit a PowerSales');
        mysql_query('COMMIT');
    }else{
        mysql_query('ROLLBACK');
         echo '<script language="javascript" type="text/javascript">alert("Error de transaccion, intentelo nuevamente...");window.location="detallePedidoDes.php?id='.$pedido.'";</script>';
    }
}
?>
<script language="javascript" type="text/javascript">window.location="pedidosDes.php";</script> 
