<?php
require_once("../lib/seg.php");
require_once('../lib/conex.php');
conectar();

    $user=$_SESSION["user"];
    $fecha=date('Y-m-d');
    $pedido=$_REQUEST["codigo"];
    
    $query2="UPDATE pedidos SET anulado=1, status=6, comentario='Pedido anulado por el usuario $user', fecha_anulado='$fecha' WHERE doc_num=$pedido";
    $result2 = mysql_query($query2) or die(mysql_error());
    
    //$q="SELECT correo FROM correos WHERE co_cli=$co_cli";
    //$r = @mysql_query($q) or die(mysql_error());
    //$ro = mysql_fetch_array($r);
    if($result2){
        /*$a=$ro["correo"];
        $asunto="Anulación de pedido";
        $mensaje="Por medio del siguiente correo le indicamos que su pedido #$pedido fue anulado por el departamento de Telemarketing";
        $headers = "From: B2B Cyberlux de Venezuela <b2b@cyberlux.com.ve>\r\n"; //Quien envia?
        $headers .= "X-Mailer: PHP5\n";
        $headers .= 'MIME-Version: 1.0' . "\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n"; //
        mail($a, $asunto, $mensaje, $headers);
    */
    ?><script type="text/javascript">window.location="admin.php?status=l";</script><?php
    }else{
        echo '<script type="text/javascript">alert("No se pudo anular el pedido...");window.location="detallePedidoE.php?id='.$pedido.'";</script>';
    }
?>
