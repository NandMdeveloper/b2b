<?php
require_once("../lib/seg.php");
require_once('../lib/conex.php');
conectar();

    $user=$_SESSION["user"];
    $fecha=date('Y-m-d H:m:s');
    $pedido=$_REQUEST["id"];

    $query3="UPDATE pedidos SET status=2, fecha_preap='$fecha', comentario='Pedido aprobado por el usuario $user' WHERE doc_num=$pedido";
    $result3 = @mysql_query($query3) or die(mysql_error());

    /*$q="SELECT correo FROM correos WHERE co_cli=$co_cli";
    $r = @mysql_query($q) or die(mysql_error());
    $ro = mysql_fetch_array($r);
    if($ro){
        $a=$ro["correo"];
        $asunto="Aprobación de pedido";
        $mensaje="Por medio del siguiente correo le indicamos que su pedido #$pedido fue aprobado por Telemarketing";
        $headers = "From: B2B Cyberlux de Venezuela <b2b@cyberlux.com.ve>\r\n"; //Quien envia?
        $headers .= "X-Mailer: PHP5\n";
        $headers .= 'MIME-Version: 1.0' . "\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n"; //
        mail($a, $asunto, $mensaje, $headers);
    }*/
    if($result3){
        ?>
            <meta http-equiv="refresh" content="0; url=admin.php?status=r">
        <?php
    }else{
        echo '<script type="text/javascript">alert("No se pudo aprobar el pedido...");window.location="detallePedidoE.php?id='.$pedido.'";</script>';
    }
?>