<?php
require_once("lib/seg.php");
require_once('lib/conex.php');

conectar();

$nombre=$_SESSION["nombre"];
$co_cli=$_SESSION["co_cli"];
$d=$_SESSION["cont"];
$co_ven=$_SESSION["co_ven"];

$total=$_POST["total"];
$tIva=$_POST["iva"];
$totalN=$_POST["totalN"];
$tipo_pago=$_POST["tipo_pago"];

//$iva=$total*0.12;
//$totalN=$total+$iva;
$hora=date('H:i:s');
$fecha=date('Y-m-d H:i:s');

if($d>=1){
    $query="INSERT INTO pedidos (doc_num,doc_num_p,descrip,co_cli,co_ven,fec_emis,status,total_bruto,monto_imp,total_neto,comentario) VALUES (NULL,NULL,'".$tipo_pago."','".$co_cli."','".$co_ven."','".$fecha."','1','".$total."','".$tIva."','".$totalN."','');";
    $result = @mysql_query($query);
    $ult_id=mysql_insert_id();
    if($result){
        $sql0="INSERT INTO pedidos_tipos (id,doc_num,tipo) VALUES (NULL,'".$ult_id."','".$tipo_pago."');";
        $r0 = @mysql_query($sql0);
        for($i=0;$i<$d;$i++){
            $codigo=$_POST["codigo$i"];
            $descripcion=$_POST["descripcion$i"];
            $precio=$_POST["precio$i"];
            $cantidad=$_POST["cantidad$i"];
            $subtotal=$_POST["subtotal$i"];
            $iva=($subtotal*12)/100;
            $tot=$subtotal+$iva;
            $consulta_reng_pedido="INSERT INTO pedidos_detalles (id,reng_num,doc_num,co_art,des_art,total_art,co_precio,prec_vta,total_sub,monto_imp,reng_neto,UniCodPrincipal) 
            VALUES (NULL,".($i+1).",'".$ult_id."','".$codigo."','".$descripcion."','".$cantidad."','P1','".$precio."','".$subtotal."','".$iva."','".$tot."','UND');";
            $resp = @mysql_query($consulta_reng_pedido);
        }
        $delete="DELETE FROM reng_pedido_temp WHERE co_cli='$co_cli';";
        @mysql_query($delete);
        ?>
        <script type="text/javascript">window.location="pedidos.php?status=e";</script>
        <?php 
    }else{
    ?>                
       <script type="text/javascript">alert("Ocurrio un problema al crear su pedido, intentelo  nuevamente...");window.location="procesarcar.php";</script>
    <?php
    }
}else{
    ?>                
       <script type="text/javascript">alert("Los campos estan vacios, intentelo nuevamente...");window.location="procesarcar.php";</script>
    <?php
}
?>


