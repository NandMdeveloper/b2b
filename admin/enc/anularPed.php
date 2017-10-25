<?php
require_once("../lib/seg.php");
if($_SESSION['tipo']!='2') header('Location: ../lib/php/common/logout.php');
require_once('../lib/conex.php');
conectar();
include("../lib/class/pedidos.class.php");
$obj_pedidos= new class_pedidos;//LLAMADO A LA CLASE DE PEDIDOS

    $fecha=date('Y-m-d');
    $pedido=$_REQUEST["codigo"];
    //$observaciones_a=$_REQUEST["observaciones"];
    $user=$_SESSION["user"];
    
    $query2="UPDATE pedidos_app SET anulado=1, status=6, fecha_anulado='$fecha', comentario_a='Anulado por Gerente Regional $user ' WHERE doc_num=$pedido";
    $result2 = @mysql_query($query2) or die(mysql_error());
    /*
    $q="SELECT correo FROM correos WHERE co_cli=$co_cli";
    $r = @mysql_query($q) or die(mysql_error());
    $ro = mysql_fetch_array($r);
    if($ro){
        $a=$ro["correo"];
        $asunto="Anulación de pedido";
        $mensaje="Por medio del siguiente correo le indicamos que su pedido #$pedido fue anulado por el siguiente motivo: $observaciones";
    $headers = "From: B2B Cyberlux de Venezuela <b2b@cyberlux.com.ve>\r\n"; //Quien envia?
    $headers .= "X-Mailer: PHP5\n";
    $headers .= 'MIME-Version: 1.0' . "\n";
    $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n"; //
    mail($a, $asunto, $mensaje, $headers);
    }*/
    ?>
            <meta http-equiv="refresh" content="0; url=home.php?status=r">
       