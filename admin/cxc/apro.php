<?php
require_once("../lib/seg.php");
if($_SESSION['tipo']!='7') header('Location: ../lib/php/common/logout.php');
require_once('../lib/conex.php');
conectar();
include("../lib/class/pedidos.class.php");
include("../lib/class/log.class.php");
//$status=strip_tags($_GET['status']);
$id = $_REQUEST['id'];
$nombre=$_SESSION["nombre"];
//$team=$_SESSION["team"];
$user=$_SESSION["user"];
$_SESSION["pedido"]=$id;

$obj_pedidos= new class_pedidos;
$obj_log= new class_log;
mysql_query('BEGIN');

$arr_pedidos=$obj_pedidos->get_pedidos_p($id);
$arr_dp=$obj_pedidos->get_detalles_pedido($id);

$s="SELECT co_ven FROM pedidos WHERE doc_num=$id";
$resul=mysql_query($s);
$ro=mysql_fetch_array($resul);

$mes = date('m');
$ano = date('Y');
$fechaL=date("Y-m-d H:i:s");

$tipoImpuesto = array(
    7 => "3",
    9 => "2",
    12 => "1"
);


$user=$_SESSION['usuario'];

for($i=0;$i<sizeof($arr_dp);$i++){
    $a="SELECT id,asignada,actual FROM meta_art_vende WHERE mes=$mes AND ano=$ano AND co_art='".$arr_dp[$i]['co_art']."' AND co_ven='".$ro['co_ven']."' AND status=0";
    $b=mysql_query($a);
    $c=mysql_fetch_array($b);
    $suma=$arr_dp[$i]['total_art']+$c['actual'];

    if($suma>$c['asignada']){
        $art=$arr_dp[$i]['co_art'];
        $dis=$c['asignada'];
        $ban=1;
    }else{
        $d[$i]="UPDATE meta_art_vende SET actual=$suma WHERE mes=$mes AND ano=$ano AND co_art='".$arr_dp[$i]['co_art']."'";
    }
}
for($i=0;$i<sizeof($arr_dp);$i++){
    if($ban!=1){
        
    }else{
        echo '<script type="text/javascript">alert("La cantidad del articulo '.$art.' es mayor al disponible en existencia '.$dis.'...");window.location="detallePedido.php?id='.$id.'";</script>';
    }
}
if($ban!=1){
    $server = "192.168.0.10";
    $options = array("UID" => "ps",  "PWD" => "#hGbkWpdeSD;",  "Database" => "ACCE");
    $conn = sqlsrv_connect($server, $options);
    /* Iniciar la transacción. */
    if ( sqlsrv_begin_transaction( $conn ) === false ) {
        die( print_r( sqlsrv_errors(), true ));
    }

    $sel="SELECT Top 1 doc_num FROM saPedidoVenta Order By doc_num Desc";
    $res=sqlsrv_query($conn,$sel);
    $row=sqlsrv_fetch_array($res);
    $id="00000".($row["doc_num"]+1);
    $id_profit= substr($id, -6);
    // se inserta la cabecera del pedido en la base de datos de profit
    $sql="INSERT INTO saPedidoVenta (doc_num,descrip,co_cli,co_tran,co_mone,co_ven,co_cond,fec_emis,fec_venc,fec_reg,anulado,status,total_bruto,monto_imp,
    total_neto,ven_ter,tasa,monto_desc_glob,monto_reca,monto_imp2,monto_imp3,otros1,otros2,otros3,saldo,contrib,impresa,co_us_in,fe_us_in,co_us_mo,fe_us_mo,dir_ent) 
    VALUES ('".$id_profit."','".$arr_pedidos[0]['doc_num']."-".$arr_pedidos[0]['descrip']."','".$arr_pedidos[0]['co_cli']."','00001','BSF','".$arr_pedidos[0]['co_ven']."','CONTAD','".$fechaL."',
    '".$fechaL."','".$fechaL."',0,0,".$arr_pedidos[0]['total_bruto'].",".$arr_pedidos[0]['monto_imp'].",".$arr_pedidos[0]['total_neto'].",
    0,1,0,0,0,0,0,0,0,".$arr_pedidos[0]['total_neto'].",1,0,'SISPS1','".$fechaL."','SISPS1','".$fechaL."','".$arr_pedidos[0]['direc']."')";
    $stmt=sqlsrv_query($conn,$sql);
    //$result=sqlsrv_execute($stmt) or die(print_r (sqlsrv_errors()));
    if($stmt){
        sqlsrv_commit($conn);
        //echo $sql;
        mysql_query($d[$i]);
        $fecha=date("Y-m-d");
        // se actualiza el estado del pedido en la tabla pedidos de mysql para que no aparezca de nuevo en pedidos por aprobacion
        $sql = "UPDATE pedidos SET doc_num_p=".$id_profit.", status=3, fecha_aprobado='".$fecha."' WHERE doc_num=".$arr_pedidos[0]['doc_num'];
        $result = mysql_query($sql);
        $obj_log->add_log($fechaL, $user, "Insercion del pedido ".$arr_pedidos[0]['doc_num']."#$id_profit desde Powersales a Profit");
        for($i=0;$i<sizeof($arr_dp);$i++){
            // segun el numero de items del pedido se corre este for para actualizar o insertar en el stock de almacen como comprometido el articulo
            $selec="SELECT COUNT(*) as cantidad FROM saStockAlmacen WHERE co_alma = 'P1' AND tipo = 'COM' AND co_art='".$arr_dp[$i]["co_art"]."'";
            //echo "select de saStockAlmacen <br>";
            //var_dump($selec);
            $resulta=sqlsrv_query($conn,$selec);
            $b=sqlsrv_fetch_array($resulta);
            //var_dump($b);
            if($b[0]>0){
                //echo "entro en el update";
                $q="UPDATE saStockAlmacen SET stock = stock + ".$arr_dp[$i]["total_art"]." WHERE co_alma = 'P1' AND co_art = '".$arr_dp[$i]["co_art"]."' AND tipo = 'COM'";
                //var_dump($q);
                $r1 = sqlsrv_query($conn,$q);
                //var_dump($r1);
            }else{
                //echo "entro en el insert";
                $inser="INSERT INTO saStockAlmacen (co_alma,co_art,tipo,stock,revisado,trasnfe) VALUES ('P1','".$arr_dp[$i]["co_art"]."','COM',".$arr_dp[$i]["total_art"].",NULL,NULL)";
                //var_dump($inser);   
                $r1 = sqlsrv_query($conn,$inser);
                //var_dump($r1);

            }


            // TIPO DE IMPUESTO Y PORCENTAJE 2017
            $impuesto = $tipoImpuesto[$arr_pedidos[0]["OrderNumberTax"]];
            // se inserta el detalle del pedido en la tabla saPedidoVentaReng en profit 

            $sql2="INSERT INTO saPedidoVentaReng (reng_num,doc_num,co_art,des_art,co_alma,total_art,stotal_art,co_uni,co_precio,prec_vta,monto_desc,
            tipo_imp,porc_imp,porc_imp2,porc_imp3,monto_imp,monto_imp2,monto_imp3,reng_neto,pendiente,pendiente2,lote_asignado,monto_desc_glob,
             monto_reca_glob,otros1_glob,otros2_glob,otros3_glob,monto_imp_afec_glob,monto_imp2_afec_glob,monto_imp3_afec_glob,total_dev,monto_dev,
            otros,co_us_in,fe_us_in,co_us_mo,fe_us_mo,sco_uni)
            VALUES (".($i+1).",'".$id_profit."','".$arr_dp[$i]["co_art"]."',null,'P1',".$arr_dp[$i]["total_art"].",0,'".$arr_dp[$i]["UniCodPrincipal"]."',
            'P1',".$arr_dp[$i]["prec_vta"].",".$arr_dp[$i]["monto_desc"].",".$impuesto.",'".$arr_pedidos[0]["OrderNumberTax"]."',0,0,".$arr_dp[$i]["monto_imp"].",
            0,0,".$arr_dp[$i]["total_sub"].",".$arr_dp[$i]["total_art"].",0,0,0,0,0,0,0,0,0,0,0,".$arr_dp[$i]["monto_dev"].",0,'SISPS1','".$fechaL."','SISPS1','".$fechaL."',NULL)";
            $stmt2=sqlsrv_query($conn,$sql2);
            //$result2=sqlsrv_execute($stmt2) or die(print_r (sqlsrv_errors()));
            
            $obj_log->add_log($fechaL, $user, "Insercion del articulo:".$arr_dp[$i]['co_art']." la cantidad de:".$arr_dp[$i]['total_art']." del pedido #$id_profit desde Powersales a Profit");
        }
        mysql_query('COMMIT');
        ?> <script language="javascript" type="text/javascript">window.location="adminT.php?status=r";</script>  <?php 
    }else{
        sqlsrv_rollback($conn);
        mysql_query('ROLLBACK');
        ?> <script language="javascript" type="text/javascript">alert("Error de transaccion, intentelo nuevamente...");window.location="home.php";</script> <?php
    }
sqlsrv_close($conn);
}
?>
