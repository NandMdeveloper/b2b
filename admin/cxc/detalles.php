<?php
require_once('../lib/conex.php');
conectar();

    function get_detalles_pedido($id=''){
        $sQuery="SELECT * FROM pedidos_detalles WHERE 1 = 1 ";
       if($id) {    $sQuery.=" AND doc_num = '$id' ";   }

        $result=mysql_query($sQuery) or die(mysql_error());
        $i=0;
        while($row=mysql_fetch_array($result)){
            foreach($row as $key=>$value){
                $res_array[$i][$key]=$value;
                
            }
            $i++;
        }
        return($res_array);
    
    }
$id='38';
$id_profit='002161';
$arr_dp=get_detalles_pedido($id);
$fechaL=date("Y-m-d H:i:s");

$server = "192.168.0.10";
$options = array("UID" => "ps",  "PWD" => "#hGbkWpdeSD;",  "Database" => "ACCE");
$conn = sqlsrv_connect($server, $options);

        for($i=0;$i<sizeof($arr_dp);$i++){
            $sel="SELECT stock FROM saStockAlmacen WHERE co_alma = 'P1' AND co_art = '".$arr_dp[$i]["co_art"]."' AND tipo = 'COM'";
            $resu=sqlsrv_query($conn,$sel);
            $al=sqlsrv_fetch_array($resu);
            if($al){
                $q="UPDATE saStockAlmacen SET stock = stock + ".$arr_dp[$i]["total_art"]." WHERE co_alma = 'P1' AND co_art = '".$arr_dp[$i]["co_art"]."' AND tipo = 'COM'";
                sqlsrv_query($conn,$q);
            }else{
                $inser="INSERT INTO saStockAlmacen (co_alma,co_art,tipo,stock,revisado,trasnfe) VALUES ('P1','".$arr_dp[$i]["co_art"]."','COM',".$arr_dp[$i]["total_art"].",NULL,NULL)";
                sqlsrv_query($conn,$inser);
            }
            echo $q."<br>";
            $sql2="INSERT INTO saPedidoVentaReng (reng_num,doc_num,co_art,des_art,co_alma,total_art,stotal_art,co_uni,co_precio,prec_vta,monto_desc,tipo_imp,porc_imp,porc_imp2,porc_imp3,monto_imp,
            monto_imp2,monto_imp3,reng_neto,pendiente,pendiente2,lote_asignado,monto_desc_glob,monto_reca_glob,otros1_glob,otros2_glob,otros3_glob,monto_imp_afec_glob,monto_imp2_afec_glob,
            monto_imp3_afec_glob,total_dev,monto_dev,otros,co_us_in,fe_us_in,co_us_mo,fe_us_mo,sco_uni) VALUES (".($i+1).",'".$id_profit."','".$arr_dp[$i]["co_art"]."',null,'P1',
            ".$arr_dp[$i]["total_art"].",0,'".$arr_dp[$i]["UniCodPrincipal"]."','".$arr_dp[$i]["co_precio"]."',".$arr_dp[$i]["prec_vta"].",".$arr_dp[$i]["monto_desc"].",'1',12,0,0,".$arr_dp[$i]["monto_imp"].",0,0,".$arr_dp[$i]["total_sub"].",".$arr_dp[$i]["total_art"].",0,0,0,0,0,0,0,0,0,0,0,".$arr_dp[$i]["monto_dev"].",0,'SISPS1','".$fechaL."','SISPS1','".$fechaL."',NULL)";
            $stmt2=sqlsrv_query($conn,$sql2);
            echo $sql2;
            echo "<br>Articulo ".$arr_dp[$i]["co_art"]." Incluido al pedido <br>";
        }

?>