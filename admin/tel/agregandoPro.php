<?php
require_once("../lib/seg.php");
require_once('../lib/conex.php');
conectar();
if($_POST){
    $co_cli=$_SESSION["co_cli"];
    $pedido=$_POST["pedido"];
    
    for($i=0;$i<$_SESSION["posicion"];$i++){
        $t=0;
        $codigo=$_POST["codigo$i"];
        $precio=$_POST["precio$i"];
        $des=$_POST["desc$i"];
        $cantidad=$_POST["cantidad$i"];
        $subtotal=$precio*$cantidad;
        $iva=($subtotal*12)/100;
        $total=$subtotal+$iva;
        
        $query2="SELECT * FROM pedidos_detalles WHERE doc_num=$pedido";
        $result2 = @mysql_query($query2) or die(mysql_error());
        $t=sizeof($ro = mysql_fetch_array($result2));
        
        $reng_ped="INSERT INTO pedidos_detalles (reng_num,doc_num,co_art,des_art,total_art,co_precio,prec_vta,total_sub,monto_imp,reng_neto,UniCodPrincipal) 
            VALUES (".($t+1).",'".$pedido."','".$codigo."','','".$cantidad."','P1','".$precio."','".$subtotal."','".$iva."','".$total."','UND');";
        
        $re = @mysql_query($reng_ped);
    }
    
        $query3="SELECT * FROM pedidos_detalles WHERE doc_num=$pedido";
        $result3 = @mysql_query($query3) or die(mysql_error());
        while ($r = mysql_fetch_array($result3)) {
            $stotal+=$r["total_sub"];
            $siva+=$r["monto_imp"];
            $sstotal+=$r["reng_neto"];
        }
        
        $sQuery="UPDATE pedidos SET total_bruto=$stotal, monto_imp=$siva, total_neto=$sstotal WHERE doc_num=$pedido";
        mysql_query($sQuery) or die(mysql_error());
        
        /*$q="SELECT correo FROM correos WHERE co_cli=$co_cli";
        $r2 = @mysql_query($q) or die(mysql_error());
        $ro = mysql_fetch_array($r2);
        if($ro){
            $a=$ro["correo"];
            $asunto="Modificación de pedido";
            $mensaje="Por medio del siguiente correo le indicamos que su pedido #$pedido fue modificado exitosamente por el personal de Telemarketing";
            $headers = "From: B2B Cyberlux de Venezuela <b2b@cyberlux.com.ve>\r\n"; //Quien envia?
            $headers .= "X-Mailer: PHP5\n";
            $headers .= 'MIME-Version: 1.0' . "\n";
            $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n"; //
            mail($a, $asunto, $mensaje, $headers);
        }*/
?>
    <script type="text/javascript">window.location="detallePedidoE.php?id=<?php echo $pedido;?>";</script>

<?php
}

?>
