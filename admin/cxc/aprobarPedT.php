<?php
require_once("../lib/seg.php");
if($_SESSION['tipo']!='7') header('Location: ../lib/php/common/logout.php');
require_once('../lib/conex.php');
conectar();
//include("../lib/class/pedidos.class.php");
include("../lib/class/log.class.php");
//$obj_pedidos= new class_pedidos;
$obj_log= new class_log;

//$idP=$_REQUEST["id"];
$id=$_SESSION["pedido"];
$id_profit=$_POST["codigoP"];

//$arr_pedidos=$obj_pedidos->get_pedidos_p($idP);
//$arr_dp=$obj_pedidos->get_detalles_pedido($idP);

$fechaL=date("Y-m-d H:i:s");
$user=$_SESSION['user'];

///////////////////////////////////////////////////////////////////////////////////

$sql="UPDATE pedidos SET doc_num_p=".$id_profit.", status=3, fecha_aprobado='".$fechaL."' WHERE doc_num=".$id;
$result=@mysql_query($sql);
if($result){
    $obj_log->add_log($fechaL, $user, "Insercion del pedido ".$id."#$id_profit desde B2BFC a Profit");
    ?> <script language="javascript" type="text/javascript">window.location="adminT.php?status=a";</script> <?php
}else{
    ?> <script language="javascript" type="text/javascript">alert("Error de transaccion, intentelo nuevamente...");window.location="detallePedT.php?id=<?php echo $id; ?>";</script> <?php
}

