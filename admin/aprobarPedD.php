<?php
require_once("seg.php");
require_once('funciones.php');
conectar();

    $co_cli=$_SESSION["co_cli"];
    $fecha=date('Y-m-d');
    $pedido=$_REQUEST["id"];
    $observaciones=$_REQUEST["observaciones"];
    
    $query3="UPDATE pedidos_tes SET status=2, fecha_des='$fecha', motivo='$observaciones' WHERE id_pedido=$pedido";
    $result3 = @mysql_query($query3) or die(mysql_error());
    
    $q="SELECT correo FROM correos WHERE co_cli=$co_cli";
    $r = @mysql_query($q) or die(mysql_error());
    $ro = mysql_fetch_array($r);
    if($ro){
        $a=$ro["correo"];
        $asunto="Despacho de pedido";
        $mensaje="Por medio del siguiente correo le indicamos que su pedido #$pedido ya fue despachado, estamos muy agradecidos por su compra.";
        $headers = "From: B2B Cyberlux de Venezuela <b2b@cyberlux.com.ve>\r\n"; //Quien envia?
        $headers .= "X-Mailer: PHP5\n";
        $headers .= 'MIME-Version: 1.0' . "\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n"; //
        mail($a, $asunto, $mensaje, $headers);
    }
    ?>
        <meta http-equiv="refresh" content="0; url=adminD.php?status=c">
    <?php

?>