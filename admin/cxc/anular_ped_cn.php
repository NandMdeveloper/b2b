<?php
require_once("../lib/seg.php");
if($_SESSION['tipo']!='7') header('Location: ../lib/php/common/logout.php');
require_once('../lib/conex.php');
conectar();

function get_ped_det($id=''){
    $sQuery="SELECT pedidos_detalles_app.*,art.art_des FROM pedidos_detalles_app INNER JOIN art ON pedidos_detalles_app.co_art = art.co_art WHERE 1 = 1";
    if($id) {   $sQuery.=" AND doc_num = '$id' ";   }
        $sQuery.="ORDER BY reng_num ASC ";
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

    $fecha=date('Y-m-d');
    $pedido=$_REQUEST["codigo"];
    $arr_detalles_pedido=get_ped_det($pedido);
    
    $query="UPDATE pedidos_app SET status=6, anulado=1, fecha_anulado='$fecha' WHERE doc_num=$pedido";
    $t=@mysql_query($query) or die(mysql_error());
    if($t){
    for($i=0;$i<sizeof($arr_detalles_pedido);$i++){
        $query2="UPDATE pedidos_detalles_app SET anulado=1 WHERE id=".$arr_detalles_pedido[$i]['id'];
        @mysql_query($query2) or die(mysql_error());
    }
    /*$q="SELECT correo FROM correos WHERE co_cli=$co_cli";
    $r = @mysql_query($q) or die(mysql_error());
    $ro = mysql_fetch_array($r);
    if($ro){
        $a=$ro["correo"];
        $asunto="Anulación de pedido";
        $mensaje="Por medio del siguiente correo le indicamos que su pedido #$pedido fue anulado por el departamento de Telemarketing";
        $headers = "From: B2B Cyberlux de Venezuela <b2b@cyberlux.com.ve>\r\n"; //Quien envia?
        $headers .= "X-Mailer: PHP5\n";
        $headers .= 'MIME-Version: 1.0' . "\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n"; //
        mail($a, $asunto, $mensaje, $headers);
    }*/
    ?>
            <meta http-equiv="refresh" content="0; url=adminT.php?status=q">
        <?php
    }else{
        echo '<script type="text/javascript">alert("Ha ocurrido un error, intente eliminar el pedido nuevamente por favor...");window.location="detallePedidoNA.php?id='.$pedido.'";</script>';
    }
?>