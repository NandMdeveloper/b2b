<?php
require_once("seg.php");
require_once('funciones.php');
conectar();
    
    $co_cli=$_SESSION["co_cli"];
    $fecha=date('Y-m-d');
    $pedido=$_REQUEST["id"];
    
    $query3="UPDATE pedidos_tes SET confirmado=1, fecha_dis='$fecha' WHERE id_pedido=$pedido";
    $result3 = @mysql_query($query3) or die(mysql_error());
    
    $q="SELECT correo FROM correos WHERE co_cli=$co_cli";
    $r = @mysql_query($q) or die(mysql_error());
    $ro = mysql_fetch_array($r);
    if($ro){
        $a=$ro["correo"];
        $asunto="Aprobación de pedido";
        $mensaje="Por medio del siguiente correo le indicamos que su pedido #$pedido fue aprobado por Cxontabilidad";
        $headers = "From: B2B Cyberlux de Venezuela <b2b@cyberlux.com.ve>\r\n"; //Quien envia?
        $headers .= "X-Mailer: PHP5\n";
        $headers .= 'MIME-Version: 1.0' . "\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n"; //
        mail($a, $asunto, $mensaje, $headers);
    }
    ?>
        <meta http-equiv="refresh" content="0; url=adminC.php?status=c">
    <?php

?>