///////////////////////////////////////////////////////////////////////////////////
/*$server = "192.168.0.121";
$options = array("UID" => "ps",  "PWD" => "#hGbkWpdeSD;",  "Database" => "ACCE");
$conn = sqlsrv_connect($server, $options);

for($i=0;$i<sizeof($arr_dp);$i++){
    $selec="SELECT * FROM saStockAlmacen WHERE co_alma = 'P1' AND co_art = '".$arr_dp[$i]["co_art"]."' AND tipo = 'COM'";
    $resulta=sqlsrv_query($conn,$selec);
    $d=sqlsrv_fetch_array($resulta);
    $comp=number_format($d["stock"]);
    $cant=$arr_dp[$i]["total_art"];
    $art_t=($comp+$cant);
    $selec2="SELECT stock FROM saStockAlmacen WHERE co_alma = 'P1' AND co_art = '".$arr_dp[$i]["co_art"]."' AND tipo = 'ACT'";
    $resulta2=sqlsrv_query($conn,$selec2);
    $d2=sqlsrv_fetch_array($resulta2);
    $act=$d2["stock"];
    if($d){
        if($art_t<=$act){
            $band=1;
        }else{
            echo '<script type="text/javascript">alert("El comprometido '.$comp.' del articulo '.$arr_dp[$i]["co_art"].' es mayor al disponible en existencia '.$act.'...");window.location="detallePedT.php?id='.$idP.'";</script>';
            exit();
        }
    }
}
if($band===1){
    $sel="SELECT Top 1 doc_num FROM saPedidoVenta Order By doc_num Desc";
    $res=sqlsrv_query($conn,$sel);
    $row=sqlsrv_fetch_array($res);
    $id="00000".($row["doc_num"]+1);
    $id_profit= substr($id, -6);
    $sql="INSERT INTO saPedidoVenta (doc_num,descrip,co_cli,co_tran,co_mone,co_ven,co_cond,fec_emis,fec_venc,fec_reg,anulado,status,total_bruto,monto_imp,
 total_neto,ven_ter,tasa,monto_desc_glob,monto_reca,monto_imp2,monto_imp3,otros1,otros2,otros3,saldo,contrib,impresa,co_us_in,fe_us_in,co_us_mo,fe_us_mo,dir_ent) 
 VALUES ('".$id_profit."','".$arr_pedidos[0]['doc_num']."-".$arr_pedidos[0]['descrip']."','".$arr_pedidos[0]['co_cli']."','00001','BSF','".$arr_pedidos[0]['co_ven']."','".$arr_pedidos[0]['co_cond']."','".$fechaL."','".$fechaL."','".$fechaL."',0,0,".$arr_pedidos[0]['total_bruto'].",".$arr_pedidos[0]['monto_imp'].",".$arr_pedidos[0]['total_neto'].",
    0,1,0,0,0,0,0,0,0,".$arr_pedidos[0]['total_neto'].",1,0,'SISPS1','".$fechaL."','SISPS1','".$fechaL."','".$arr_pedidos[0]['direc']."')";
    $stmt=sqlsrv_query($conn,$sql);
    if($stmt){
        $fecha=date("Y-m-d");
        @mysql_query("UPDATE pedidos SET doc_num_p=".$id_profit.", status=3, fecha_aprobado='".$fecha."' WHERE doc_num=".$arr_pedidos[0]['doc_num']);
        $obj_log->add_log($fechaL, $user, "Insercion del pedido ".$arr_pedidos[0]['doc_num']."#$id_profit desde B2BFC a Profit");
        
        $conn = sqlsrv_connect($server, $options);
        
        if ( sqlsrv_begin_transaction( $conn ) === false ) {
            die( print_r( sqlsrv_errors(), true ));
        }
        mysql_query('BEGIN');
        for($i=0;$i<sizeof($arr_dp);$i++){
	if($arr_dp[$i]["UniCodPrincipal"]==''){
                $codigo="SELECT co_uni FROM art WHERE co_art=".$arr_dp[$i]["co_art"];
                $rrr=mysql_query($codigo);
                $aqq=mysql_fetch_array($rrr);
                $codU=$aqq["co_uni"];
            }else{
                $codU=$arr_dp[$i]["UniCodPrincipal"];
            }
            $sel="SELECT stock FROM saStockAlmacen WHERE co_alma = 'P1' AND co_art = '".$arr_dp[$i]["co_art"]."' AND tipo = 'COM'";
            $resu=sqlsrv_query($conn,$sel);
            $al=sqlsrv_fetch_array($resu);
            if($al){
                $q="UPDATE saStockAlmacen SET stock = stock + ".$arr_dp[$i]["total_art"]." WHERE co_alma = 'P1' AND co_art = '".$arr_dp[$i]["co_art"]."' AND tipo = 'COM'";
                sqlsrv_query($conn,$q);
                $obj_log->add_log($fechaL, $user, "Comprometido Udp: Articulo ".$arr_dp[$i]['co_art']." cantidad ".$arr_dp[$i]['total_art']." del pedido #$id_profit");
            }else{
                $inser="INSERT INTO saStockAlmacen (co_alma,co_art,tipo,stock,revisado,trasnfe) VALUES ('P1','".$arr_dp[$i]["co_art"]."','COM',".$arr_dp[$i]["total_art"].",NULL,NULL)";
                sqlsrv_query($conn,$inser);
                $obj_log->add_log($fechaL, $user, "Comprometido Ins: Articulo ".$arr_dp[$i]['co_art']." cantidad ".$arr_dp[$i]['total_art']." del pedido #$id_profit");
            }
            
            $sql2="INSERT INTO saPedidoVentaReng (reng_num,doc_num,co_art,des_art,co_alma,total_art,stotal_art,co_uni,co_precio,prec_vta,monto_desc,tipo_imp,porc_imp,porc_imp2,porc_imp3,monto_imp,
            monto_imp2,monto_imp3,reng_neto,pendiente,pendiente2,lote_asignado,monto_desc_glob,monto_reca_glob,otros1_glob,otros2_glob,otros3_glob,monto_imp_afec_glob,monto_imp2_afec_glob,
            monto_imp3_afec_glob,total_dev,monto_dev,otros,co_us_in,fe_us_in,co_us_mo,fe_us_mo,sco_uni) VALUES (".($i+1).",'".$id_profit."','".$arr_dp[$i]["co_art"]."',null,'P1',
            ".$arr_dp[$i]["total_art"].",0,'".$codU."','P1',".$arr_dp[$i]["prec_vta"].",".$arr_dp[$i]["monto_desc"].",'1',12,0,0,".$arr_dp[$i]["monto_imp"].",0,0,".$arr_dp[$i]["total_sub"].",".$arr_dp[$i]["total_art"].",0,0,0,0,0,0,0,0,0,0,0,".$arr_dp[$i]["monto_dev"].",0,'SISPS1','".$fechaL."','SISPS1','".$fechaL."',NULL)";
            $stmt2=sqlsrv_query($conn,$sql2);
            $obj_log->add_log($fechaL, $user, "Insercion del articulo:".$arr_dp[$i]['co_art']." la cantidad de:".$arr_dp[$i]['total_art']." del pedido #$id_profit desde B2BFC a Profit");
        }
        mysql_query('COMMIT');
        sqlsrv_commit($conn);
        ?> <script language="javascript" type="text/javascript">window.location="adminT.php?status=a";</script> <?php 
    }else{
        sqlsrv_rollback($conn);
        mysql_query('ROLLBACK');
        ?> <script language="javascript" type="text/javascript">alert("Error de transaccion, intentelo nuevamente...");window.location="detallePedT.php?id=<?php echo $idP; ?>";</script> <?php
    }
}
sqlsrv_close($conn);
*/
?>

